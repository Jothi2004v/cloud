<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $hospital_address = $_POST['hospital_address'];
    $blood_type = $_POST['blood_type'];
    $blood_units = $_POST['blood_unit'];

    $sql = "INSERT INTO blood_requests (patient_name, hospital_address, blood_type, blood_units) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $patient_name, $hospital_address, $blood_type, $blood_units);

    if ($stmt->execute()) {
        $success_message = "Blood request submitted successfully!";
    } else {
        $error_message = "Error submitting blood request: " . $stmt->error;
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
    <link rel="stylesheet" href="blood_request.css">
    <title>Blood Request</title>
    <script>
        function showAlert() {
            <?php if (isset($success_message)): ?>
                alert("<?php echo $success_message; ?>");
            <?php elseif (isset($error_message)): ?>
                alert("<?php echo $error_message; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body onload="showAlert()">
<div class='background-overlay'></div>
    <nav class="navbar">
        <div class="container">
            <h1>Blood Bank Management System</h1>
            <div class="button-container">
                <a href="user_dashboard.php" class="button">Go back</a>
            </div>
        </div>
    </nav>
    <section>
        <div class="form-container">
            <h2>Request Blood</h2>
            <form action="" method="post">
                <label for="patient_name">Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" required>

                <label for="hospital_address">Hospital Address:</label>
                <input type="text" id="hospital_address" name="hospital_address" required>

                <label for="blood_type">Blood Type:</label>
                <input type="text" id="blood_type" name="blood_type" required>

                <label for="blood_unit">Blood Unit:</label>
                <input type="text" id="blood_unit" name="blood_unit" required>

                <button type="submit">Submit Request</button>
            </form>
        </div>
    </section>
</body>
</html>
