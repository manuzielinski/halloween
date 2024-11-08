<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = $_SESSION['usuario_id'];
$id_disfraz = $_POST['id_disfraz'];

$query = "SELECT * FROM votos WHERE id_usuario = ? AND id_disfraz = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ii", $id_usuario, $id_disfraz);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    header("Location: ../index.php?voto=duplicate");
    exit();
}

$query = "INSERT INTO votos (id_usuario, id_disfraz) VALUES (?, ?)";
$stmt = $conexion->prepare($query);
$stmt->bind_param("ii", $id_usuario, $id_disfraz);
$stmt->execute();

$query = "UPDATE disfraces SET votos = votos + 1 WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_disfraz);
$stmt->execute();

header("Location: ../index.php?voto=success");
exit();
?>
