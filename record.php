<?php
// Database configuration
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "studentportal_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : '';

// Fetch student information
$sql = "SELECT * FROM student WHERE student_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $studentInfo = $result->fetch_assoc();
    $stmt->close();
}

// Fetch student records based on the selected year
$sql = "SELECT * FROM student_records WHERE student_id = ?";
if ($selectedYear != '') {
    $sql .= " AND year = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id, $selectedYear);
} else {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
}
$stmt->execute();
$result = $stmt->get_result();
$studentRecords = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter {
            text-align: center;
            margin-bottom: 20px;
        }
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .student-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .student-info img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .student-info div {
            display: inline-block;
            text-align: left;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a.add-record {
            color: #4CAF50;
            text-decoration: none;
        }
        a.add-record:hover {
            text-decoration: underline;
        }
        nav {
            background-color: #f4f4f4;
            padding: 10px 0;
            text-align: center;
        }
        nav a {
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
        }
        nav a:hover {
            background-color: #ddd;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include 'dashboard2.php'; ?>
    <div class="container">
        <h2>Student Records</h2>
        <div class="student-info">
            <?php if ($studentInfo): ?>
                <img src="<?php echo htmlspecialchars($studentInfo["picture"]); ?>" alt="Profile Picture">
                <br>
                <div>
                    <strong>Name:</strong> <?php echo htmlspecialchars($studentInfo['name']); ?><br>
                    <strong>Student ID:</strong> <?php echo htmlspecialchars($studentInfo['student_id']); ?><br>
                    <strong>Course:</strong> <?php echo htmlspecialchars($studentInfo['course']); ?><br>
                    <strong>Current Year:</strong> <?php echo htmlspecialchars($studentInfo['year']); ?>
                </div>
            <?php else: ?>
                <p>No student found with the given ID.</p>
            <?php endif; ?>
        </div>
        <div class="filter">
            <label for="year">Select Year: </label>
            <select id="year" name="year" onchange="filterByYear(this.value)">
                <option value="">All Years</option>
                <option value="1st year" <?php if ($selectedYear == '1st year') echo 'selected'; ?>>1st year</option>
                <option value="2nd year" <?php if ($selectedYear == '2nd year') echo 'selected'; ?>>2nd year</option>
                <option value="3rd year" <?php if ($selectedYear == '3rd year') echo 'selected'; ?>>3rd year</option>
                <option value="4th year" <?php if ($selectedYear == '4th year') echo 'selected'; ?>>4th year</option>
            </select>
        </div>
        <table>
            <?php 
                $semesters = array('1st semester', '2nd semester');
                foreach ($semesters as $semester) {
                    $hasRecords = false;
                    foreach ($studentRecords as $record) {
                        if ($record['semester'] == $semester) {
                            if (!$hasRecords) {
                                $hasRecords = true;
                                echo "<thead>";
                                echo "<tr><th colspan='7'>Semester: {$semester}</th></tr>";
                                echo "<tr>";
                                echo "<th>Code</th>";
                                echo "<th>Subject</th>";
                                echo "<th>Preliminary</th>";
                                echo "<th>Midterm</th>";
                                echo "<th>Pre-finals</th>";
                                echo "<th>Finals</th>";
                                echo "<th>Total Grade</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                            }
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($record['code']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['subject']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['preliminary']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['midterm']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['prefinals']) . "</td>";
                            echo "<td>" . htmlspecialchars($record['finals']) . "</td>";
                            $total_grade = ($record['preliminary'] + $record['midterm'] + $record['prefinals'] + $record['finals']) / 4;
                            echo "<td>" . htmlspecialchars($total_grade) . "</td>";
                            echo "</tr>";
                        }
                    }
                    if ($hasRecords) {
                        echo "</tbody>";
                    }
                }
            ?>
        </table>
    </div>
    <script>
        function filterByYear(year) {
            var studentId = '<?php echo htmlspecialchars($id); ?>';
            window.location.href = 'record.php?id=' + encodeURIComponent(studentId) + '&year=' + encodeURIComponent(year);
        }
    </script>
</body>
</html>
