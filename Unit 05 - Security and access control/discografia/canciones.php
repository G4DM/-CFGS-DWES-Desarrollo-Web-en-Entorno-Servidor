<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$resultados = [];
$busqueda_realizada = false;

// --- Manejo de cookies de últimas búsquedas ---
$ultimas_busquedas = [];
if (isset($_COOKIE['ultimas_busquedas'])) {
    $ultimas_busquedas = json_decode($_COOKIE['ultimas_busquedas'], true) ?? [];
}

// --- Si se realiza una búsqueda ---
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['texto']) && !empty(trim($_GET['texto']))) {
    $busqueda_realizada = true;

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=discografia;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $texto = '%' . trim($_GET['texto']) . '%';
        $campo = $_GET['campo'] ?? 'cancion';
        $genero = $_GET['genero'] ?? '';
        
        $sql = "SELECT c.titulo as cancion, c.duracion, c.genero, c.posicion, 
                       a.titulo as album_titulo, a.codigo as album_codigo 
                FROM cancion c 
                JOIN album a ON c.album = a.codigo 
                WHERE ";

        switch ($campo) {
            case 'cancion':
                $sql .= "c.titulo LIKE ?";
                $params = [$texto];
                break;
            case 'album':
                $sql .= "a.titulo LIKE ?";
                $params = [$texto];
                break;
            case 'ambos':
                $sql .= "(c.titulo LIKE ? OR a.titulo LIKE ?)";
                $params = [$texto, $texto];
                break;
            default:
                $sql .= "c.titulo LIKE ?";
                $params = [$texto];
        }
        
        if (!empty($genero)) {
            $sql .= " AND c.genero = ?";
            $params[] = $genero;
        }
        
        $sql .= " ORDER BY a.titulo, c.posicion";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // --- Guardar la búsqueda en cookies ---
        $nueva_busqueda = [
            'texto' => trim($_GET['texto']),
            'campo' => $campo,
            'genero' => $genero,
            'fecha' => date('d/m/Y H:i')
        ];

        array_unshift($ultimas_busquedas, $nueva_busqueda); // añadir al inicio
        $ultimas_busquedas = array_slice($ultimas_busquedas, 0, 5); // mantener solo las 5 últimas
        setcookie('ultimas_busquedas', json_encode($ultimas_busquedas), time() + 86400 * 7, "/"); // 7 días

    } catch (PDOException $e) {
        $error = "Error en la búsqueda: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Búsqueda de Canciones</title>
</head>
<body>

    <p>Usuario: <strong><?php echo htmlspecialchars($_SESSION["usuario"]); ?></strong> | 
    <a href="logout.php">Cerrar sesión</a></p>

    <h1>Búsqueda de Canciones</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="get">
        <p>
            <label><strong>Texto a buscar:</strong></label><br>
            <input type="text" name="texto" required 
                   value="<?php echo isset($_GET['texto']) ? htmlspecialchars($_GET['texto']) : ''; ?>">
        </p>
        
        <p>
            <label><strong>Buscar en:</strong></label><br>
            <input type="radio" name="campo" value="cancion" 
                   <?php echo (!isset($_GET['campo']) || $_GET['campo'] == 'cancion') ? 'checked' : ''; ?>> 
                   Títulos de canción<br>
            <input type="radio" name="campo" value="album" 
                   <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'album') ? 'checked' : ''; ?>> 
                   Nombres de álbum<br>
            <input type="radio" name="campo" value="ambos" 
                   <?php echo (isset($_GET['campo']) && $_GET['campo'] == 'ambos') ? 'checked' : ''; ?>> 
                   Ambos campos
        </p>
        
        <p>
            <label><strong>Género musical:</strong></label><br>
            <select name="genero">
                <option value="">Todos los géneros</option>
                <option value="Acustica" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Acustica') ? 'selected' : ''; ?>>Acústica</option>
                <option value="BSO" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'BSO') ? 'selected' : ''; ?>>BSO</option>
                <option value="Blues" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Blues') ? 'selected' : ''; ?>>Blues</option>
                <option value="Folk" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Folk') ? 'selected' : ''; ?>>Folk</option>
                <option value="Jazz" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Jazz') ? 'selected' : ''; ?>>Jazz</option>
                <option value="New age" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'New age') ? 'selected' : ''; ?>>New age</option>
                <option value="Pop" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Pop') ? 'selected' : ''; ?>>Pop</option>
                <option value="Rock" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Rock') ? 'selected' : ''; ?>>Rock</option>
                <option value="Electronica" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'Electronica') ? 'selected' : ''; ?>>Electrónica</option>
            </select>
        </p>
        
        <p>
            <input type="submit" value="Buscar">
            <a href="index.php">Volver al Inicio</a>
        </p>
    </form>

    <?php if (!empty($ultimas_busquedas)): ?>
        <hr>
        <h2>Últimas búsquedas</h2>
        <ul>
            <?php foreach ($ultimas_busquedas as $busqueda): ?>
                <li>
                    <em><?php echo htmlspecialchars($busqueda['fecha']); ?></em> — 
                    <strong><?php echo htmlspecialchars($busqueda['texto']); ?></strong> 
                    (<?php echo htmlspecialchars($busqueda['campo']); ?><?php echo $busqueda['genero'] ? ', ' . htmlspecialchars($busqueda['genero']) : ''; ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    
    <?php if ($busqueda_realizada): ?>
        <hr>
        <h2>Resultados de la Búsqueda</h2>
        
        <?php if (!empty($resultados)): ?>
            <p>Se encontraron <?php echo count($resultados); ?> resultado(s):</p>
            <ul>
                <?php foreach ($resultados as $cancion): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($cancion['cancion']); ?></strong>
                        <?php if ($cancion['duracion']): ?>
                            (<?php echo $cancion['duracion']; ?>)
                        <?php endif; ?>
                        - <?php echo htmlspecialchars($cancion['genero']); ?>
                        <br>
                        <em>Álbum: 
                            <a href="album.php?codigo=<?php echo $cancion['album_codigo']; ?>">
                                <?php echo htmlspecialchars($cancion['album_titulo']); ?>
                            </a>
                        </em>
                        <?php if ($cancion['posicion']): ?>
                            (posición <?php echo $cancion['posicion']; ?>)
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No se encontraron canciones con los criterios especificados.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
