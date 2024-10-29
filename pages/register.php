<?php
include 'php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];

    if (!empty($nombre) && !empty($clave)) {
        $clave_encriptada = password_hash($clave, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, clave) VALUES (:nombre, :clave)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':clave', $clave_encriptada);

        if ($stmt->execute()) {
            echo "Registro exitoso. ¡Ahora puedes iniciar sesión!";
        } else {
            echo "Error al registrarse. Intenta de nuevo.";
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h1>Registro de Usuario</h1>
        <form action="registro.php" method="POST">
            <label for="nombre">Nombre de Usuario:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave" required>

            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>
