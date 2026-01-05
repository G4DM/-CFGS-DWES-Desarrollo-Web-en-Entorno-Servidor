<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['codigo'])) {
    header('Location: index.php');
    exit;
}

$codigo = filter_input(INPUT_GET, 'codigo', FILTER_VALIDATE_INT);
if (!$codigo) {
    header('Location: index.php');
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Obtener información del álbum
    $stmt = $pdo->prepare('SELECT * FROM album WHERE codigo = ?');
    $stmt->execute([$codigo]);
    $album = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$album) {
        header('Location: index.php?mensaje=Álbum no encontrado');
        exit;
    }
    
    // Obtener canciones del álbum
    $stmt = $pdo->prepare('SELECT * FROM cancion WHERE album = ? ORDER BY posicion');
    $stmt->execute([$codigo]);
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $error = "Error al cargar el álbum: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($album['titulo']); ?></title>
</head>
<body>

    <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong> | <a href="logout.php">Cerrar sesión</a></p>

    <h1><?php echo htmlspecialchars($album['titulo']); ?></h1>
    
    <?php if (isset($_GET['error'])): ?>
        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <h2>Información del Álbum</h2>
    <p><strong>Discográfica:</strong> <?php echo htmlspecialchars($album['discografica']); ?></p>
    <p><strong>Formato:</strong> <?php echo htmlspecialchars($album['formato']); ?></p>
    <p><strong>Fecha de Lanzamiento:</strong> <?php echo $album['fechaLanzamiento'] ?: 'No especificada'; ?></p>
    <p><strong>Fecha de Compra:</strong> <?php echo $album['fechaCompra'] ?: 'No especificada'; ?></p>
    <p><strong>Precio:</strong> <?php echo $album['precio'] ? $album['precio'] . ' €' : 'No especificado'; ?></p>
    
    <h2>Canciones</h2>
    <?php if (!empty($canciones)): ?>
        <ol>
            <?php foreach ($canciones as $cancion): ?>
                <li>
                    <strong><?php echo htmlspecialchars($cancion['titulo']); ?></strong>
                    <?php if ($cancion['duracion']): ?>
                        (<?php echo $cancion['duracion']; ?>)
                    <?php endif; ?>
                    - <?php echo htmlspecialchars($cancion['genero']); ?>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <p>No hay canciones en este álbum.</p>
    <?php endif; ?>
    
    <hr>
    <h2>Opciones</h2>
    <ul>
        <li><a href="cancionnueva.php?album=<?php echo $codigo; ?>">Añadir Canción</a></li>
        <li><a href="borraralbum.php?codigo=<?php echo $codigo; ?>" 
               onclick="return confirm('¿Estás seguro de que quieres borrar este álbum y todas sus canciones?')">
               Borrar Álbum
            </a>
        </li>
        <li><a href="index.php">Volver al Inicio</a></li>
    </ul>
</body>
</html>