<footer>
    <?php
    // Set time zone
    date_default_timezone_set('Europe/Madrid');

    // Numbers for weekday, day, month and year
    $weekdayNum = date("w");   // 0 (Sunday) – 6 (Saturday)
    $dayNum     = date("j");   // Day of month without leading zeros
    $monthNum   = date("n");   // 1 – 12
    $year       = date("Y");   // Full year

    // Weekday in Spanish
    switch ($weekdayNum) {
        case 0:
            $weekday = "Domingo";
            break;
        case 1:
            $weekday = "Lunes";
            break;
        case 2:
            $weekday = "Martes";
            break;
        case 3:
            $weekday = "Miércoles";
            break;
        case 4:
            $weekday = "Jueves";
            break;
        case 5:
            $weekday = "Viernes";
            break;
        case 6:
            $weekday = "Sábado";
            break;
    }

    // Month in Spanish
    switch ($monthNum) {
        case 1:
            $month = "enero";
            break;
        case 2:
            $month = "febrero";
            break;
        case 3:
            $month = "marzo";
            break;
        case 4:
            $month = "abril";
            break;
        case 5:
            $month = "mayo";
            break;
        case 6:
            $month = "junio";
            break;
        case 7:
            $month = "julio";
            break;
        case 8:
            $month = "agosto";
            break;
        case 9:
            $month = "septiembre";
            break;
        case 10:
            $month = "octubre";
            break;
        case 11:
            $month = "noviembre";
            break;
        case 12:
            $month = "diciembre";
            break;
    }

    // Print footer
    echo "<p>&copy; " . date("Y") . " Gabriel Daniel Manea | $weekday, $dayNum de $month de $year</p>";
    ?>
</footer>