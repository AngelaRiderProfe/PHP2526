<?php
//2.4. DELETE (Borrar Datos)
// ... (Conexión establecida)

// Usamos GET para obtener el ID a borrar desde la URL (ej. borrar.php?id=5)
$id_a_borrar = $_GET['id']; 

$sql = "DELETE FROM usuarios WHERE id=$id_a_borrar";

if (mysqli_query($conexion, $sql)) {
    echo "Registro borrado con éxito.";
} else {
    echo "Error al borrar: " . mysqli_error($conexion);
}
?>