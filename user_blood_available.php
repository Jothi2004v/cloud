<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
?>
<?php
include 'dbconnect.php'; 
$query = "SELECT blood_type, blood_units FROM blood";
$result = $conn->query($query);
if (!$result) {
    die("Error retrieving data: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='user_blood_available.css'> 
    <title>Blood Availability</title>
</head>
<body>
    <div class='background-overlay'></div>
    <nav class='navbar'>
        <div class='container'>
            <h1>Blood Bank Management System</h1>
            <div class='button-container'>
                <a href='user_dashboard.php' class='button'>Goback</a>
            </div>
        </div>
    </nav>
    <section>
        <h2>Available Blood Units</h2>
        <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Blood Type</th>
                    <th>Blood Units</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['blood_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['blood_units']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No blood available</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        </div>
    </section>
</body>
</html>
