<?php
$dwes = new mysqli('localhost', 'dwes', 'dwes', 'tienda');
if ($dwes->connect_errno) {
    die('Error conectando a la base de datos: ' . $dwes->connect_error);
}

// Obtenemos todos los productos sin duplicados
$consulta = 'SELECT DISTINCT nombre_corto, cod FROM producto';
$resultado = $dwes->query($consulta);

$productos = $resultado->fetch_all(MYSQLI_ASSOC);

foreach ($productos as $producto) {
    // Escapamos los datos para seguridad y generamos enlace
    $cod = urlencode($producto['cod']);
    $nombre = htmlspecialchars($producto['nombre_corto']);
    echo 'Producto: <a href="stock.php?producto=' . $cod . '">' . $nombre . '</a><br>';
}

$dwes->close();
?>
