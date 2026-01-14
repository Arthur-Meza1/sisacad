# SISACAD – Sistema Académico

## Equipo de Trabajo
**Equipo:** Tilines Cabezaehuevo

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

<img width="1600" height="1352" alt="image" src="https://github.com/user-attachments/assets/8400a53a-fa9e-4fa4-b917-45c8695b8b14" />


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

```
Directorio del Projecto
├── Application
│   ├── Admin
│   │   ├── DTOs
│   │   ├── UseCase
│   │   └── Transformer
│   ├── Student
│   │   ├── DTOs
│   │   ├── UseCase
│   │   └── Transformer
│   ├── Teacher
│   │   ├── DTOs
│   │   ├── UseCase
│   │   └── Transformer
│   └── Shared
│       ├── DTOs
│       └── Transformer
│
├── Domain
│   ├── Admin
│   │   ├── Repository
│   │   └── ValueObject
│   ├── Student
│   │   ├── Entity
│   │   ├── Exception
│   │   ├── Repository
│   │   └── ValueObject
│   ├── Teacher
│   │   ├── Entity
│   │   ├── Repository
│   │   └── ValueObject
│   └── Shared
│       ├── Entity
│       ├── Exception
│       ├── Repository
│       └── ValueObject
│
├── Http
│   ├── Controllers
│   └── Middleware
│
├── Infrastructure
│   ├── Admin
│   │   ├── Controller
│   │   ├── Model
│   │   ├── Parser
│   │   ├── Provider
│   │   └── Repository
│   ├── Student
│   │   ├── Controller
│   │   ├── Model
│   │   ├── Parser
│   │   ├── Provider
│   │   └── Repository
│   ├── Teacher
│   │   ├── Controller
│   │   ├── Model
│   │   ├── Parser
│   │   ├── Provider
│   │   └── Repository
│   └── Shared
│       ├── Model
│       ├── Parser
│       ├── Provider
│       └── Repository

```

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
```
// a. Construcción Automática
  stage('Construcción Automática') {
    steps {
      echo 'Instalando dependencias y generando llaves...'
      sh "docker exec ${CONTAINER} composer install --no-interaction --prefer-dist"
      sh "docker exec ${CONTAINER} php artisan key:generate --force"
      sh "docker exec ${CONTAINER} php artisan optimize:clear"
      sh "docker exec ${CONTAINER} php artisan migrate:fresh --seed"
      sh "docker exec ${CONTAINER} npm install"
      sh "docker exec ${CONTAINER} npm run build"
    }
  }
```

#### Análisis Estático
```
// b. Análisis Estático
  stage('Análisis Estático (SonarQube)') {
    steps {
      echo 'Iniciando análisis de código...'
      sh "docker exec ${CONTAINER} ./vendor/bin/pint --test"
      sh "docker exec ${CONTAINER} composer require phpstan/phpstan --dev"
      sh "docker exec ${CONTAINER} ./vendor/bin/phpstan analyse app"
      echo 'Análisis completado'
    }
  }
```

#### Pruebas
- **Unitarias:** Dominio y Value Objects
```
// c. Pruebas Unitarias
  stage('Pruebas Unitarias (Pest)') {
    steps {
      echo 'Ejecutando pruebas unitarias y funcionales...'
      sh "docker exec ${CONTAINER} php artisan test"
    }
  }
```
- **Funcionales:** Endpoints REST
´´´
// d. Pruebas Funcionales
  stage('Pruebas Funcionales (Postman)') {
    steps {
      echo 'Iniciando pruebas de Admin, Teacher y Student...'
      sh "newman run tests/Postman/sisacad_full.json --env-var base_url=${APP_URL} --insecure --export-cookie-jar cookies.json --suppress-exit-code"
    }
  }
´´´
- **Seguridad:** Roles y middleware
```
// e. Pruebas de Performance
  stage('Pruebas de Performance') {
    steps {
      echo 'Ejecutando JMeter...'
      sh """
              printf '<?xml version="1.0" encoding="UTF-8"?><jmeterTestPlan version="1.2" properties="5.0"><hashTree><TestPlan guiclass="TestPlanGui" testclass="TestPlan" testname="Plan"/><hashTree><ThreadGroup guiclass="ThreadGroupGui" testclass="ThreadGroup" testname="Users"><intProp name="ThreadGroup.num_threads">5</intProp><intProp name="ThreadGroup.ramp_time">1</intProp><hashTree><HTTPSamplerProxy guiclass="HttpTestSampleGui" testclass="HTTPSamplerProxy"><stringProp name="HTTPSampler.path">/</stringProp><stringProp name="HTTPSampler.method">GET</stringProp></HTTPSamplerProxy><hashTree/></hashTree></ThreadGroup></hashTree></hashTree></jmeterTestPlan>' > plan_carga.jmx
              """
      sh """
              cat plan_carga.jmx | docker run --rm -i justb4/jmeter:5.5 \
              -n -t /dev/stdin \
              -l /dev/stdout \
              -Jurl=${APP_URL} > results.jtl || true
              """
    }
  }
```
- **Performance:** Requests concurrentes
```
// f. Pruebas de Seguridad
  stage('Pruebas de Seguridad (f)') {
    steps {
      echo "Escaneando con ZAP..."
      sh "docker run --rm -t owasp/zap2docker-stable zap-baseline.py -t ${APP_URL} || true"
    }
  }
```

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
