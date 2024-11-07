<?php
session_start();
include 'dbconnect.php';
$username = $password = '';
$login_error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "
        SELECT username, password, 'admin' AS user_type FROM admins WHERE username=? AND password=? 
        UNION 
        SELECT username, password, 'staff' AS user_type FROM staff WHERE username=? AND password=? ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $password, $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        header("Location: " . ($row['user_type'] === 'admin' ? "admin_dashboard.php" : "staff_dashboard.php"));
        exit;
    } else {
        
        $sql_user = "SELECT username, password FROM users WHERE username=? AND password=?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("ss", $username, $password);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $_SESSION['username'] = $username;
            header("Location: user_dashboard.php");
            exit;
        } else {
            $login_error = "Invalid username or password.";
        }
    }
    $stmt->close();
    $stmt_user->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login - Blood Bank Management System</title>
    <script>
        function showAlert() {
            <?php if (!empty($login_error)): ?>
                alert("<?php echo $login_error; ?>");
                document.getElementById('loginForm').reset();
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
                <a href="index.html" class="button">Home</a>
                <a href="register.php" class="button">Register</a>
                <a href="about.html" class="button">About</a>
            </div>
        </div>
    </nav>
    <div class="form-container">
        <h2>Login</h2>
        <form id="loginForm" action="" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
