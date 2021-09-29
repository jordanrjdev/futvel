Utilizando Laravel deberás crear un Api Rest el cual retornará datos sobre una liga de fútbol. Esta api deberá considerar lo siguiente:

Endpoints

-   Listado de todas las ligas de fútbol nacional, considerando información como nombre, fecha de inicio, fecha de término, cantidad de fechas a jugarse. [x]
-   Listado de equipos que participarán de una liga en particular [x]
-   Listado de todas las ligas en que participará un equipo en particular
-   Listado de todos los jugadores de un equipo [x]
-   Carga masiva de equipos a una liga
-   Incorporación de jugador (ya existente) a un equipo
-   Creación de un jugador [x]

Pruebas

-   Cada endpoint debe contener pruebas unitarias las cuales deberán correr con phpunit. [x]

Frontend

-   Implementar frontend simple que consuma y despliegue listado de equipos (tabla) y que desde esta misma vista exista un formulario para hacer un envío de un archivo excel con los equipos de diferentes ligas (\*).

*   Considerar temas de optimización de carga en un escenario con múltiples ligas y varios equipos en cada una (comentar en readme cómo abordaste este punto).

Restricciones y consideraciones

-   API de versión libre y versión pagada. Ambas deberán manejar un token de autenticación.
-   La API de versión libre sólo deberá permitir consultar un máximo de 3 veces por minuto cualquiera de los endpoints. Al cuarto intento deberá arrojar mensaje de error (Comentar en readme cómo has implementado esta lógica)
-   La API de versión pagada no tendrá restricción de tiempo
-   Todos los endpoints deben manejar validaciones (tú las propones), por ejemplo que el jugador tenga al menos nombre
-   Deberás registrar las migraciones y creación de data dummy para probar directamente en una base de datos local (de preferencia mysql).
-   Las ligas de fútbol y equipos pueden no ser reales
-   En el archivo readme se deberá especificar instalación, rutas de endpoints, forma de autenticación y otros aspectos que consideres relevantes para ejecutar el servicio.

Debes subirlo a un repositorio y enviarlo antes del jueves 30 al mediodía.
