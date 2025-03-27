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
    <title>Login Demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <form method="POST">
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
    <hr>

<?php
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Displaying username (insecure on purpose)
    echo "Welcome, $username<br>";

    // Vulnerable SQL query (no sanitization)
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
?>

</div>
</body>
</html>