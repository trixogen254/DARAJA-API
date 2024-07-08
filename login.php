<?php
session_start();
require_once 'db.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging: Output the received username and password
    echo "Username: " . htmlspecialchars($username) . "<br>";
    echo "Password: " . htmlspecialchars($password) . "<br>";

    $stmt = $conn->prepare("SELECT user_id, password FROM Users WHERE username = ?");
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id; // Store user ID in session
            echo "Login successful! Redirecting...";
            header("Location: packages.php"); // Redirect to packages.php after successful login
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <main>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php
        // Debugging
        echo "Session ID: " . session_id() . "<br>";
        echo "Session User ID: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "Not set") . "<br>";
        ?>
    </main>
</body>
</html>
