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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Displaying username
    echo "Welcome, $username";

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
