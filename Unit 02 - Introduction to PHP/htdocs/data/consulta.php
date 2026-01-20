<?php
// Get form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Not provided';
$lastName = isset($_POST['last-name']) ? htmlspecialchars($_POST['last-name']) : 'Not provided';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Not provided';
$date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : 'Not provided';
$newsletter = isset($_POST['checkbox']) ? 'Yes' : 'No';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Results</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <?php include_once "../inc/header.inc.php"; ?>

    <main>
        <h1>Query Results</h1>
        <div class="results-container">
            <h2>Received Data:</h2>
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><?php echo $name; ?></td>
                </tr>
                <tr>
                    <td><strong>Last Name:</strong></td>
                    <td><?php echo $lastName; ?></td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <td><strong>Date of Birth:</strong></td>
                    <td><?php echo $date; ?></td>
                </tr>
                <tr>
                    <td><strong>Newsletter Subscription:</strong></td>
                    <td><?php echo $newsletter; ?></td>
                </tr>
            </table>
            <br>
            <a href="../web/index.php">Return to Home</a>
        </div>
    </main>

    <?php include_once "../inc/footer.inc.php"; ?>
</body>

</html>