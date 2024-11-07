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
$receiver_id = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_POST['receiver_id'];

    $check_stmt = $conn->prepare("SELECT * FROM receivers WHERE receiver_id = ?");
    $check_stmt->bind_param("i", $receiver_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM receivers WHERE receiver_id = ?");
        $stmt->bind_param("i", $receiver_id);
        
        if ($stmt->execute()) {
            $success_message = "Receiver record deleted successfully!";
            $receiver_id = ''; 
        } else {
            $error_message = "Error deleting receiver record: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        $error_message = "Receiver ID not found in the database!";
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
    <title>Delete Receiver Record</title>
    <link rel='stylesheet' href='delete_receiver.css'> 
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
            <h2>Delete Receiver Record</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="receiver_id">Receiver ID:</label>
                <input type="text" name="receiver_id" value="<?php echo htmlspecialchars($receiver_id); ?>" required>
                
                <button type="submit">Delete Receiver Record</button>
            </form>
        </div>
    </section>
</body>
</html>
