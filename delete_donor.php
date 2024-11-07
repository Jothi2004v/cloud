<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
include 'dbconnect.php';

$error_message = '';
$success_message = '';
$donor_id = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $donor_id = $_POST['id'];

    $check_stmt = $conn->prepare("SELECT * FROM donors WHERE donor_id = ?");
    $check_stmt->bind_param("i", $donor_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM donors WHERE donor_id = ?");
        $stmt->bind_param("i", $donor_id);
        
        if ($stmt->execute()) {
            $success_message = "Donor deleted successfully!";
            $donor_id = ''; 
        } else {
            $error_message = "Error deleting donor: " . htmlspecialchars($stmt->error);
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
    <title>Delete Donor</title>
    <link rel='stylesheet' href='delete_donor.css'>
</head>
<body>
<div class='background-overlay'></div>
    <nav class='navbar'>
        <h1>Blood Bank Management System</h1>
        <div class='button-container'>
            <a href='admin_dashboard.php' class='button'>Go Back</a>
        </div>
    </nav>
    <section>
        <div class="form-container">
            <h2>Delete Donor</h2>
            
            <?php if ($error_message): ?>
                <script>alert("<?php echo htmlspecialchars($error_message); ?>");</script>
            <?php endif; ?>
            
            <?php if ($success_message): ?>
                <script>alert("<?php echo htmlspecialchars($success_message); ?>");</script>
            <?php endif; ?>

            <form method="POST">
                <label for="id">Donor Id:</label>
                <input type="text" name="id" value="<?php echo htmlspecialchars($donor_id); ?>" required>
                
                <button type="submit">Delete Donor</button>
            </form>
        </div>
    </section>
</body>
</html>
