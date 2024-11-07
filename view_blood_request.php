<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); 
    exit();
}
?>
<?php
include 'dbconnect.php';

$bloodrequests = [];

$query = "SELECT * FROM blood_requests";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bloodrequests[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Blood Requests</title>
    <link rel="stylesheet" href="view_blood_request.css">
</head>
<body>
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
        <div class="table-container">
            <h2>Blood Requests List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Patient Name</th>
                        <th>Hospital Address</th>
                        <th>Blood Type</th>
                        <th>Requested Units</th>
                        <th>Request Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bloodrequests)): ?> <!-- Use $bloodrequests here -->
                        <tr>
                            <td colspan="6" style="text-align: center;">No blood requests found.</td> 
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bloodrequests as $request): ?> <!-- Use $bloodrequests here -->
                            <tr>
                                <td><?php echo htmlspecialchars($request['request_id']); ?></td>
                                <td><?php echo htmlspecialchars($request['patient_name']); ?></td>
                                <td><?php echo htmlspecialchars($request['hospital_address']); ?></td>
                                <td><?php echo htmlspecialchars($request['blood_type']); ?></td>
                                <td><?php echo htmlspecialchars($request['blood_units']); ?></td>
                                <td><?php echo htmlspecialchars($request['request_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
