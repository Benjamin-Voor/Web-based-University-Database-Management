<!DOCTYPE html>
<html>
<head>
    <title>Instructor's Courses</title>
</head>
<body>
    <h1>Enter Instructor Name</h1>
    <form method="post">
        <label for="instructor">Instructor Name:</label>
        <input type="text" id="instructor" name="instructor" value="">
        <button type="submit" name="search">Search Courses</button>
    </form>

    <?php
    if (isset($_POST['search'])) {
        $instructor = $_POST['instructor'];
        displayCourses($instructor);
    }

    function displayCourses($instructor) {
        // Establishing database connection
        $servername = "your_servername";
        $username = "your_username";
        $password = "your_password";
        $dbname = "your_dbname";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create table and insert sample data
            $sql = "
                CREATE TABLE IF NOT EXISTS courses (
                    course_id INT AUTO_INCREMENT PRIMARY KEY,
                    course_name VARCHAR(255) NOT NULL,
                    instructor VARCHAR(255) NOT NULL
                );
                INSERT INTO courses (course_name, instructor) VALUES 
                    ('Course 1', 'Luis Jaimes'),
                    ('Course 2', 'Luis Jaimes'),
                    ('Course 3', 'Other Instructor')
                ON DUPLICATE KEY UPDATE course_name=VALUES(course_name), instructor=VALUES(instructor);
            ";
            $conn->exec($sql);

            // Fetch courses taught by the instructor using a prepared statement
            $query = "SELECT * FROM courses WHERE instructor = :instructor";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':instructor', $instructor);
            $stmt->execute();
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($courses) {
                echo "<h2>Courses Taught by $instructor</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Course ID</th><th>Course Name</th><th>Instructor</th></tr>";
                foreach ($courses as $course) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($course['course_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['course_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['instructor']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No courses found for instructor $instructor.";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . htmlspecialchars($e->getMessage());
        }

        $conn = null;
    }
    ?>
</body>
</html>