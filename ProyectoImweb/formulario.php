<?php
// INICIO DE SESIÓN
// Siempre debe ir al comienzo de cualquier script que use sesiones
session_start();

// Si el usuario ya está logueado, redirigir a dashboard.php
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Inicializar variable de error
$error_message = "";

// 1. Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Incluir la conexión (usamos require_once para asegurar su existencia)
    require_once 'conexion.php'; 

    // Obtener y sanear los datos del formulario (prevención de Inyección SQL)
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password']; // No sanear la contraseña para el hashing

    // 2. Buscar el usuario en la BD
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $resultado = mysqli_query($conexion, $sql);
       
    // 3. Verificar si el usuario existe
    if (mysqli_num_rows($resultado) == 1) {

        $fila = mysqli_fetch_assoc($resultado);
        $hashed_password = $fila['password'];

        // 4. Verificar la contraseña usando HASHING
        if (password_verify($password, $hashed_password)) {
            
            // ÉXITO: Iniciar sesión
            $_SESSION['usuario_id'] = $fila['ID_Usuario'];
            $_SESSION['nombre_usuario'] = $fila['usuario'];
            
            // Redirigir al dashboard
            header("Location: dashboard.php");
            exit();

        } else {
            // Contraseña incorrecta
            $error_message = "Usuario o contraseña incorrectos.";
        }
    } else {
        // Usuario no encontrado
        $error_message = "Usuario o contraseña incorrectos.";
    }
    
    // Cierre de la conexión (buena práctica)
    mysqli_close($conexion);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - CRUD MySQLi Procedimental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
            <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
            
            <?php 
            // Mostrar mensaje de error si existe
            if ($error_message) {
                echo '<div class="alert alert-danger" role="alert">'. $error_message .'</div>';
            }
            ?>

            <form action="formulario.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>
</body>




<!--

Problemas Comunes y Solución
Error: Access denied for user 'X'@'localhost': Contraseña o usuario incorrectos. 
Solución: Verificar credenciales en la configuración de la BD (phpMyAdmin, etc.).
Error: Unknown database 'Y': Nombre de la BD incorrecto. 
Solución: Verificar que la base de datos Y existe y el nombre está bien escrito.
Error: Can't connect to MySQL server on 'localhost': El servidor MySQL no está corriendo. 
Solución: Iniciar el servicio (ej. en XAMPP/MAMP/WAMP).

2. Operaciones CRUD (Create, Read, Update, Delete)Usaremos formularios HTML y el manejo de datos a través de \$_POST y \$_GET para ejecutar las operaciones.

2.5. ¡Control Crucial! Prevenir Inyección SQL
    El mayor problema de seguridad es la Inyección SQL, donde un atacante inserta código SQL malicioso en un formulario.
    Solución 1: Escapar Cadenas (Método Básico)Antes de usar una variable de usuario en una consulta, siempre se debe "sanear" con mysqli_real_escape_string().
    
    // SIN sanear (MALO)
        $nombre = $_POST['nombre']; 
        $sql = "INSERT INTO usuarios (nombre) VALUES ('$nombre')"; 

// CON sanear (MEJOR, pero no el mejor)
        $nombre_saneado = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $sql = "INSERT INTO usuarios (nombre) VALUES ('$nombre_saneado')";

    Solución 2: Sentencias Preparadas (Recomendado)Para este nivel, el enfoque con mysqli_real_escape_string() es suficiente, 
    pero se debe mencionar que las sentencias preparadas son el estándar de oro para prevenir inyección 
    
SQL.3. Encriptación de Información (Contraseñas) 
¡NUNCA guardar contraseñas en texto plano! Usaremos password_hash() y password_verify() (funciones nativas de PHP).
    Al Registrar (CREATE):
        $pass_plana = $_POST['password'];
    // Generar el hash de la contraseña (algoritmo fuerte y salt automático)
        $pass_hash = password_hash($pass_plana, PASSWORD_DEFAULT); 

    // Guardar $pass_hash en la base de datos
    $sql = "INSERT INTO usuarios (password) VALUES ('$pass_hash')";
   l Iniciar Sesión (READ/Verificación):
    // 1. Obtener la contraseña hasheada almacenada en la BD para ese usuario
        $pass_almacenada = $fila['password']; 
        $pass_introducida = $_POST['password'];

    // 2. Comparar la contraseña introducida con el hash
        if (password_verify($pass_introducida, $pass_almacenada)) {
            echo "¡Contraseña correcta! Acceso concedido.";
        } else {
            echo "Contraseña incorrecta.";
        }



Sesiones y Cookies 
1.-Sesiones ($_SESSION) Usadas para mantener el estado (ej. un usuario logueado) durante la navegación. 
Los datos se guardan en el servidor.
Inicio de Sesión: Siempre debe ser la primera línea de código.
    session_start();
Guardar un Dato (Login):
    $_SESSION['usuario_id'] = $fila['id'];
    $_SESSION['nombre_usuario'] = $fila['nombre'];
Comprobar Sesión (Página Protegida):

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redirigir si no está logueado
    exit();
}
Cerrar Sesión:
session_start();
session_unset();    // Elimina las variables de sesión
session_destroy();  // Destruye la sesión
header("Location: login.php");

        -->
</html>

