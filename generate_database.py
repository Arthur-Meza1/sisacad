import re
from enum import Enum

class DiaSemana(Enum):
    Lunes = 1
    Martes = 2
    Miercoles = 3
    Jueves = 4
    Viernes = 5
    Sabado = 6

class AulaTipo(Enum):
    Teoria = "Teoria"
    Laboratorio = "Laboratorio"

def procesar_archivo(archivo_entrada, archivo_salida):
    # Diccionarios para evitar duplicados
    docentes = {}
    aulas = {}
    cursos = {}

    with open(archivo_entrada, 'r', encoding='utf-8') as f:
        contenido = f.read()

    # Dividir por cursos (separados por líneas vacías)
    secciones = contenido.strip().split('\n\n')

    output_lines = []
    docente_counter = 1
    aula_counter = 1
    curso_counter = 1

    for seccion in secciones:
        lineas = seccion.strip().split('\n')
        if len(lineas) < 2:
            continue

        # Primera línea es el curso
        curso_nombre = lineas[0].strip()

        # Verificar si el curso ya existe
        if curso_nombre not in cursos:
            cursos[curso_nombre] = f"curso_{curso_counter}"
            output_lines.append(f"// Crear curso: {curso_nombre}")
            output_lines.append(f"${cursos[curso_nombre]} = Curso::create(['nombre' => '{curso_nombre}']);")
            output_lines.append("")
            curso_counter += 1

        # Procesar bloques (separados por $)
        bloques = []
        bloque_actual = []

        for linea in lineas[1:]:
            if linea.strip() == '$':
                if bloque_actual:
                    bloques.append(bloque_actual)
                    bloque_actual = []
            else:
                bloque_actual.append(linea.strip())

        # Agregar el último bloque si existe
        if bloque_actual:
            bloques.append(bloque_actual)

        # Procesar cada bloque
        for bloque in bloques:
            if len(bloque) < 4:
                continue

            # Parsear datos del bloque
            turno_linea = bloque[0]
            docente_linea = bloque[1]
            aula_linea = bloque[2]
            horario_linea = bloque[3]

            # Procesar turno
            turno = turno_linea.strip()
            es_laboratorio = turno.startswith('L')
            tipo_grupo = "laboratorio" if es_laboratorio else "teoria"
            turno_sin_l = turno[1:] if es_laboratorio else turno

            # Procesar docente
            if '#' in docente_linea:
                docente_parts = docente_linea.split('#')
                docente_nombre_email = docente_parts[0].strip()
                docente_email = docente_parts[1].strip() if len(docente_parts) > 1 else ""

                # Convertir formato "APELLIDOS, NOMBRES" a "NOMBRES APELLIDOS"
                if ',' in docente_nombre_email:
                    apellidos, nombres = docente_nombre_email.split(',', 1)
                    docente_nombre_formateado = f"{nombres.strip()} {apellidos.strip()}"
                else:
                    docente_nombre_formateado = docente_nombre_email
            else:
                docente_nombre_formateado = docente_linea.strip()
                docente_email = f"docente{docente_counter}@universidad.edu"

            # Crear docente si no existe
            docente_key = f"{docente_nombre_formateado}_{docente_email}"
            if docente_key not in docentes:
                docentes[docente_key] = f"docente_{docente_counter}"
                output_lines.append(f"// Crear docente: {docente_nombre_formateado}")
                output_lines.append(f"${docentes[docente_key]} = Docente::create(['user_id' =>")
                output_lines.append(f"      User::factory()->create([")
                output_lines.append(f"        'role' => 'teacher',")
                output_lines.append(f"        'name' => '{docente_nombre_formateado}',")
                output_lines.append(f"        'email' => '{docente_email}',")
                output_lines.append(f"      ])->id,")
                output_lines.append(f"    ]);")
                output_lines.append("")
                docente_counter += 1

            # Procesar aula
            aula_nombre = aula_linea.strip()
            tipo_aula = "laboratorio" if es_laboratorio else "teoria"
            prefijo_aula = "Laboratorio" if es_laboratorio else "Aula"
            aula_nombre_completo = f"{prefijo_aula} {aula_nombre}"

            # Crear aula si no existe
            if aula_nombre not in aulas:
                aulas[aula_nombre] = f"aula_{aula_counter}"
                output_lines.append(f"// Crear aula: {aula_nombre_completo}")
                output_lines.append(f"${aulas[aula_nombre]} = Aula::create([")
                output_lines.append(f"      'tipo' => '{tipo_aula}',")
                output_lines.append(f"      'nombre' => '{aula_nombre_completo}'")
                output_lines.append(f"    ]);")
                output_lines.append("")
                aula_counter += 1

            # Procesar horario
            if '#' in horario_linea:
                horario_parts = horario_linea.split('#')
                if len(horario_parts) >= 3:
                    dia_str = horario_parts[0].strip()
                    hora_inicio = horario_parts[1].strip()
                    hora_fin = horario_parts[2].strip()

                    # Mapear días a enum
                    dias_map = {
                        'LUNES': 'lunes',
                        'MARTES': 'martes',
                        'MIERCOLES': 'miercoles',
                        'MIÉRCOLES': 'miercoles',
                        'JUEVES': 'jueves',
                        'VIERNES': 'viernes',
                        'SABADO': 'sabado',
                        'SÁBADO': 'sabado'
                    }

                    dia_enum = dias_map.get(dia_str.upper(), 'lunes')

                    # Crear grupo de curso
                    grupo_var = f"grupo_{curso_counter}_{len(bloques)}"
                    output_lines.append(f"// Crear grupo para {curso_nombre}")
                    output_lines.append(f"${grupo_var} = GrupoCurso::create([")
                    output_lines.append(f"        'curso_id' => ${cursos[curso_nombre]}->id,")
                    output_lines.append(f"        'docente_id' => ${docentes[docente_key]}->id,")
                    output_lines.append(f"        'turno' => '{turno_sin_l}',")
                    output_lines.append(f"        'tipo' => '{tipo_grupo}',")
                    output_lines.append(f"      ]);")
                    output_lines.append("")

                    # Crear bloque horario
                    output_lines.append(f"// Crear bloque horario")
                    output_lines.append(f"BloqueHorario::create([")
                    output_lines.append(f"      'horaInicio' => '{hora_inicio}',")
                    output_lines.append(f"      'horaFin' => '{hora_fin}',")
                    output_lines.append(f"      'dia' => '{dia_enum}',")
                    output_lines.append(f"      'grupo_curso_id' => ${grupo_var}->id,")
                    output_lines.append(f"      'aula_id' => ${aulas[aula_nombre]}->id,")
                    output_lines.append(f"    ]);")
                    output_lines.append("")

    # Escribir archivo de salida
    with open(archivo_salida, 'w', encoding='utf-8') as f:
        f.write('\n'.join(output_lines))

    print(f"Archivo generado exitosamente: {archivo_salida}")
    print(f"Resumen:")
    print(f"- Cursos creados: {len(cursos)}")
    print(f"- Docentes creados: {len(docentes)}")
    print(f"- Aulas creadas: {len(aulas)}")

# Ejemplo de uso
if __name__ == "__main__":
    archivo_entrada = "datos.txt"  # Cambia por tu archivo de entrada
    archivo_salida = "datos_migracion.php"  # Archivo de salida

    procesar_archivo(archivo_entrada, archivo_salida)
