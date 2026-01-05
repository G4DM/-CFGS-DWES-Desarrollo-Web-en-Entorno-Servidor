<?php
session_start();
require 'db.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['usuario'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Perfil de <?php echo htmlspecialchars($username); ?></title>
</head>
<body>
<div class="container">
    <h2>Bienvenido, <?php echo htmlspecialchars($username); ?></h2>
    <img src="<?php echo $user['img_big']; ?>" alt="Perfil"><br>
    <p>Username: <?php echo htmlspecialchars($username); ?></p>
    <p>Imagen pequeña:</p>
    <img src="<?php echo $user['img_small']; ?>" alt="Pequeña">
    <br><a href="logout.php">Cerrar sesión</a>
</div>
</body>
</html>
