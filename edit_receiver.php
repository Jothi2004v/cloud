<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
$error_message = '';
$success_message = '';
$receiver_id = '';
$receiver_name = '';
$hospital_address = '';
$receiver_blood_type = '';
$receiver_blood_units = '';
$status = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_POST['receiver_id'];

    $check_stmt = $conn->prepare("SELECT * FROM receivers WHERE receiver_id = ?");
    $check_stmt->bind_param("i", $receiver_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE receivers SET receiver_name = ?, hospital_address = ?, receiver_blood_type = ?, receiver_blood_units = ?, status = ? WHERE receiver_id = ?");
        $stmt->bind_param("sssiis", $_POST['receiver_name'], $_POST['hospital_address'], $_POST['receiver_blood_type'], $_POST['receiver_blood_units'], $_POST['status'], $receiver_id);
        
        if ($stmt->execute()) {
            $success_message = "Receiver record updated successfully!";
     
            $receiver_id = $receiver_name = $hospital_address = $receiver_blood_type = $receiver_blood_units = $status = '';
        } else {
            $error_message = "Error updating receiver record: " . htmlspecialchars($stmt->error);
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
    <title>Edit Receiver Record</title>
    <link rel='stylesheet' href='edit_receiver.css'> 
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
            <h2>Edit Receiver Record</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="receiver_id">Receiver ID:</label>
                <input type="text" name="receiver_id" value="<?php echo htmlspecialchars($receiver_id); ?>" required>
                
                <label for="receiver_name">Receiver Name:</label>
                <input type="text" name="receiver_name" value="<?php echo htmlspecialchars($receiver_name); ?>" required>
                
                <label for="hospital_address">Hospital Address:</label>
                <input type="text" name="hospital_address" value="<?php echo htmlspecialchars($hospital_address); ?>" required>
                
                <label for="receiver_blood_type">Receiver Blood Type:</label>
                <input type="text" name="receiver_blood_type" value="<?php echo htmlspecialchars($receiver_blood_type); ?>" required>
                
                <label for="receiver_blood_units">Receiver Blood Units:</label>
                <input type="number" name="receiver_blood_units" value="<?php echo htmlspecialchars($receiver_blood_units); ?>" required>
                
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="Pending" <?php echo ($status == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="Completed" <?php echo ($status == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                </select>
                
                <button type="submit">Update Receiver Record</button>
            </form>
        </div>
    </section>
</body>
</html>
