<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO receivers (receiver_name, hospital_address, receiver_blood_type, receiver_blood_units, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $_POST['receiver_name'], $_POST['hospital_address'], $_POST['receiver_blood_type'], $_POST['receiver_blood_units'], $_POST['status']);
    
    if ($stmt->execute()) {
        echo "<script>alert('New receiver record added successfully.'); window.location.href='add_receiver.php';</script>";
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
    <link rel="stylesheet" href="add_receiver.css"> 
    <title>Add Receiver</title>
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
            <h2>Add Receiver</h2>
            <form method="POST">
                <label for="receiver_name">Receiver Name:</label>
                <input type="text" name="receiver_name" required>
                
                <label for="hospital_address">Hospital Address:</label>
                <input type="text" name="hospital_address" required>
                
                <label for="receiver_blood_type">Receiver Blood Type:</label>
                <input type="text" name="receiver_blood_type" required>
                
                <label for="receiver_blood_units">Receiver Blood Units:</label>
                <input type="number" name="receiver_blood_units" required>
                
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
                <button type="submit">Add Receiver</button>
            </form>
        </div>
    </section>
</body>
</html>
