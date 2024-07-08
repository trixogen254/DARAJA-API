<?php
session_start();
require_once 'db.php'; // Ensure this path is correct

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get package ID from URL
if (!isset($_GET['package_id'])) {
    echo "Package ID not provided.";
    exit();
}

$package_id = $_GET['package_id'];

// Fetch package details from the database
$stmt = $conn->prepare("SELECT * FROM Packages WHERE package_id = ?");
$stmt->bind_param("i", $package_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $package = $result->fetch_assoc();
    } else {
        echo "Package not found.";
        exit();
    }
} else {
    echo "Error: " . $stmt->error;
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Ensure this path is correct -->
    <style>
        .payment-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Payment for Package</h1>
    </header>
    <main>
        <div class="payment-box">
            <h2>Package: Ksh <?php echo htmlspecialchars($package['price']); ?></h2>
            <p>Duration: <?php echo htmlspecialchars($package['duration']); ?> minutes</p>
            <form action="process_payment.php" method="POST">
                <input type="hidden" name="package_id" value="<?php echo htmlspecialchars($package['package_id']); ?>">
                <button type="submit">Proceed to Payment</button>
            </form>
        </div>
    </main>
</body>
</html>
