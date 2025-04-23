<?php
session_start();
include 'db.php';

if (isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if username already exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = 'Username already taken';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = mysqli_query($conn, "INSERT INTO users (username, password_hash) VALUES ('$username', '$hashedPassword')");

        if ($insert) {
            $_SESSION['admin'] = $username;
            header('location: index.php');
            exit();
        } else {
            $error = 'Signup failed. Try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="signup-container">
        <h1>Admin Signup</h1>
        <?php if (isset($error)) { echo '<p class="error">'.htmlspecialchars($error).'</p>'; } ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="signup">Sign Up</button>
        </form>
    </div>
</body>
</html>