<?php
// db_config.php
$servername = "localhost";   // Usually localhost for MySQL/MariaDB
$username = "root";          // MySQL username
$password = "password";              // MySQL password (set this as needed)
$dbname = "university";      // Database name (adjust accordingly)

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

