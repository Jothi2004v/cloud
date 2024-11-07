<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
?>
<?php
include 'dbconnect.php';
$error_message = '';
$success_message = '';
$blood_id = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_id = $_POST['blood_id'];
    $check_stmt = $conn->prepare("SELECT * FROM blood WHERE blood_id = ?");
    $check_stmt->bind_param("i", $blood_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {

        $stmt = $conn->prepare("DELETE FROM blood WHERE blood_id = ?");
        $stmt->bind_param("i", $blood_id);
        
        if ($stmt->execute()) {
            $success_message = "Blood record deleted successfully!";
            $blood_id = ''; 
        } else {
            $error_message = "Error deleting blood record: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        $error_message = "Blood ID not found in the database!";
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
    <title>Delete Blood Record</title>
    <link rel='stylesheet' href='delete_blood.css'>
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
            <h2>Delete Blood Record</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="blood_id">Blood ID:</label>
                <input type="text" name="blood_id" value="<?php echo htmlspecialchars($blood_id); ?>" required>
                
                <button type="submit">Delete Blood Record</button>
            </form>
        </div>
    </section>
</body>
</html>
