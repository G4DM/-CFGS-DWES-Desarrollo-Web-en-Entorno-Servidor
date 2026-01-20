<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Recoger y validar datos
        $titulo = trim($_POST['titulo']);
        $discografica = trim($_POST['discografica']);
        $formato = $_POST['formato'];
        $fechaLanzamiento = $_POST['fechaLanzamiento'] ?: null;
        $fechaCompra = $_POST['fechaCompra'] ?: null;
        $precio = $_POST['precio'] ? floatval($_POST['precio']) : null;
        
        // Validaciones
        if (empty($titulo) || empty($discografica) || empty($formato)) {
            throw new Exception('Todos los campos obligatorios deben ser completados.');
        }
        
        // Insertar álbum
        $stmt = $pdo->prepare('INSERT INTO album (titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio) 
                              VALUES (?, ?, ?, ?, ?, ?)');
        
        $stmt->execute([$titulo, $discografica, $formato, $fechaLanzamiento, $fechaCompra, $precio]);
        
        header('Location: index.php?mensaje=Álbum creado correctamente');
        exit;
        
    } catch (PDOException $e) {
        $error = "Error de base de datos: " . $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Álbum</title>
</head>
<body>
    <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong> | <a href="logout.php">Cerrar sesión</a></p>

    <h1>Añadir Nuevo Álbum</h1>
    
    <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="post">
        <p>
            <label><strong>Título:*</strong></label><br>
            <input type="text" name="titulo" required maxlength="50" 
                   value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>">
        </p>
        
        <p>
            <label><strong>Discográfica:*</strong></label><br>
            <input type="text" name="discografica" required maxlength="25" 
                   value="<?php echo isset($_POST['discografica']) ? htmlspecialchars($_POST['discografica']) : ''; ?>">
        </p>
        
        <p>
            <label><strong>Formato:*</strong></label><br>
            <select name="formato" required>
                <option value="">Seleccione formato</option>
                <option value="vinilo" <?php echo (isset($_POST['formato']) && $_POST['formato'] == 'vinilo') ? 'selected' : ''; ?>>Vinilo</option>
                <option value="cd" <?php echo (isset($_POST['formato']) && $_POST['formato'] == 'cd') ? 'selected' : ''; ?>>CD</option>
                <option value="dvd" <?php echo (isset($_POST['formato']) && $_POST['formato'] == 'dvd') ? 'selected' : ''; ?>>DVD</option>
                <option value="mp3" <?php echo (isset($_POST['formato']) && $_POST['formato'] == 'mp3') ? 'selected' : ''; ?>>MP3</option>
            </select>
        </p>
        
        <p>
            <label>Fecha de Lanzamiento:</label><br>
            <input type="date" name="fechaLanzamiento" 
                   value="<?php echo isset($_POST['fechaLanzamiento']) ? htmlspecialchars($_POST['fechaLanzamiento']) : ''; ?>">
        </p>
        
        <p>
            <label>Fecha de Compra:</label><br>
            <input type="date" name="fechaCompra" 
                   value="<?php echo isset($_POST['fechaCompra']) ? htmlspecialchars($_POST['fechaCompra']) : ''; ?>">
        </p>
        
        <p>
            <label>Precio (€):</label><br>
            <input type="number" name="precio" step="0.01" min="0" 
                   value="<?php echo isset($_POST['precio']) ? htmlspecialchars($_POST['precio']) : ''; ?>">
        </p>
        
        <p>
            <input type="submit" value="Guardar Álbum">
            <a href="index.php">Cancelar</a>
        </p>
        
        <p><small>* Campos obligatorios</small></p>
    </form>
</body>
</html>