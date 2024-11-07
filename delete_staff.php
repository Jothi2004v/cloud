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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $staff_id = $_POST['staff_id'];


    $check_stmt = $conn->prepare("SELECT * FROM staff WHERE id = ?");
    $check_stmt->bind_param("i", $staff_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {

        $stmt = $conn->prepare("DELETE FROM staff WHERE id = ?");
        $stmt->bind_param("i", $staff_id);
        
        if ($stmt->execute()) {
            $success_message = "Staff record deleted successfully!";
            $staff_id = ''; 
        } else {
            $error_message = "Error deleting staff record: " . htmlspecialchars($conn->error);
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
    <title>Delete Staff Record</title>
    <link rel='stylesheet' href='delete_staff.css'> 
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
            <h2>Delete Staff Record</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="staff_id">Staff ID:</label>
                <input type="text" name="staff_id" value="<?php echo htmlspecialchars($staff_id); ?>" required>
                
                <button type="submit">Delete Staff Record</button>
            </form>
        </div>
    </section>
</body>
</html>
