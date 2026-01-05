<?php
// suma.php
// Función que suma dos parámetros y lanza excepción si no son numéricos

function suma($a, $b) {
    if (!is_numeric($a) || !is_numeric($b)) {
        throw new Exception("Error: Ambos parámetros deben ser números. Recibido: a=" . gettype($a) . ", b=" . gettype($b));
    }
    return $a + $b;
}

// Programa principal: llamamos a la función dentro de try/catch
try {
    echo "Ejemplo válido: 5 + 3 = " . suma(5, 3) . PHP_EOL;

    // Ejemplo inválido: uno de los parámetros no es numérico
    echo "Ejemplo inválido: 'hola' + 2 -> ";
    echo suma("hola", 2) . PHP_EOL; // esto lanzará la excepción
} catch (Exception $e) {
    // Manejo de la excepción: mostramos mensaje limpio
    echo "Se ha producido una excepción: " . $e->getMessage() . PHP_EOL;
    // Opcionalmente, debug:
    // echo "Detalle: " . $e->__toString() . PHP_EOL;
}
