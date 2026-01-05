<?php
// division.php
// Definimos una excepción personalizada extendiendo Exception

class MiExcepcion extends Exception
{
    // Podemos personalizar __toString() o simplemente usar el mensaje custom.
    public function __toString()
    {
        return "MiExcepcion [Código {$this->getCode()}]: {$this->getMessage()} (Archivo: {$this->getFile()} Línea: {$this->getLine()})";
    }
}

/**
 * divide: divide dos valores con comprobaciones
 * @param mixed $numerador
 * @param mixed $divisor
 * @return float|int
 * @throws MiExcepcion
 */
function divide($numerador, $divisor)
{
    if (!is_numeric($numerador) || !is_numeric($divisor)) {
        throw new MiExcepcion("Parámetros no numéricos. Recibido: numerador=" . gettype($numerador) . ", divisor=" . gettype($divisor), 1001);
    }

    if ($divisor == 0) {
        throw new MiExcepcion("División por cero no permitida.", 1002);
    }

    return $numerador / $divisor;
}

// Programa principal
try {
    echo "10 / 2 = " . divide(10, 2) . PHP_EOL;

    // Forzamos división por cero
    echo "Intento 5 / 0 -> ";
    echo divide(5, 0) . PHP_EOL;
} catch (MiExcepcion $e) {
    // Tratamos específicamente MiExcepcion
    echo "Capturada MiExcepcion: " . $e->getMessage() . PHP_EOL;
    // Si quieres ver más detalle:
    // echo $e->__toString() . PHP_EOL;
} catch (Exception $e) {
    // Captura genérica por si algo inesperado ocurre
    echo "Excepción genérica: " . $e->getMessage() . PHP_EOL;
}
