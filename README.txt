SISTEMA DE PEDIDOS - PHP + MYSQL

ARCHIVOS:
- database.sql: crea la base de datos y la tabla pedidos.
- conexion.php: conexión a MySQL.
- index.php: formulario, listado y edición en línea.
- guardar.php: registra pedidos.
- actualizar.php: actualiza pedidos.
- eliminar.php: elimina pedidos.

EJECUCIÓN LOCAL CON XAMPP:
1. Copia la carpeta sistema_pedidos_php_mysql dentro de htdocs.
2. Abre XAMPP y activa Apache y MySQL.
3. Entra a http://localhost/phpmyadmin
4. Importa database.sql.
5. Abre http://localhost/sistema_pedidos_php_mysql/index.php

PARA HOSTING:
1. Crea la base de datos MySQL en el panel del hosting.
2. Importa database.sql en phpMyAdmin del hosting.
3. Cambia los datos de conexion.php según el hosting.
4. Sube todos los archivos a la carpeta htdocs, public_html o similar.
