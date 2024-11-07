<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
    $stmt = $conn->prepare("INSERT INTO staff (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $_POST['username'], $_POST['password']);
    
    if ($stmt->execute()) {
        echo "<script>alert('New staff member added successfully.'); window.location.href='add_staff.php';</script>";
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
    <link rel="stylesheet" href="add_staff.css"> 
    <title>Add Staff</title>
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
            <h2>Add Staff Member</h2>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                
                <button type="submit">Add Staff</button>
            </form>
        </div>
    </section>
</body>
</html>
