<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='staff_dashboard.css'> 
    <title>Staff Dashboard</title>
</head>
<body>
<div class='background-overlay'></div>
    <nav class='navbar'>
        <div class='container'>
            <h1>Blood Bank Management System</h1>
            <div class='button-container'>
                <a href='logout.php' class='button'>Logout</a>
            </div>
        </div>
    </nav>
    <section>
        <h2>Welcome, Staff!</h2>
        <div class="button-container">
            <a href="staff_add_donor.php" class="button">Add Donor</a>
            <a href="add_donation.php" class="button">Add Blood Donation</a>
            <a href="blood_available.php" class="button">Blood Available</a>
            <a href="view_blood_request.php" class="button">View Blood Requests</a> 
        </div>
    </section>
</body>
</html>
