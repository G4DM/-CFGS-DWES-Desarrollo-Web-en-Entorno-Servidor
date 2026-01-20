<?php
if (!isset($_GET['album'])) {
    header('Location: index.php');
    exit;
}

$album_id = filter_input(INPUT_GET, 'album', FILTER_VALIDATE_INT);
if (!$album_id) {
    header('Location: index.php');
    exit;
}

$mensaje = '';
$error = '';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'discografia', 'discografia');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Obtener información del álbum
    $stmt = $pdo->prepare('SELECT titulo FROM album WHERE codigo = ?');
    $stmt->execute([$album_id]);
    $album = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$album) {
        header('Location: index.php?mensaje=Álbum no encontrado');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = trim($_POST['titulo']);
        $posicion = $_POST['posicion'] ? intval($_POST['posicion']) : null;
        $duracion = $_POST['duracion'] ?: null;
        $genero = $_POST['genero'];
        
        // Validaciones
        if (empty($titulo) || empty($genero)) {
            throw new Exception('El título y el género son obligatorios.');
        }
        
        // Validar formato de duración
        if ($duracion && !preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $duracion)) {
            throw new Exception('Formato de duración inválido. Use HH:MM:SS (ej: 00:03:45)');
        }
        
        // Insertar canción
        $stmt = $pdo->prepare('INSERT INTO cancion (titulo, album, posicion, duracion, genero) 
                              VALUES (?, ?, ?, ?, ?)');
        
        $stmt->execute([$titulo, $album_id, $posicion, $duracion, $genero]);
        
        $mensaje = 'Canción "' . htmlspecialchars($titulo) . '" añadida correctamente.';
        
        // Limpiar formulario después de éxito
        $_POST = array();
    }
    
} catch (PDOException $e) {
    if ($e->getCode() == 23000) { // Clave duplicada
        $error = "Ya existe una canción con ese título en este álbum.";
    } else {
        $error = "Error de base de datos: " . $e->getMessage();
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Añadir Nueva Canción</title>
</head>
<body>
    <h1>Añadir Canción al Álbum: <?php echo htmlspecialchars($album['titulo']); ?></h1>
    
    <?php if ($mensaje): ?>
        <p style="color: green; font-weight: bold;"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="post">
        <p>
            <label><strong>Título de la canción:*</strong></label><br>
            <input type="text" name="titulo" required maxlength="50" 
                   value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>">
        </p>
        
        <p>
            <label>Posición en el álbum:</label><br>
            <input type="number" name="posicion" min="1" max="99" 
                   value="<?php echo isset($_POST['posicion']) ? htmlspecialchars($_POST['posicion']) : ''; ?>">
        </p>
        
        <p>
            <label>Duración (HH:MM:SS):</label><br>
            <input type="text" name="duracion" placeholder="00:03:45" 
                   value="<?php echo isset($_POST['duracion']) ? htmlspecialchars($_POST['duracion']) : ''; ?>">
            <small>Ejemplo: 00:03:45</small>
        </p>
        
        <p>
            <label><strong>Género:*</strong></label><br>
            <select name="genero" required>
                <option value="">Seleccione género</option>
                <option value="Acustica" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Acustica') ? 'selected' : ''; ?>>Acústica</option>
                <option value="BSO" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'BSO') ? 'selected' : ''; ?>>BSO</option>
                <option value="Blues" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Blues') ? 'selected' : ''; ?>>Blues</option>
                <option value="Folk" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Folk') ? 'selected' : ''; ?>>Folk</option>
                <option value="Jazz" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Jazz') ? 'selected' : ''; ?>>Jazz</option>
                <option value="New age" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'New age') ? 'selected' : ''; ?>>New age</option>
                <option value="Pop" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Pop') ? 'selected' : ''; ?>>Pop</option>
                <option value="Rock" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Rock') ? 'selected' : ''; ?>>Rock</option>
                <option value="Electronica" <?php echo (isset($_POST['genero']) && $_POST['genero'] == 'Electronica') ? 'selected' : ''; ?>>Electrónica</option>
            </select>
        </p>
        
        <p>
            <input type="submit" value="Añadir Canción">
            <a href="album.php?codigo=<?php echo $album_id; ?>">Volver al Álbum</a>
        </p>
        
        <p><small>* Campos obligatorios</small></p>
    </form>
</body>
</html>