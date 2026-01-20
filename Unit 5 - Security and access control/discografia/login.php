<?php
session_start();

$host = "localhost";
$dbname = "discografia";
$user = "root";
$pass = "";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT password FROM tabla_usuarios WHERE usuario = :usuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["usuario"] = $usuario;
        setcookie("usuario_recordado", $usuario, time() + (30 * 24 * 60 * 60), "/");
        header("Location: index.php");
        exit;
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h2>Iniciar sesión</h2>

<?php if ($mensaje) echo "<p style='color:red'>$mensaje</p>"; ?>

<form method="POST">
    <label>Usuario:</label>
    <input type="text" name="usuario" 
           value="<?php echo isset($_COOKIE['usuario_recordado']) ? htmlspecialchars($_COOKIE['usuario_recordado']) : ''; ?>" 
           required><br><br>

    <label>Contraseña:</label>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Entrar">
</form>

<p><a href="register.php">Registrarse</a></p>
</body>
</html>
