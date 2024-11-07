<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php'; 
$query = "SELECT donor_id, donor_name, donor_address, donor_phone_no, donor_blood_type FROM donors";
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
    <link rel='stylesheet' href='view_donor.css'> 
    <title>Donor Information</title>
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
        <h2>Donors</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Donor ID</th>
                        <th>Donor Name</th>
                        <th>Donor Address</th>
                        <th>Donor Phone No</th>
                        <th>Donor Blood Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['donor_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['donor_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['donor_address']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['donor_phone_no']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['donor_blood_type']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No donors available</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
