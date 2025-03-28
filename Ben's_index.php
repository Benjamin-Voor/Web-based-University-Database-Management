<!DOCTYPE html>
<html>
<head>
    <title>University Course Search</title>
</head>
<body>
    <h1>Search for Courses</h1>

    <!-- Search by Instructor -->
    <h2>Search by Instructor</h2>
    <form method="post">
        <label for="instructor">Instructor Name:</label>
        <input type="text" id="instructor" name="instructor" value="">
        <button type="submit" name="search_instructor">Search Courses</button>
    </form>

    <!-- Search by Department -->
    <h2>Search by Department</h2>
    <form method="post">
        <label for="department">Department Name:</label>
        <input type="text" id="department" name="department" value="">
        <button type="submit" name="search_department">Show Courses</button>
    </form>

    <!-- Search by Student -->
    <h2>Search by Student</h2>
    <form method="post">
        <label for="student">Student Name:</label>
        <input type="text" id="student" name="student" value="">
        <button type="submit" name="search_student">Show Enrolled Courses</button>
    </form>

    <?php
    if (isset($_POST['search_instructor'])) {
        $instructor = $_POST['instructor'];
        displayCoursesByInstructor($instructor);
    }

    if (isset($_POST['search_department'])) {
        $department = $_POST['department'];
        displayCoursesByDepartment($department);
    }

    if (isset($_POST['search_student'])) {
        $student = $_POST['student'];
        displayCoursesByStudent($student);
    }

    function displayCoursesByInstructor($instructor) {
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
                CREATE TABLE IF NOT EXISTS course (
                    course_id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    instructor VARCHAR(255) NOT NULL
                );
                INSERT INTO course (title, instructor) VALUES 
                    ('Course 1', 'Luis Jaimes'),
                    ('Course 2', 'Luis Jaimes'),
                    ('Course 3', 'Other Instructor')
                ON DUPLICATE KEY UPDATE title=VALUES(title), instructor=VALUES(instructor);
            ";
            $conn->exec($sql);

            // Fetch courses taught by the instructor using a prepared statement
            $query = "SELECT * FROM course WHERE instructor = :instructor";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':instructor', $instructor);
            $stmt->execute();
            $course = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($course) {
                echo "<h2>Courses Taught by $instructor</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Course ID</th><th>Course Name</th><th>Instructor</th></tr>";
                foreach ($course as $course) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($course['course_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['instructor']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No course found for instructor $instructor.";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . htmlspecialchars($e->getMessage());
        }

        $conn = null;
    }

    function displayCoursesByDepartment($department) {
        // Establishing database connection
        $servername = "your_servername";
        $username = "your_username";
        $password = "your_password";
        $dbname = "your_dbname";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch course by department
            $query = "SELECT * FROM course WHERE department = :department";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':department', $department);
            $stmt->execute();
            $course = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($course) {
                echo "<h2>Courses in $department Department</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Course ID</th><th>Course Name</th></tr>";
                foreach ($course as $course) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($course['course_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['title']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No course found for department $department.";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . htmlspecialchars($e->getMessage());
        }

        $conn = null;
    }

    function displayCoursesByStudent($student) {
        // Establishing database connection
        $servername = "your_servername";
        $username = "your_username";
        $password = "your_password";
        $dbname = "your_dbname";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Fetch course by student
            $query = "
                SELECT c.course_id, c.title 
                FROM course c
                JOIN enrollments e ON c.course_id = e.course_id
                JOIN students s ON e.student_id = s.student_id
                WHERE s.student_name = :student
            ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':student', $student);
            $stmt->execute();
            $course = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($course) {
                echo "<h2>Courses Enrolled by $student</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Course ID</th><th>Course Name</th></tr>";
                foreach ($course as $course) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($course['course_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($course['title']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No course found for student $student.";
            }
        } catch (PDOException $e) {
            echo "Connection failed: " . htmlspecialchars($e->getMessage());
        }

        $conn = null;
    }
    ?>
</body>
</html>