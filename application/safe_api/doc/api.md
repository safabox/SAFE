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

[][id]:

  * type: integer

[][nombre]:

  * type: string

[][apellido]:

  * type: string

[][legajo]:

  * type: string


### `GET` /api/v1/alumnos/{id} ###

_Obtiene el alumno segun el id_

#### Requirements ####

**id**

  - Type: int
  - Description: id del alumno.

#### Response ####

id:

  * type: integer

nombre:

  * type: string

apellido:

  * type: string

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

[][id]:

  * type: integer

[][nombre]:

  * type: string

[][apellido]:

  * type: string


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

id:

  * type: integer

nombre:

  * type: string

apellido:

  * type: string


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

Crea un nuevo usuario

#### Parameters ####

nombre:

  * type: string
  * required: true

apellido:

  * type: string
  * required: true

avatar:

  * type: string
  * required: true

username:

  * type: string
  * required: true

email:

  * type: string
  * required: true

plainPassword:

  * type: object (RepeatedType)
  * required: true

plainPassword[first]:

  * type: string
  * required: true
  * description: form.password

plainPassword[second]:

  * type: string
  * required: true
  * description: form.password_confirmation

roles[]:

  * type: array of choices
  * required: true

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
