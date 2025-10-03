<?php include_once "header.inc.php"; ?>

<main>
    <h1>Contenido de $_SERVER</h1>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_SERVER as $key => $value) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($key) . "</td>";
                echo "<td>" . htmlspecialchars($value) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<?php include_once "footer.inc.php"; ?>