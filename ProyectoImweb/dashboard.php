<?php
// INICIO DE SESIÓN
session_start();

// Control de Acceso: Si la variable de sesión no existe, redirigir al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Variables de usuario para mostrar en el dashboard
$usuario_actual = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            Bienvenido, **<?php echo htmlspecialchars($usuario_actual); ?>**! Has accedido al panel de administración.
        </div>
        
        <h1 class="mb-4">Opciones CRUD de Usuarios</h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            
            <div class="col">
                <div class="card text-center h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title">INSERTAR (CREATE)</h5>
                        <p class="card-text">Agregar un nuevo registro a la base de datos.</p>
                        <a href="crear_usuario.php" class="btn btn-primary stretched-link">Crear Nuevo</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title">ACTUALIZAR (UPDATE)</h5>
                        <p class="card-text">Modificar un registro existente.</p>
                        <a href="listar_usuarios.php" class="btn btn-warning stretched-link">Actualizar Registro</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title">BORRAR (DELETE)</h5>
                        <p class="card-text">Eliminar un registro de forma permanente.</p>
                        <a href="listar_usuarios.php" class="btn btn-danger stretched-link">Borrar Registro</a>
                    </div>
                </div>
            </div>
            
        </div>
        
        <hr class="mt-5">
        
        <a href="logout.php" class="btn btn-outline-secondary">Cerrar Sesión</a>
    </div>
</body>
</html>