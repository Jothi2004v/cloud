<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO donors (donor_name, donor_address, donor_phone_no, donor_blood_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $_POST['name'], $_POST['address'], $_POST['phone_number'], $_POST['blood_type']);

    if ($stmt->execute()) {
        echo "<script>alert('New donor added successfully.'); window.location.href='add_donor.php';</script>";
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
    <link rel="stylesheet" href="add_donor.css">
    <title>Add Donor</title>
</head>
<body>
<div class='background-overlay'></div>
    <nav class="navbar">
        <div class="container">
            <h1>Blood Bank Management System</h1>
            <div class="button-container">
                <a href="admin_dashboard.php" class="button">Go Back</a>
            </div>
        </div>
    </nav>
    <section>
        <div class="form-container">
            <h2>Add Donor</h2>
            <form method="POST">
                <label for="name">Donor Name:</label>
                <input type="text" name="name" required>
                
                <label for="address">Donor Address:</label>
                <input type="text" name="address" required>
                
                <label for="phone_number">Donor Phone Number:</label>
                <input type="text" name="phone_number" required>
                
                <label for="blood_type">Donor Blood Type:</label>
                <input type="text" name="blood_type" required>
                
                <button type="submit">Add Donor</button>
            </form>
        </div>
    </section>
</body>
</html>
