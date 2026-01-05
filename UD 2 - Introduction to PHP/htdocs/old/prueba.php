<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Primera prueba php</title>
</head>

<body>
    <?php
        include_once("cabecera.inc.php");
    ?>

    Este es un archivo php que se encuentra en el servidor.

    <?php
    $cantidad = 3;
    $precio = 1.6;
    $iva = 1.21;
    $total = $cantidad * (int)($precio * $iva);

    echo "<p>Total: $total €</p>";

    include("archivo.php");
    include_once("otro.php");
    require("prueba.inc.php");
    require_once("inventado.php");
    ?>

</body>

</html>