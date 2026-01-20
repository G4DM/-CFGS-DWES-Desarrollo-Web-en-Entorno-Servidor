<?php
include "Soporte.php";

$soporte1 = new Soporte("Tenet", 22, 3);

echo "<strong>" . $soporte1->titulo . "</strong><br>";
echo "Precio: " . $soporte1->getPrecio() . " euros<br>";
echo "Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros<br>";

$soporte1->muestraResumen();
?>