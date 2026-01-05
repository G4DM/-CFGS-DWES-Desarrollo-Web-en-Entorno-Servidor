<?php
// Initialize variables
$errors = [];
$success = false;
$name = $surname = $username = $email = $dob = $gender = '';
$conditions = $advertising = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $conditions = isset($_POST['conditions']);
    $advertising = isset($_POST['advertising']);

    // Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $name)) {
        $errors[] = "Name can only contain letters.";
    }

    // Validate surname
    if (empty($surname)) {
        $errors[] = "Surname is required.";
    } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u", $surname)) {
        $errors[] = "Surname can only contain letters.";
    }

    // Validate username
    if (empty($username)) {
        $errors[] = "Username is required.";
    } elseif (strlen($username) < 4) {
        $errors[] = "Username must be at least 4 characters long.";
    } elseif (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
        $errors[] = "Username can only contain letters, numbers and underscores.";
    }

    // Validate password
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Validate password confirmation
    if (empty($password2)) {
        $errors[] = "Password confirmation is required.";
    } elseif ($password !== $password2) {
        $errors[] = "Passwords do not match.";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $errors[] = "Email format is invalid. Must contain @ and a valid domain.";
    }

    // Validate date of birth
    if (empty($dob)) {
        $errors[] = "Date of birth is required.";
    } else {
        $date = DateTime::createFromFormat('Y-m-d', $dob);
        if (!$date || $date->format('Y-m-d') !== $dob) {
            $errors[] = "Invalid date format.";
        } elseif ($date > new DateTime()) {
            $errors[] = "Date of birth cannot be in the future.";
        }
    }

    // Validate gender
    if (empty($gender)) {
        $errors[] = "Gender is required.";
    } elseif (!in_array($gender, ['male', 'female', 'other'])) {
        $errors[] = "Invalid gender selection.";
    }

    // Validate conditions acceptance
    if (!$conditions) {
        $errors[] = "You must accept the terms and conditions.";
    }

    // If no errors, registration is successful
    if (empty($errors)) {
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="../web/css/registro.css">
</head>
<body>
    <?php include '../inc/header.inc.php'; ?>

    <main>
        <h1>User Registration</h1>

        <?php if ($success): ?>
            <!-- Success message -->
            <div class="success-message">
                <h2>✓ Registration Completed Successfully!</h2>
                <p><strong>Welcome, <?php echo htmlspecialchars($name . ' ' . $surname); ?>!</strong></p>
                <p>Your account has been created successfully.</p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><a href="index.php">Return to Home</a></p>
            </div>
        <?php else: ?>
            <!-- Display errors if any -->
            <?php if (!empty($errors)): ?>
                <div class="error-list">
                    <h3>Please correct the following errors:</h3>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Registration form -->
            <form action="registro.php" method="POST">
                <div class="form-group">
                    <label for="name">Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>">
                </div>

                <div class="form-group">
                    <label for="surname">Surname <span class="required">*</span></label>
                    <input type="text" name="surname" id="surname" value="<?php echo htmlspecialchars($surname); ?>">
                </div>

                <div class="form-group">
                    <label for="username">Username <span class="required">*</span></label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <label for="password2">Confirm Password <span class="required">*</span></label>
                    <input type="password" name="password2" id="password2">
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth <span class="required">*</span></label>
                    <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($dob); ?>">
                </div>

                <div class="form-group">
                    <label>Gender <span class="required">*</span></label>
                    <div class="radio-group">
                        <input type="radio" name="gender" id="male" value="male" <?php echo ($gender === 'male') ? 'checked' : ''; ?>>
                        <label for="male">Male</label><br>
                        <input type="radio" name="gender" id="female" value="female" <?php echo ($gender === 'female') ? 'checked' : ''; ?>>
                        <label for="female">Female</label><br>
                        <input type="radio" name="gender" id="other" value="other" <?php echo ($gender === 'other') ? 'checked' : ''; ?>>
                        <label for="other">Other</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" name="conditions" id="conditions" <?php echo $conditions ? 'checked' : ''; ?>>
                        <label for="conditions">I accept the terms and conditions <span class="required">*</span></label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" name="advertising" id="advertising" <?php echo $advertising ? 'checked' : ''; ?>>
                        <label for="advertising">I accept receiving advertising emails</label>
                    </div>
                </div>

                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
    </main>

    <?php include '../inc/footer.inc.php'; ?>
</body>
</html>