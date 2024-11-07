<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO blood (blood_type, blood_units, donor_id, donation_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $_POST['blood_type'], $_POST['blood_units'], $_POST['donor_id'], $_POST['donation_date']);
    
    if ($stmt->execute()) {
        echo "<script>alert('New blood record added successfully.'); window.location.href='add_blood.php';</script>";
        exit(); 
    } else {
        echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "');</script>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="add_blood.css">
    <title>Add Blood</title>
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
        <div class="form-container">
            <h2>Add Blood</h2>
            <form method="POST">
                <label for="blood_type">Blood Type:</label>
                <input type="text" name="blood_type" required>
                <label for="blood_units">Blood Units:</label>
                <input type="number" name="blood_units" required>
                <label for="donor_id">Donor ID:</label>
                <input type="text" name="donor_id" required>
                <label for="donation_date">Donation Date:</label>
                <input type="date" name="donation_date" required>
                <button type="submit">Add Blood</button>
            </form>
        </div>
    </section>
</body>
</html>
