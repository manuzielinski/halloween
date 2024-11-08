<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, clave) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $clave);
    
    if ($stmt->execute()) {
        echo "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
    } else {
        echo "Error: Usuario ya existe.";
    }
}
?>
    <link rel="stylesheet" href="../styles/register.css">
<form action="registro.php" method="post">
    <input type="text" name="nombre" placeholder="Nombre de usuario" required>
    <input type="password" name="clave" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
</form>
