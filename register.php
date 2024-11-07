<?php
$name = $email = $username = $city = $phone = $blood_group = $dob = "";
$password = ""; 
$success_message = ""; 
$error_message = ""; 
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $username = htmlspecialchars(trim($_POST['username']));
    $city = htmlspecialchars(trim($_POST['city']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $blood_group = htmlspecialchars(trim($_POST['blood_group']));
    $dob = htmlspecialchars(trim($_POST['dob']));
    
    if (isset($_POST['password'])) {
        $password = htmlspecialchars(trim($_POST['password'])); // Keep the password as plaintext
    }

    $check_email = "SELECT email FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_email);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $error_message = "Email already exists.";
    } else {
        $sql = "INSERT INTO users (name, email, username, dob, city, phone, blood_group, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $name, $email, $username, $dob, $city, $phone, $blood_group, $password); // Use plaintext password
        
        if ($stmt->execute()) {
            $success_message = "Registration successful!";
            $name = $email = $username = $city = $phone = $blood_group = $dob = ""; 
        } else {
            $error_message = "Error: " . $stmt->error; 
        }

        $stmt->close(); 
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
    <link rel="stylesheet" href="register.css">
    <title>Register - Blood Bank Management System</title>
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
    <div class="navbar">
        <div class="container">
            <h1>Blood Bank Management System</h1>
            <div class="button-container">
                <a href="index.html" class="button">Home</a>
                <a href="login.php" class="button">Login</a>
                <a href="about.html" class="button">About</a>
            </div>
        </div>
    </div>
    <div class="form-container">
        <h2>Register</h2>
        <form action="" method="post"> 
            <div class="form-row">
                <div class="form-column">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob); ?>" required>
                </div>
                <div class="form-column">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($city); ?>" required>

                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>

                    <label for="blood-group">Blood Group</label>
                    <input type="text" id="blood-group" name="blood_group" value="<?php echo htmlspecialchars($blood_group); ?>" required>
                </div>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
