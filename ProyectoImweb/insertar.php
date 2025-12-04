<?php
/*
CREATE (Insertar Datos) ➕
Formulario HTML: Usar method="POST" para enviar datos de manera segura y no visible en la URL.
*/

// Incluir el archivo de conexión (usando includes)
include 'conexion.php'; // Esto es como poner el texto del fichero conexion.php aquí

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Capturo lo que se haya envíado con un POST
    // 1. Obtener datos del formulario (ej. input name="nombre_usuario")
    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email'];

    // 2. Preparar la consulta SQL (Inyección SQL, ver Sección 2.5)
    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$nombre', '$email')";

    // 3. Ejecutar la consulta
    if (mysqli_query($conexion, $sql)) {
        echo "Nuevo registro creado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
}

// SIN sanear (MALO)
$nombre = $_POST['nombre']; 
$sql = "INSERT INTO usuarios (nombre) VALUES ('$nombre')"; 

// CON sanear (MEJOR, pero no el mejor)
$nombre_saneado = mysqli_real_escape_string($conexion, $_POST['nombre']);
$sql = "INSERT INTO usuarios (nombre) VALUES ('$nombre_saneado')";
?>