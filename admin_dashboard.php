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
    <link rel='stylesheet' href='admin_dashboard.css'> 
    <title>Admin Dashboard</title>
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
        <h2>Welcome, Admin!</h2>
        <div class='dashboard-container'>
            <div class='dashboard-section'>
                <h3>Manage Donors</h3>
                <div class='button-container'>
                    <a href='add_donor.php' class='button'>Add Donor</a>
                    <a href='edit_donor.php' class='button'>Edit Donor</a>
                    <a href='delete_donor.php' class='button'>Delete Donor</a>
                    <a href='view_donor.php' class='button'>View Donors</a>
                </div>
            </div>
            <div class='dashboard-section'>
                <h3>Manage Receivers</h3>
                <div class='button-container'>
                    <a href='add_receiver.php' class='button'>Add Receiver</a>
                    <a href='edit_receiver.php' class='button'>Edit Receiver</a>
                    <a href='delete_receiver.php' class='button'>Delete Receiver</a>
                    <a href='view_receiver.php' class='button'>View Receivers</a>
                </div>
            </div>
            <div class='dashboard-section'>
                <h3>Manage Blood Units</h3>
                <div class='button-container'>
                    <a href='add_blood.php' class='button'>Add Blood Unit</a>
                    <a href='edit_blood.php' class='button'>Edit Blood Unit</a>
                    <a href='delete_blood.php' class='button'>Delete Blood Unit</a>
                    <a href='view_blood.php' class='button'>View Blood Units</a>
                </div>
            </div>
            <div class='dashboard-section'>
                <h3>Manage Staff</h3>
                <div class='button-container'>
                    <a href='add_staff.php' class='button'>Add Staff</a>
                    <a href='edit_staff.php' class='button'>Edit Staff</a>
                    <a href='delete_staff.php' class='button'>Delete Staff</a>
                    <a href='view_staff.php' class='button'>View Staff</a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
