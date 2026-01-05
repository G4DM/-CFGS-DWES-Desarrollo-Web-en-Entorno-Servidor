<?php
include "Dvd.php";

$miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");

echo "<strong>" . $miDvd->titulo . "</strong><br>";
echo "Precio: " . $miDvd->getPrecio() . " euros<br>";
echo "Precio IVA incluido: " . $miDvd->getPrecioConIVA() . " euros<br>";

$miDvd->muestraResumen();
?>
