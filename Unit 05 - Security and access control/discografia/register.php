<?php
// ==============================
//   CONEXIÓN A LA BASE DE DATOS
// ==============================
$host = "localhost";
$dbname = "discografia";
$user = "root";
$pass = "";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $user, $pass);
    // Modo de errores: excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

// ==============================
//   PROCESAR EL FORMULARIO
// ==============================
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $password = trim($_POST["password"]);

    if (empty($usuario) || empty($password)) {
        echo "⚠️ Por favor, completa todos los campos.";
    } else {
        try {
            // Hashear la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Preparar la consulta SQL
            $sql = "INSERT INTO tabla_usuarios (usuario, password) VALUES (:usuario, :password)";
            $stmt = $conn->prepare($sql);

            // Asignar parámetros
            $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
            $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);

            // Ejecutar
            $stmt->execute();

            echo "✅ Usuario insertado correctamente.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicado de usuario
                echo "⚠️ El nombre de usuario ya existe.";
            } else {
                echo "❌ Error al insertar usuario: " . $e->getMessage();
            }
        }
    }
}

$conn = null;
?>

<!-- ==============================
     FORMULARIO HTML
============================== -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Usuario (PDO)</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form method="POST" action="">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
