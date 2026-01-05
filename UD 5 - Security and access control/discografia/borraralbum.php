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
    
    // Iniciar transacción
    $pdo->beginTransaction();
    
    try {
        // Primero borrar las canciones del álbum
        $stmt = $pdo->prepare('DELETE FROM cancion WHERE album = ?');
        $stmt->execute([$codigo]);
        
        // Luego borrar el álbum
        $stmt = $pdo->prepare('DELETE FROM album WHERE codigo = ?');
        $stmt->execute([$codigo]);
        
        // Confirmar transacción
        $pdo->commit();
        
        header('Location: index.php?mensaje=Álbum y todas sus canciones borrados correctamente');
        exit;
        
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        $pdo->rollBack();
        throw $e;
    }
    
} catch (PDOException $e) {
    header('Location: album.php?codigo=' . $codigo . '&error=Error al borrar el álbum: ' . urlencode($e->getMessage()));
    exit;
} catch (Exception $e) {
    header('Location: album.php?codigo=' . $codigo . '&error=Error: ' . urlencode($e->getMessage()));
    exit;
}
?>
