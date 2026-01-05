<?php
include_once "Soporte.php";

class Juego extends Soporte {
    private $consola;
    private $minNumJugadores;
    private $maxNumJugadores;

    public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {
        parent::__construct($titulo, $numero, $precio);
        $this->consola = $consola;
        $this->minNumJugadores = $minNumJugadores;
        $this->maxNumJugadores = $maxNumJugadores;
    }

    public function muestraJugadoresPosibles() {
        if ($this->minNumJugadores === $this->maxNumJugadores) {
            if ($this->minNumJugadores == 1) {
                echo "Para un jugador<br>";
            } else {
                echo "Para {$this->minNumJugadores} jugadores<br>";
            }
        } else {
            echo "De {$this->minNumJugadores} a {$this->maxNumJugadores} jugadores<br>";
        }
    }

    public function muestraResumen() {
        echo "<p>Juego para: {$this->consola}<br>";
        echo "{$this->titulo}<br>";
        echo "{$this->getPrecio()} € (IVA no incluido)<br>";
        $this->muestraJugadoresPosibles();
        echo "</p>";
    }
}
?>
