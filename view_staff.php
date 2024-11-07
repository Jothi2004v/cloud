<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php'; 
$query = "SELECT id, username, password FROM staff"; 
$result = $conn->query($query);
if (!$result) {
    die("Error retrieving data: ". htmlspecialchars($conn->error));
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='view_staff.css'> 
    <title>Staff View</title>
</head>
<body>
<div class='background-overlay'></div>
    <nav class='navbar'>
        <div class='container'>
            <h1>Blood Bank Management System</h1>
            <div class='button-container'>
                <a href='admin_dashboard.php' class='button'>Go Back</a>
            </div>
        </div>
    </nav>
    <section>
        <h2>Staff Records</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['password']) . "</td>"; 
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No staff available</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
