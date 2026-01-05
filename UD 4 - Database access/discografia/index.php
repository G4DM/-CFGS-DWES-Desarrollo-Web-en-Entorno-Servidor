<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'discografia', 'discografia');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query('SELECT * FROM album ORDER BY titulo');
    $albumes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error al conectar con la base de datos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Discografía - Álbumes</title>
</head>
<body>
    <h1>Mi Colección de Discos</h1>
    
    <?php if (isset($_GET['mensaje'])): ?>
        <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <h2>Lista de Álbumes</h2>
    <?php if (!empty($albumes)): ?>
        <ul>
            <?php foreach ($albumes as $album): ?>
                <li>
                    <a href="album.php?codigo=<?php echo $album['codigo']; ?>">
                        <?php echo htmlspecialchars($album['titulo']); ?>
                    </a>
                    - <?php echo htmlspecialchars($album['discografica']); ?>
                    (<?php echo htmlspecialchars($album['formato']); ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay álbumes en la colección.</p>
    <?php endif; ?>
    
    <hr>
    <h2>Opciones</h2>
    <ul>
        <li><a href="albumnuevo.php">Añadir Nuevo Álbum</a></li>
        <li><a href="canciones.php">Buscar Canciones</a></li>
    </ul>
</body>
</html>