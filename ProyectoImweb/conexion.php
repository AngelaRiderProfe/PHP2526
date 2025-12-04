<?php
$host = "localhost";  // Servidor de la base de datos
$user = "root";        // usuario
$password = "";         //Password  
$db_name = "proyectoimweb"; // Nombre de la base de datos

// 1. Intentar la conexión
$conexion = mysqli_connect($host, $user, $password, $db_name);

// 2. Controlar la conexión (MUY IMPORTANTE)
if (mysqli_connect_errno()) {
    // Si hay un error, mostrarlo y terminar la ejecución del script
    die("Fallo en la conexión a MySQL: " . mysqli_connect_error());
}

// 3. Opcional: Establecer el juego de caracteres a UTF-8
mysqli_set_charset($conexion, "utf8");

// Si llegamos aquí, la conexión es exitosa
echo "Conexión exitosa";

/*

Problemas Comunes y SoluciónError: 
Access denied for user 'X'@'localhost': Contraseña o usuario incorrectos. 
Solución: Verificar credenciales en la configuración de la BD (phpMyAdmin, etc.).

Error: Unknown database 'Y': Nombre de la BD incorrecto. 
Solución: Verificar que la base de datos Y existe y el nombre está bien escrito.

Error: Can't connect to MySQL server on 'localhost': El servidor MySQL no está corriendo. 
Solución: Iniciar el servicio (ej. en XAMPP/MAMP/WAMP).


*/
?>