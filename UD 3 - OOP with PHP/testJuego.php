<?php
include "Juego.php";

$miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);

echo "<strong>" . $miJuego->titulo . "</strong><br>";
echo "Precio: " . $miJuego->getPrecio() . " euros<br>";
echo "Precio IVA incluido: " . $miJuego->getPrecioConIVA() . " euros<br>";

$miJuego->muestraResumen();
?>
