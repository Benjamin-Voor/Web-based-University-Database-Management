<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "university";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute a query and display results in a table
function displayQueryResults($query, $conn) {
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Displaying table headers dynamically based on column names
        echo "<table border='1'><tr>";
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

// Instructor Courses Search
if (isset($_POST['instructor_name'])) {
    $instructor_name = $_POST['instructor_name'];
    $query = "SELECT c.course_id, c.title 
              FROM course c 
              JOIN teaches t ON c.course_id = t.course_id 
              JOIN instructor i ON i.ID = t.ID
              WHERE i.name LIKE '%$instructor_name%'";
    echo "<h2>Instructor Courses Search Results</h2>";
    displayQueryResults($query, $conn);
}

// Student Enrolled Courses
if (isset($_POST['student_name'])) {
    $student_name = $_POST['student_name'];
    $query = "SELECT c.course_id, c.title
              FROM course c
              JOIN takes t ON c.course_id = t.course_id
              JOIN student s ON s.ID = t.ID
              WHERE s.name LIKE '%$student_name%'";
    echo "<h2>Student Enrolled Courses Results</h2>";
    displayQueryResults($query, $conn);
}

// Department Course Listings
if (isset($_POST['department_name'])) {
    $department_name = $_POST['department_name'];
    $query = "SELECT c.course_id, c.title
              FROM course c
              JOIN department d ON c.dept_name = d.dept_name
              WHERE d.dept_name LIKE '%$department_name%'";
    echo "<h2>Department Course Listings</h2>";
    displayQueryResults($query, $conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Database Search</title>
</head>
<body>
    <h1>University Database Management</h1>

    <!-- Instructor Courses Search Form -->
    <h2>Search Courses by Instructor</h2>
    <form method="POST" action="">
        <label for="instructor_name">Enter Instructor Name: </label>
        <input type="text" id="instructor_name" name="instructor_name" required>
        <button type="submit">Search Courses</button>
    </form>

    <br><br>

    <!-- Student Enrolled Courses Form -->
    <h2>Search Enrolled Courses by Student</h2>
    <form method="POST" action="">
        <label for="student_name">Enter Student Name: </label>
        <input type="text" id="student_name" name="student_name" required>
        <button type="submit">Search Enrollments</button>
    </form>

    <br><br>

    <!-- Department Course Listings Form -->
    <h2>Search Courses by Department</h2>
    <form method="POST" action="">
        <label for="department_name">Enter Department Name: </label>
        <input type="text" id="department_name" name="department_name" required>
        <button type="submit">Show Courses</button>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>

