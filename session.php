<?php
include 'db.php';

if (isset($_POST['start_session'])) {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $package_id = $conn->real_escape_string($_POST['package_id']);

    $sql = $conn->prepare("INSERT INTO Sessions (user_id, package_id, start_time) VALUES (?, ?, NOW())");
    $sql->bind_param("ii", $user_id, $package_id);

    if ($sql->execute()) {
        echo "Session started";
    } else {
        echo "Error: " . $sql->error;
    }
}

if (isset($_POST['end_session'])) {
    $session_id = $conn->real_escape_string($_POST['session_id']);

    $sql = $conn->prepare("UPDATE Sessions SET end_time = NOW() WHERE session_id = ?");
    $sql->bind_param("i", $session_id);

    if ($sql->execute()) {
        echo "Session ended";
    } else {
        echo "Error: " . $sql->error;
    }
}
?>
