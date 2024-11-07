<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
?>

<?php
include 'dbconnect.php';
$request_id = $donor_id = $blood_type = $blood_units = "";
$success_message = "";
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = htmlspecialchars(trim($_POST['request_id']));
    $donor_id = htmlspecialchars(trim($_POST['donor_id']));
    $blood_type = htmlspecialchars(trim($_POST['blood_type']));
    $blood_units = htmlspecialchars(trim($_POST['blood_units']));
    $conn->begin_transaction();

    $check_query = "SELECT patient_name, hospital_address FROM blood_requests WHERE request_id = ? AND blood_type = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $request_id, $blood_type);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $receiver_name = $row['patient_name'];
        $hospital_address = $row['hospital_address'];

        $insert_query = "INSERT INTO receivers (receiver_id, receiver_name, receiver_blood_type, receiver_blood_units, hospital_address, status) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        $status = "completed";
        $insert_stmt->bind_param("ssssss", $request_id, $receiver_name, $blood_type, $blood_units, $hospital_address, $status);

        if ($insert_stmt->execute()) {
            $delete_query = "DELETE FROM blood_requests WHERE request_id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("s", $request_id);
            $delete_stmt->execute();

            $update_query = "UPDATE blood SET blood_units = blood_units - ? WHERE blood_type = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("is", $blood_units, $blood_type);
            $update_stmt->execute();

            $conn->commit();
            $success_message = "Donation recorded successfully, blood request deleted, and blood availability updated.";
        } else {
            $error_message = "Error inserting into receivers: " . $insert_stmt->error;
        }
    } else {
        $error_message = "No matching blood type for the given request ID.";
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
    <title>Add Donation - Blood Bank Management System</title>
    <link rel="stylesheet" href="add_donation.css">
    <script>
        function showAlert() {
            <?php if ($success_message): ?>
                alert("<?php echo $success_message; ?>");
            <?php elseif ($error_message): ?>
                alert("<?php echo $error_message; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body onload="showAlert()">
    <div class='background-overlay'></div>
    <nav class='navbar'>
        <div class='container'>
            <h1>Blood Bank Management System</h1>
            <div class='button-container'>
                <a href='staff_dashboard.php' class='button'>Go Back</a>
            </div>
        </div>
    </nav>
    <section>
        <div class="form-container">
            <h2>Add Donation</h2>
            <form action="" method="post">
                <label for="request_id">Request ID</label>
                <input type="text" id="request_id" name="request_id" required>

                <label for="donor_id">Donor ID</label>
                <input type="text" id="donor_id" name="donor_id" required>

                <label for="blood_type">Blood Type</label>
                <input type="text" id="blood_type" name="blood_type" required>

                <label for="blood_units">Blood Units</label>
                <input type="number" id="blood_units" name="blood_units" required>

                <button type="submit">Submit Donation</button>
            </form>
        </div>
    </section>
</body>
</html>
