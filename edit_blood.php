<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
$error_message = '';
$success_message = '';
$blood_id = '';
$blood_type = '';
$blood_units = '';
$donor_id = '';
$donation_date = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_id = $_POST['blood_id'];

    $check_stmt = $conn->prepare("SELECT * FROM blood WHERE blood_id = ?");
    $check_stmt->bind_param("i", $blood_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE blood SET blood_type = ?, blood_units = ?, donor_id = ?, donation_date = ? WHERE blood_id = ?");
        $stmt->bind_param("siisi", $_POST['blood_type'], $_POST['blood_units'], $_POST['donor_id'], $_POST['donation_date'], $blood_id);
        
        if ($stmt->execute()) {
            $success_message = "Blood record updated successfully!";
     
            $blood_id = ''; 
            $blood_type = ''; 
            $blood_units = ''; 
            $donor_id = ''; 
            $donation_date = ''; 
        } else {
            $error_message = "Error updating blood record: " . htmlspecialchars($stmt->error);
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
    <title>Edit Blood Record</title>
    <link rel='stylesheet' href='edit_blood.css'>
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
            <h2>Edit Blood Record</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="blood_id">Blood ID:</label>
                <input type="text" name="blood_id" value="<?php echo htmlspecialchars($blood_id); ?>" required>
                
                <label for="blood_type">Blood Type:</label>
                <input type="text" name="blood_type" value="<?php echo htmlspecialchars($blood_type); ?>" required>
                
                <label for="blood_units">Blood Units:</label>
                <input type="number" name="blood_units" value="<?php echo htmlspecialchars($blood_units); ?>" required>
                
                <label for="donor_id">Donor ID:</label>
                <input type="text" name="donor_id" value="<?php echo htmlspecialchars($donor_id); ?>" required>
                
                <label for="donation_date">Donation Date:</label>
                <input type="date" name="donation_date" value="<?php echo htmlspecialchars($donation_date); ?>" required>
                
                <button type="submit">Update Blood Record</button>
            </form>
        </div>
    </section>
</body>
</html>
