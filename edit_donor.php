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
$donor_id = '';
$name = '';
$address = '';
$phone_number = '';
$blood_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donor_id = $_POST['id'];

    $check_stmt = $conn->prepare("SELECT * FROM donors WHERE donor_id = ?");
    $check_stmt->bind_param("i", $donor_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE donors SET donor_name = ?, donor_address = ?, donor_phone_no = ?, donor_blood_type = ? WHERE donor_id = ?");
        $stmt->bind_param("ssssi", $_POST['name'], $_POST['address'], $_POST['phone_number'], $_POST['blood_type'], $donor_id);
        
        if ($stmt->execute()) {
            $success_message = "Donor updated successfully!";
            $donor_id = ''; 
            $name = ''; 
            $address = ''; 
            $phone_number = ''; 
            $blood_type = ''; 
        } else {
            $error_message = "Error updating donor: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    } else {
        $error_message = "Donor ID not found in the database!";
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
    <title>Edit Donor</title>
    <link rel='stylesheet' href='edit_donor.css'>
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
            <h2>Edit Donor</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="id">Donor Id:</label>
                <input type="text" name="id" value="<?php echo htmlspecialchars($donor_id); ?>" required>
                
                <label for="name">Donor Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                
                <label for="address">Donor Address:</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required>
                
                <label for="phone_number">Donor Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
                
                <label for="blood_type">Donor Blood Type:</label>
                <input type="text" name="blood_type" value="<?php echo htmlspecialchars($blood_type); ?>" required>
                
                <button type="submit">Update Donor</button>
            </form>
        </div>
    </section>
</body>
</html>
