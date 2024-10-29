<?php
include 'conexion.php';

session_start();
$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['disfraz_id'])) {
    $disfraz_id = $_POST['disfraz_id'];

    $checkVote = $pdo->prepare("SELECT * FROM votos WHERE usuario_id = ? AND disfraz_id = ?");
    $checkVote->execute([$usuario_id, $disfraz_id]);
    if ($checkVote->rowCount() > 0) {
        echo "Ya has votado por este disfraz.";
    } else {
        $insertVote = $pdo->prepare("INSERT INTO votos (usuario_id, disfraz_id) VALUES (?, ?)");
        $insertVote->execute([$usuario_id, $disfraz_id]);
        $updateVotes = $pdo->prepare("UPDATE disfraces SET votos = votos + 1 WHERE id = ?");
        $updateVotes->execute([$disfraz_id]);

        echo "¡Voto registrado!";
    }
}
?>
