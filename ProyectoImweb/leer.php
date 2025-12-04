2.2. READ (Leer/Seleccionar Datos) 📄
PHP

<?php
// ... (Conexión establecida)

$sql = "SELECT id, nombre, email FROM usuarios";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    // Recorrer los resultados
    while($fila = mysqli_fetch_assoc($resultado)) {
        echo "ID: " . $fila["id"]. " - Nombre: " . $fila["nombre"]. " - Email: " . $fila["email"]. "<br>";
    }
} else {
    echo "0 resultados";
}
// mysqli_free_result($resultado); // Liberar memoria (buena práctica)
?>
