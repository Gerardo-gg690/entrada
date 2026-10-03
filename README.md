# TimeCore — PHP + MySQL

Esta versión comparte empleados y marcaciones entre teléfonos/computadoras usando una sola base MySQL.

## XAMPP
1. Copia la carpeta `timecore_php_mysql` dentro de `C:\\xampp\\htdocs\\`.
2. Inicia Apache y MySQL.
3. En phpMyAdmin, importa `database/timecore.sql`.
4. Si tu MySQL usa otro usuario/contraseña, edita `config/database.php`.
5. Abre `http://localhost/timecore_php_mysql/`.
6. Entra a **Panel de la jefa**. La primera vez permite crear la cuenta administradora.

## Para usarlo desde varios teléfonos
`localhost` solo sirve en la computadora. Para varios teléfonos necesitas subir esta carpeta a un hosting con PHP + MySQL e importar `database/timecore.sql` en la base del hosting. Luego todos abren el mismo dominio HTTPS.

## Seguridad incluida
- PIN de empleado almacenado con `password_hash()`.
- Contraseña de administradora almacenada con `password_hash()`.
- PDO y consultas preparadas.
- Sesión PHP para el panel privado.
- Token CSRF en acciones administrativas.
- La hora oficial de entrada/salida la toma el servidor.

## Importante
La fórmula de pago es configurable y esta versión la presenta como cálculo operativo/estimado. Antes de usarla para una planilla oficial, configura y valida las reglas reales del negocio.
