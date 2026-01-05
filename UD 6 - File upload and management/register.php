<?php
session_start();
require 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validación imagen
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['profile_image']['type'], $allowed_types)) {
            $errors[] = "Solo se permiten imágenes PNG o JPG.";
        }

        list($width, $height) = getimagesize($_FILES['profile_image']['tmp_name']);
        if ($width > 360 || $height > 480) {
            $errors[] = "La imagen no puede superar 360x480px.";
        }
    } else {
        $errors[] = "Debes subir una imagen de perfil.";
    }

    if (empty($errors)) {
        // Crear carpeta de usuario
        $user_dir = "img/users/$username";
        if (!is_dir($user_dir)) mkdir($user_dir, 0777, true);

        // Redimensionar y guardar imágenes
        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $big_path = "$user_dir/idUserBig.$ext";
        $small_path = "$user_dir/idUserSmall.$ext";

        // Crear imagen desde archivo
        $source = ($ext === 'png') ? imagecreatefrompng($_FILES['profile_image']['tmp_name']) : imagecreatefromjpeg($_FILES['profile_image']['tmp_name']);

        // Imagen grande (360x480)
        $big = imagecreatetruecolor(360, 480);
        imagecopyresampled($big, $source, 0, 0, 0, 0, 360, 480, $width, $height);
        ($ext === 'png') ? imagepng($big, $big_path) : imagejpeg($big, $big_path, 90);

        // Imagen pequeña (72x96)
        $small = imagecreatetruecolor(72, 96);
        imagecopyresampled($small, $source, 0, 0, 0, 0, 72, 96, $width, $height);
        ($ext === 'png') ? imagepng($small, $small_path) : imagejpeg($small, $small_path, 90);

        imagedestroy($source);
        imagedestroy($big);
        imagedestroy($small);

        // Guardar en DB
        $stmt = $pdo->prepare("INSERT INTO users (username, password, img_big, img_small) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $big_path, $small_path]);

        $_SESSION['usuario'] = $username;
        header("Location: profile.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Registro</title>
</head>
<body>
<div class="container">
    <h2>Registro</h2>
    <?php if($errors) foreach($errors as $error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Usuario" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <input type="file" name="profile_image" accept="image/png, image/jpeg" required><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a></p>
</div>
</body>
</html>
