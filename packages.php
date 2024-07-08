<?php
session_start();
require_once 'db.php'; // Ensure this path is correct

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Ensure this path is correct -->
    <style>
        .package-box {
            display: inline-block;
            width: 150px;
            height: 150px;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
            cursor: pointer;
        }

        .package-box:hover {
            transform: scale(1.05);
            background-color: #f0f0f0;
        }

        h2, p {
            margin: 0;
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Select Packages</h1>
    </header>
    <main>
        <?php
        // Fetch packages from the database
        $query = "SELECT package_id, price, duration FROM Packages";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Define descriptive words for the duration
                $duration = '';
                switch ($row['duration']) {
                    case '5':
                        $duration = 'Quick Browsing';
                        break;
                    case '60':
                        $duration = '1 Hour';
                        break;
                    case '1440':
                        $duration = '1 Day';
                        break;
                    case '4320':
                        $duration = '3 Days';
                        break;
                    case '10080':
                        $duration = '7 Days';
                        break;
                    case '43200':
                        $duration = '1 Month';
                        break;
                    default:
                        $duration = $row['duration'] . ' Minutes';
                }
                echo '<div class="package-box" onclick="redirectToPayment(' . $row['package_id'] . ')">';
                echo '<h2>Ksh ' . htmlspecialchars($row['price']) . '</h2>';
                echo '<p>' . htmlspecialchars($duration) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No packages available.</p>';
        }

        $conn->close();
        ?>
    </main>
    <script>
        function redirectToPayment(packageId) {
            window.location.href = "payment.php?package_id=" + packageId;
        }
    </script>
</body>
</html>
