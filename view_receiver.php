<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}

include 'dbconnect.php';
$receivers = [];
$query = "SELECT * FROM receivers";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $receivers[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Receivers</title>
    <link rel="stylesheet" href="view_receiver.css">
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
        <div class="table-container">
            <h2>Receivers List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Receiver ID</th>
                        <th>Receiver Name</th>
                        <th>Hospital Address</th>
                        <th>Receiver Blood Type</th>
                        <th>Receiver Blood Units</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($receivers)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No receivers found.</td> 
                        </tr>
                    <?php else: ?>
                        <?php foreach ($receivers as $receiver): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($receiver['receiver_id']); ?></td>
                                <td><?php echo htmlspecialchars($receiver['receiver_name']); ?></td>
                                <td><?php echo htmlspecialchars($receiver['hospital_address']); ?></td>
                                <td><?php echo htmlspecialchars($receiver['receiver_blood_type']); ?></td>
                                <td><?php echo htmlspecialchars($receiver['receiver_blood_units']); ?></td>
                                <td><?php echo htmlspecialchars($receiver['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
