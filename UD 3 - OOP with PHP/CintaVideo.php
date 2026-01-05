<?php
include_once "Soporte.php";

class CintaVideo extends Soporte {
    private $duracion;

    public function __construct($titulo, $numero, $precio, $duracion) {
        parent::__construct($titulo, $numero, $precio);
        $this->duracion = $duracion;
    }

    public function muestraResumen() {
        echo "<p>Película en VHS:<br>";
        echo "{$this->titulo}<br>";
        echo "{$this->getPrecio()} € (IVA no incluido)<br>";
        echo "Duración: {$this->duracion} minutos</p>";
    }
}
?>
