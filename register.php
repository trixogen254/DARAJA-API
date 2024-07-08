<?php
require_once 'db.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $error = "Username already exists. Please choose another one.";
    } else {
        // Insert the new user
        $stmt = $conn->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . $stmt->error;
        }
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
    <title>Register</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Ensure this path is correct -->
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>
    <main>
        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <?php
        if (isset($error)) {
            echo "<p style='color:red;'>$error</p>";
        }
        ?>
    </main>
</body>
</html>
