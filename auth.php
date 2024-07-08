<?php
include 'db.php';

if (isset($_POST['register'])) {
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $username = substr(str_shuffle("0123456789"), 0, 4);
    $hashed_password = password_hash($username, PASSWORD_BCRYPT);

    $sql = $conn->prepare("INSERT INTO Users (username, phone_number, password) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $username, $phone_number, $hashed_password);

    if ($sql->execute()) {
        echo "Registration successful. Your username is: " . $username;
    } else {
        echo "Error: " . $sql->error;
    }
}

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);

    $sql = $conn->prepare("SELECT * FROM Users WHERE username=? AND phone_number=?");
    $sql->bind_param("ss", $username, $phone_number);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($username, $user['password'])) {
            echo "Login successful";
        } else {
            echo "Invalid username or phone number";
        }
    } else {
        echo "Invalid username or phone number";
    }
}
?>
