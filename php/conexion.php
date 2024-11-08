<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$base_datos = "halloween";

$conexion = new mysqli($servidor, $usuario, $clave, $base_datos);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
