<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "j5!0#PuxF0235N";
$dbname = "onlineStore";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo 'error';
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute a query and display results in a table
function displayQueryResults($query, $conn) {
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Displaying table headers dynamically based on column names
        echo "<table><tr>";
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";

        // Displaying rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results found";
    }
}
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comically Large Store</title>
        <link rel = "stylesheet" href = "styles/main_style.css">
    </head>
    <body>
        <div id = "header">
            <span id = "header_title">
                <h2>Comically Large Store</h2>
            </span>
        </div>

        <span id = "navigation_bar">
            <span>
                <p>Customer</p>
                <a href = "customer.php"></a>
            </span>
            <span>
                <p>Employee</p>
                <a href = "employee.php"></a>
            </span>
            <span>
                <p>Admin</p>
                <a href = "admin.php"></a>
            </span>
        </span>
