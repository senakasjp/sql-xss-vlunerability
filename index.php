<?php
// config.php
$host = 'localhost';
$user = 'root';
$pass = 'root';
$dbname = 'vulnapp';
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login & Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function showRegister() {
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("registerForm").style.display = "block";
        }
        function showLogin() {
            document.getElementById("registerForm").style.display = "none";
            document.getElementById("loginForm").style.display = "block";
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <a href="#" onclick="showRegister()">Register a new user</a> | 
    <a href="#" onclick="showLogin()">Back to Login</a>

    <!-- Login Form -->
    <div id="loginForm">
        <h2>Login</h2>
        <form method="POST">
            <input type="hidden" name="action" value="login">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Login</button>
        </form>
    </div>

    <!-- Registration Form -->
    <div id="registerForm" style="display:none;">
        <h2>Register</h2>
        <form method="POST">
            <input type="hidden" name="action" value="register">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="new_username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="text" name="new_password" class="form-control" required>
            </div>
            <button class="btn btn-success" type="submit">Register</button>
        </form>
    </div>

    <hr>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        echo "Welcome, $username<br>";

        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<div class='alert alert-success text-center'>Welcome, $username!</div>";
            echo "<div class='text-center'>You entered: Username = $username, Password = $password</div>";
            echo "<div class='text-center'><strong>Accounts found:</strong><br>";
            echo "<table class='table table-bordered w-50 mx-auto'><tr><th>ID</th><th>Username</th><th>Password</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['password']}</td></tr>";
            }
            echo "</table></div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Invalid credentials</div>";
        }
    }

    if ($_POST['action'] === 'register') {
        $new_user = $_POST['new_username'];
        $new_pass = $_POST['new_password'];

        $sql = "INSERT INTO users (username, password) VALUES ('$new_user', '$new_pass')";
        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>User '$new_user' registered successfully.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error registering user: " . $conn->error . "</div>";
        }
    }
}
?>

</div>
</body>
</html>