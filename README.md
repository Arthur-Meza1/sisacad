# SISACAD – Sistema Académico

## Equipo de Trabajo
**Equipo:** Amiguitos

- Diaz Vasquez Esdras Amado
- Meza Pareja Arthur Patrick
- Torres Ara Alberto Gabriel

---

## Propósito del Proyecto
SISACAD es un sistema académico desarrollado con **Laravel**, cuyo objetivo es gestionar procesos académicos como matrícula, horarios, asistencia, notas y administración de cursos, aplicando principios de **DDD (Domain-Driven Design)** y **Arquitectura Limpia**.

---

## Funcionalidades (Alto Nivel)

### Casos de Uso (UML)
![Sistema Académico](https://github.com/user-attachments/assets/0e11fcb4-c94a-4b64-97c6-79a827d909c0)

**Roles principales:**
- Administrador
- Docente
- Estudiante

**Casos de uso clave:**
- Matricular laboratorios (Estudiante)
- Crear Sesion, Guardar Asistencias, Guardar Notas (Docente)
- Crear Nuevo Usuario (Administrador)

---

## Modelo de Dominio

### Diagrama de Clases
<img width="2905" height="3105" alt="clases_uml" src="https://github.com/user-attachments/assets/1a4cd91e-f99d-4e2a-b26d-2a9778c7325f" />

---

## Visión General de Arquitectura

TODO: DIAGRAMA DE PAQUETES

### Enfoque
- **Domain-Driven Design (DDD)**
- **Arquitectura Limpia**
- Separación estricta de responsabilidades

### Capas del Sistema

#### Domain
- Entidades
- Value Objects
- Excepciones de negocio
- Interfaces de repositorio

#### Application
- Casos de uso (Commands / Queries)
- DTOs
- Transformers
- Lógica de aplicación

#### Infrastructure
- Implementaciones Eloquent
- Controllers HTTP
- Providers
- Parsers (Infra → Domain)

#### Interface / HTTP
- Controllers
- Middleware
- Autenticación

---

## Organización por Módulos

### Admin
**Responsabilidad:** Gestión administrativa del sistema

- Usuarios
- Cursos
- Temas

**Casos de uso:**
- Crear usuarios
- Listar usuarios
- Buscar cursos

### Student
**Responsabilidad:** Funcionalidades del estudiante

- Matrícula
- Horario
- Notas
- Asistencias

**Casos de uso:**
- Matricular / desmatricular
- Consultar horarios
- Ver notas

### Teacher
**Responsabilidad:** Funcionalidades del docente

- Gestión de sesiones
- Asistencia
- Notas
- Sílabos

**Casos de uso:**
- Crear sesión
- Guardar asistencia
- Descargar libreta
- Subir sílabo

---

### Documentación OpenAPI
- **Formato:** OpenAPI 3.0
- **Herramienta:** Swagger
- **URL:**

---

### Módulo: Autenticación
| Método | Endpoint | Descripción |
|------|---------|------------|
| POST | /api/login | Iniciar sesión |
| POST | /api/logout | Cerrar sesión |
| POST | /api/register | Registrar usuario |

### Módulo: Admin – Usuarios
| Método | Endpoint | Descripción |
|------|---------|------------|
| GET | /api/admin/users | Listar usuarios |
| POST | /api/admin/users | Crear usuario |
| GET | /api/admin/users/{id} | Obtener usuario |

### Módulo: Student – Matrícula
| Método | Endpoint | Descripción |
|------|---------|------------|
| GET | /api/student/cursos | Listar cursos |
| POST | /api/student/matricula | Matricular |
| DELETE | /api/student/matricula | Desmatricular |

### Módulo: Teacher – Sesiones
| Método | Endpoint | Descripción |
|------|---------|------------|
| POST | /api/teacher/sesion | Crear sesión |
| GET | /api/teacher/sesion/{id} | Obtener sesión |
| POST | /api/teacher/asistencia | Guardar asistencia |


## Pipeline CI/CD
![Pipeline](https://github.com/user-attachments/assets/9d5b912c-55e5-4941-8ead-eb6a47054135)

### Etapas

#### Construcción Automática
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`

#### Análisis Estático
- PHPStan
- Laravel Pint

#### Pruebas
- **Unitarias:** Dominio y Value Objects
- **Funcionales:** Endpoints REST
- **Seguridad:** Roles y middleware
- **Performance:** Requests concurrentes

#### Gestión de Issues
- GitHub Issues
- Etiquetas: `bug`, `feature`, `refactor`

#### Gestión de Entrega (Despliegue)
##### Entornos
- Development
- Staging
- Production
##### Herramientas
- Docker / Docker Compose
- GitHub Actions
- VPS / Cloud
