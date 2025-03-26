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

// Handle registration
if (isset($_POST['register'])) {
    $reg_username = $_POST['reg_username'];
    $reg_password = $_POST['reg_password'];
    
    // Demonstrate password hashing
    $hashed_password = password_hash($reg_password, PASSWORD_DEFAULT);
    
    // Insert into database
    $sql = "INSERT INTO users (username, password) VALUES ('$reg_username', '$hashed_password')";
    if ($conn->query($sql)) {
        echo "<div class='alert alert-success text-center'>Registration successful!<br>Original Password: $reg_password<br>Hashed Password: $hashed_password</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Registration failed: " . $conn->error . "</div>";
    }
}

// Handle login (vulnerable to SQL injection)
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vulnerable SQL query (no sanitization)
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Vulnerable to XSS - displaying raw input
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
?>

<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Demo - SQL Injection, XSS, and Password Hashing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Registration Form -->
            <div class="col-md-6" id="registration">
                <div class="card shadow mb-4">
                    <div class="card-header text-center">
                        <h3>Registration Form</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="reg_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="reg_username" name="reg_username" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="reg_password" name="reg_password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="register" class="btn btn-success">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Login Form (Vulnerable to SQL Injection) -->
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header text-center">
                        <h3>Login Form</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
