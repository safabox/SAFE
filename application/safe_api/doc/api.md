## /api/v1/alumnos ##

### `GET` /api/v1/alumnos ###

_Lista todos los alumnos_

Lista todos los alumnos

#### Filters ####

offset:

  * Requirement: \d+
  * Description: N\u00famero de p\u00e1gina.

limit:

  * Requirement: \d+
  * Description: Cantidad de elementos a retornar.
  * Default: 5

#### Response ####

[]:

  * type: array of objects (Alumno)

[][nombre]:

  * type: string

[][apellido]:

  * type: string

[][id]:

  * type: integer

[][legajo]:

  * type: string


### `GET` /api/v1/alumnos/{id} ###

_Obtiene el alumno segun el id_

#### Requirements ####

**id**

  - Type: int
  - Description: id del alumno.

#### Response ####

nombre:

  * type: string

apellido:

  * type: string

id:

  * type: integer

legajo:

  * type: string


### `GET` /api/v1/alumnos/{id}/cursos ###

_Lista todos los cusos asignados al alumno_

Lista todos los cusos asignados al alumno

#### Requirements ####

**id**

  - Type: Request
  - Description: id del alumno.

#### Filters ####

offset:

  * Requirement: \d+
  * Description: N\u00famero de p\u00e1gina.

limit:

  * Requirement: \d+
  * Description: Cantidad de elementos a retornar.
  * Default: 5

#### Response ####

[]:

  * type: array of objects (Curso)

[][id]:

  * type: integer

[][nombre]:

  * type: string

[][fecha_creacion]:

  * type: DateTime


## /api/v1/docentes ##

### `GET` /api/v1/docentes ###

_Lista todos los docentes._

Lista todos los docentes.

#### Filters ####

offset:

  * Requirement: \d+
  * Description: N\u00famero de p\u00e1gina.

limit:

  * Requirement: \d+
  * Description: Cantidad de elementos a retornar.
  * Default: 5

#### Response ####

[]:

  * type: array of objects (Docente)

[][nombre]:

  * type: string

[][apellido]:

  * type: string

[][id]:

  * type: integer


### `GET` /api/v1/docentes/{docenteId}/cursos/{id} ###

_Obtiene el detalle del curso impartido por el docente._

Obtiene el detalle del curso impartido por el docente.

#### Requirements ####

**docenteId**

  - Type: int
  - Description: id del docente.
**id**

  - Type: int
  - Description: id del curso.

#### Response ####

id:

  * type: integer

nombre:

  * type: string

fecha_creacion:

  * type: DateTime


### `GET` /api/v1/docentes/{id} ###

_Obtiene el docente según el id._

Obtiene el docente según el id.

#### Requirements ####

**id**

  - Type: int
  - Description: id del docente.

#### Response ####

nombre:

  * type: string

apellido:

  * type: string

id:

  * type: integer


### `GET` /api/v1/docentes/{id}/cursos ###

_Lista todos los cusos impartidos por el docente._

Lista todos los cusos impartidos por el docente.

#### Requirements ####

**id**

  - Type: Request
  - Description: id del docente

#### Filters ####

offset:

  * Requirement: \d+
  * Description: Numero de pagina.

limit:

  * Requirement: \d+
  * Description: Cantidad de elementos a retornar.
  * Default: 5

#### Response ####

[]:

  * type: array of objects (Curso)

[][id]:

  * type: integer

[][nombre]:

  * type: string

[][fecha_creacion]:

  * type: DateTime


## /api/v1/usuarios ##

### `GET` /api/v1/usuarios ###

_Listado de usuarios disponibles en el sistema._

Listado de usuarios disponibles en el sistema.

#### Filters ####

offset:

  * Requirement: \d+
  * Description: N\u00famero de p\u00e1gina.

limit:

  * Requirement: \d+
  * Description: Cantidad de elementos a retornar.
  * Default: 5

#### Response ####

[]:

  * type: array of objects (Usuario)

[][username]:

  * type: 

[][email]:

  * type: 

[][plainPassword]:

  * type: 

[][nombre]:

  * type: string

[][apellido]:

  * type: string

[][avatar]:

  * type: string

[][id]:

  * type: integer


### `POST` /api/v1/usuarios ###

_Crea un nuevo usuario_

#### Parameters ####

usuario:

  * type: object (UsuarioType)
  * required: true

usuario[nombre]:

  * type: string
  * required: true

usuario[apellido]:

  * type: string
  * required: true

usuario[avatar]:

  * type: string
  * required: true

usuario[username]:

  * type: string
  * required: true

usuario[email]:

  * type: string
  * required: true

usuario[plainPassword]:

  * type: object (RepeatedType)
  * required: true

usuario[plainPassword][first]:

  * type: string
  * required: true
  * description: form.password

usuario[plainPassword][second]:

  * type: string
  * required: true
  * description: form.password_confirmation

usuario[roles][]:

  * type: array of choices
  * required: true

alumno:

  * type: object (AlumnoFlatType)
  * required: true

alumno[legajo]:

  * type: string
  * required: true

docente:

  * type: object (DocenteFlatType)
  * required: true

docente[curriculum]:

  * type: string
  * required: true


### `GET` /api/v1/usuarios/{id} ###

_Obtiene el usuario segun el id_

#### Requirements ####

**id**

  - Type: int
  - Description: id del alumno.

#### Response ####

username:

  * type: 

email:

  * type: 

plainPassword:

  * type: 

nombre:

  * type: string

apellido:

  * type: string

avatar:

  * type: string

id:

  * type: integer
