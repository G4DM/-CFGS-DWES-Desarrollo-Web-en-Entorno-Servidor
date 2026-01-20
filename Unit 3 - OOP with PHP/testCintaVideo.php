<?php
include "CintaVideo.php";

$miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);

echo "<strong>" . $miCinta->titulo . "</strong><br>";
echo "Precio: " . $miCinta->getPrecio() . " euros<br>";
echo "Precio IVA incluido: " . $miCinta->getPrecioConIVA() . " euros<br>";

$miCinta->muestraResumen();
?>
