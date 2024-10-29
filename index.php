<?php
include 'php/conexion.php';

$stmt = $pdo->prepare("SELECT * FROM disfraces WHERE eliminado = 0 ORDER BY votos DESC");
$stmt->execute();
$disfraces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Concurso de disfraces de Halloween</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="#disfraces-list">Ver Disfraces</a></li>
            <li><a href="#registro">Registro</a></li>
            <li><a href="#login">Iniciar Sesión</a></li>
            <li><a href="#admin">Panel de Administración</a></li>
        </ul>
    </nav>
    <header>
        <h1>Concurso de disfraces de Halloween</h1>
    </header>

    <main>
        <section id="disfraces-list" class="section">
            <h2>Lista de Disfraces</h2>
            <?php foreach ($disfraces as $disfraz): ?>
                <div class="disfraz">
                    <h2><?php echo htmlspecialchars($disfraz['nombre']); ?></h2>
                    <p><?php echo htmlspecialchars($disfraz['descripcion']); ?></p>
                    <?php if (!empty($disfraz['foto'])): ?>
                        <p><img src="assets/<?php echo htmlspecialchars($disfraz['foto']); ?>" width="100%"></p>
                    <?php endif; ?>
                    <p>Votos: <?php echo $disfraz['votos']; ?></p>
                    <form action="php/votar.php" method="POST">
                        <input type="hidden" name="disfraz_id" value="<?php echo $disfraz['id']; ?>">
                        <button type="submit" class="votar">Votar</button>
                    </form>
                </div>
                <hr>
            <?php endforeach; ?>
        </section>
        <section id="registro" class="section">
            <h2>Registro</h2>
            <form action="procesar_registro.php" method="POST">
                <label for="username">Nombre de Usuario:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Registrarse</button>
            </form>
        </section>
        <section id="login" class="section">
            <h2>Iniciar Sesión</h2>
            <form action="procesar_login.php" method="POST">
                <label for="login-username">Nombre de Usuario:</label>
                <input type="text" id="login-username" name="login-username" required>
                
                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" name="login-password" required>
                
                <button type="submit">Iniciar Sesión</button>
            </form>
        </section>
        <section id="admin" class="section">
            <h2>Panel de Administración</h2>
            <form action="procesar_disfraz.php" method="POST" enctype="multipart/form-data">
                <label for="disfraz-nombre">Nombre del Disfraz:</label>
                <input type="text" id="disfraz-nombre" name="disfraz-nombre" required>
                
                <label for="disfraz-descripcion">Descripción del Disfraz:</label>
                <textarea id="disfraz-descripcion" name="disfraz-descripcion" required></textarea>
                
                <label for="disfraz-foto">Foto:</label>
                <input type="file" id="disfraz-foto" name="disfraz-foto" required>

                <button type="submit">Agregar Disfraz</button>
            </form>
        </section>
    </main>

    <script src="js/script.js"></script>
</body>
</html>
