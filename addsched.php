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
$ids = isset($_GET['ids']) ? $_GET['ids'] : '';
$idss = isset($_GET['idss']) ? $_GET['idss'] : '';
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prof = $_POST['prof'];
    $code = $_POST['code'];
    $subject = $_POST['subject'];
    $start = $_POST['start'];
    $days = $_POST['days'];
    $course = $_POST['course'];
    $major = $_POST['major'];
    $end = $_POST['end'];
    $year = $_POST['year'];
    
    // Insert record
    $stmt = $conn->prepare("INSERT INTO schedule (Prof, Code, Subject, Timein, Day, Course, Major, Timeout, Year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $prof, $code, $subject, $start, $days, $course, $major, $end, $year);

    if ($stmt->execute()) {
        header('location:sub_sched.php?id='.$id.'&ids='.$ids.'&idss='.$idss);
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
            <div class="back-arrow"><a href="sub_sched.php?id=<?php echo $id ?>&ids=<?php echo $ids ?>&idss=<?php echo $idss ?>" style="margin-right: 100%; "><strong><span class="material-symbols-outlined">arrow_back_ios</span></strong></a></div>
            <table>
                <tr>
                    <th colspan="2">ADD SUBJECT SCHEDULE</th>
                </tr>
                <tr>
                    <th>Course:</th>
                    <th><input type="text" name="course" value="<?php echo $id ?>" readonly></th>
                </tr>
                <tr>
                    <th>Major:</th>
                    <th><input type="text" name="major" value="<?php echo $ids ?>" readonly></th>
                </tr>
                <tr>
                    <th>Year:</th>
                    <th><input type="text" name="year" value="<?php echo $idss ?>" readonly></th>
                </tr>
                <tr>
                    <th>Prof:</th>
                    <th><input type="text" name="prof"></th>
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
                    <th>Time Start:</th>
                    <th><input type="time" name="start" ></th>
                </tr>
                <tr>
                    <th>Time End:</th>
                    <th><input type="time" name="end" ></th>
                </tr>
                <tr>
                    <th>Days:</th>
                    <th>
                        <select name="days" required>
                            <option value="" hidden>Select Days</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </th>
                </tr>
                
                <tr>
                    <th colspan="2"><input type="submit" value="Submit"></th>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
