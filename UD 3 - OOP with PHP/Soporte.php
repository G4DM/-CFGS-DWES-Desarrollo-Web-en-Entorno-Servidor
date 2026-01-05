<?php
class Soporte {
    public $titulo;
    private $numero;
    protected $precio; // protected porque las subclases lo usarán

    private const VAT = 0.21;

    public function __construct($titulo, $numero, $precio) {
        $this->titulo = $titulo;
        $this->numero = $numero;
        $this->precio = $precio;
    }

    // Getters
    public function getNumero() {
        return $this->numero;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getPrecioConIVA() {
        return round($this->precio * (1 + self::VAT), 2);
    }

    // Setters
    public function setPrecio($nuevoPrecio) {
        $this->precio = $nuevoPrecio;
    }

    // Mostrar resumen
    public function muestraResumen() {
        echo "<p>{$this->titulo}<br>";
        echo "{$this->precio} € (IVA no incluido)</p>";
    }
}
?>
