<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
$error_message = '';
$success_message = '';
$staff_id = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];

    
    $check_stmt = $conn->prepare("SELECT * FROM staff WHERE id = ?");
    $check_stmt->bind_param("i", $staff_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE staff SET username = ?, password = ? WHERE id = ?");
        
        
        $stmt->bind_param("ssi", $_POST['username'], $_POST['password'], $staff_id);

        if ($stmt->execute()) {
            $success_message = "Staff record updated successfully!";
            $staff_id = ''; 
            $username = ''; 
        } else {
            $error_message = "Error updating staff record: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        $error_message = "Staff ID not found in the database!";
    }
    $check_stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff Record</title>
    <link rel='stylesheet' href='edit_staff.css'> 
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
            <h2>Edit Staff Record</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="staff_id">Staff ID:</label>
                <input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id); ?>" required>
                
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                
                <button type="submit">Update Staff Record</button>
            </form>
        </div>
    </section>
</body>
</html>
