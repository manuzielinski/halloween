<?php
session_start();
require 'php/conexion.php';

$query = "SELECT id, nombre, descripcion, votos, foto_blob FROM disfraces WHERE eliminado = 0";
$result = $conexion->query($query);

if (!$result) {
    die("Error al obtener los disfraces: " . $conexion->error);
}

$votoMensaje = "";
if (isset($_GET['voto'])) {
    if ($_GET['voto'] == 'duplicate') {
        $votoMensaje = "Ya has votado por este disfraz.";
    } elseif ($_GET['voto'] == 'success') {
        $votoMensaje = "Gracias por tu voto!";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Disfraces de Halloween</title>
    <link rel="stylesheet" href="styles/styles.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
<header>
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <p>Bienvenido, usuario!</p>
        <?php if (isset($_SESSION['es_admin']) && $_SESSION['es_admin'] == true): ?>
            <a href="php/admin.php">Panel de Control</a>
        <?php endif; ?>
        <a href="php/logout.php">Cerrar Sesión</a>
    <?php else: ?>
        <a href="php/registro.php">Registrarse</a>
        <a href="php/login.php">Iniciar Sesión</a>
    <?php endif; ?>
</header>

<h1>Disfraces de Halloween</h1>

<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
        <li>
            <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
            <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
            <p>Votos: <?php echo $row['votos']; ?></p>

            <?php if ($row['foto_blob']): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto_blob']); ?>" alt="Imagen del disfraz" style="width:200px;">
            <?php endif; ?>

            <form action="php/votar.php" method="post">
                <input type="hidden" name="id_disfraz" value="<?php echo $row['id']; ?>">
                <button type="submit" class="votar-button">Votar</button>
            </form>
        </li>
    <?php endwhile; ?>
</ul>

<script>
    <?php if ($votoMensaje): ?>
        showAlert("<?php echo addslashes($votoMensaje); ?>");
    <?php endif; ?>
</script>

</body>
</html>
