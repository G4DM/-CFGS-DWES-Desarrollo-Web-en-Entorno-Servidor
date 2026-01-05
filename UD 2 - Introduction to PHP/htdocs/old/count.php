<?php
include_once 'cabecera.inc.php';
?>

<main>
    <h1>Numbers from 1 to 30</h1>
    <ul>
        <?php
        for ($i = 1; $i <= 30; $i++) {
            echo "<li>$i</li>";
        }
        ?>
    </ul>

    <h2>Factorial of 5</h2>
    <?php
    $number = 5;
    $factorial = 1;
    $steps = "";
    for ($i = $number; $i >= 1; $i--) {
        $factorial *= $i;
        $steps .= $i;
        if ($i > 1) {
            $steps .= " x ";
        }
    }
    echo "<p>{$number}! = {$steps} = {$factorial}</p>";
    ?>
</main>

<?php
include_once 'footer.inc.php';
?>
