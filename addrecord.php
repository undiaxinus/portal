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
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $code = $_POST['code'];
    $subject = $_POST['subject'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $preliminary = $_POST['preliminary'];
    $midterm = $_POST['midterm'];
    $prefinals = $_POST['prefinals'];
    $finals = $_POST['finals'];
    $total_grade = ($preliminary + $midterm + $prefinals + $finals) / 4;

    // Insert record
    $stmt = $conn->prepare("INSERT INTO student_records (student_id, year, semester, preliminary, midterm, prefinals, finals, code, subject) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssssss", $student_id, $year, $semester, $preliminary, $midterm, $prefinals, $finals, $code, $subject);

    if ($stmt->execute()) {
        header('location:view_student.php?id='.$id);
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Student Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .center {
            margin-top: 50px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: auto;
        }
        table {
            width: 100%;
        }
        th {
            text-align: left;
            padding-bottom: 10px;
        }
        th[colspan="2"] {
            text-align: center;
            font-size: 24px;
            padding-bottom: 20px;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #f2f2f2;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: calc(100% - 16px);
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php include 'dashboard1.php'; ?>
    <div class="center">
        <form action="" method="post">
            <table>
                <tr>
                    <th colspan="2">ADD STUDENT RECORD</th>
                </tr>
                <tr>
                    <th>Student ID:</th>
                    <th><input type="text" name="student_id" value="<?php echo $id ?>" readonly></th>
                </tr>
                <tr>
                    <th>Code:</th>
                    <th><input type="text" name="code" required></th>
                </tr>
                <tr>
                    <th>Subject:</th>
                    <th><input type="text" name="subject" required></th>
                </tr>
                <tr>
                    <th>Year:</th>
                    <th>
                        <select name="year" required>
                            <option value="" hidden>Select Year</option>
                            <option value="1st year">1st year</option>
                            <option value="2nd year">2nd year</option>
                            <option value="3rd year">3rd year</option>
                            <option value="4th year">4th year</option>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>Semester:</th>
                    <th>
                        <select name="semester" required>
                            <option value="" hidden>Select Semester</option>
                            <option value="1st semester">1st semester</option>
                            <option value="2nd semester">2nd semester</option>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>Preliminary:</th>
                    <th><input type="number" name="preliminary" step="0.01" ></th>
                </tr>
                <tr>
                    <th>Midterm:</th>
                    <th><input type="number" name="midterm" step="0.01" ></th>
                </tr>
                <tr>
                    <th>Pre-finals:</th>
                    <th><input type="number" name="prefinals" step="0.01" ></th>
                </tr>
                <tr>
                    <th>Finals:</th>
                    <th><input type="number" name="finals" step="0.01" ></th>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" value="Submit"></th>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
