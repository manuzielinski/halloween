<?php
session_start();

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    header("Location: index.php");
    exit;
}

require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['descripcion'], $_FILES['foto'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $foto = $_FILES['foto'];

    $foto_blob = file_get_contents($foto['tmp_name']);

    $query = "INSERT INTO disfraces (nombre, descripcion, foto_blob) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('sss', $nombre, $descripcion, $foto_blob);

    if ($stmt->execute()) {
        $mensaje = "Disfraz agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar el disfraz.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../styles/admin.css">
</head>
<body>
    <h1>Panel de Administración</h1>

    <p>Bienvenido al panel de control!!. Desde aca podes agregar nuevos disfraces.</p>

    <?php if (isset($mensaje)): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <h2>Agregar un nuevo disfraz</h2>
    <form action="admin.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre del Disfraz:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" id="foto" required>

        <button type="submit">Agregar Disfraz</button>
    </form>

    <br>
    <a href="../index.php">Volver al inicio</a>
</body>
</html>
