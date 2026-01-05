<footer>
    <?php
    // Zona horaria
    date_default_timezone_set('Europe/Madrid');

    // Números de fecha
    $weekdayNum = date("w"); // 0 (domingo) – 6 (sábado)
    $dayNum     = date("j"); // Día del mes
    $monthNum   = date("n"); // 1 – 12
    $year       = date("Y"); // Año completo

    // Arrays multidimensionales para días y meses
    $fecha = [
        "dias"   => ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        "meses"  => [
            1 => "enero",
            "febrero",
            "marzo",
            "abril",
            "mayo",
            "junio",
            "julio",
            "agosto",
            "septiembre",
            "octubre",
            "noviembre",
            "diciembre"
        ]
    ];

    // Acceso directo a los valores
    $weekday = $fecha["dias"][$weekdayNum];
    $month   = $fecha["meses"][$monthNum];

    // Impresión del footer
    echo "<p>&copy; $year Gabriel Daniel Manea | $weekday, $dayNum de $month de $year</p>";
    ?>
</footer>