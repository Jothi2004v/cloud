<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php'; 
$query = "SELECT blood_id, blood_type, blood_units, donor_id, donation_date FROM blood";
$result = $conn->query($query);
if (!$result) {
    die("Error retrieving data: " .  htmlspecialchars($conn->error));
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='view_blood.css'> 
    <title>Blood Availability</title>
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
        <h2>Available Blood Units</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Blood ID</th>
                        <th>Blood Type</th>
                        <th>Blood Units</th>
                        <th>Donor ID</th>
                        <th>Donation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['blood_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['blood_type']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['blood_units']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['donor_id']) . "</td>";
                            
                            // Format the donation_date
                            $donationDate = new DateTime($row['donation_date']);
                            echo "<td>" . htmlspecialchars($donationDate->format('Y-m-d')) . "</td>"; 
                            
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No blood available</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
