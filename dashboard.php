<?php

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "studentportal_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total number of students
$sql = "SELECT COUNT(*) AS total_students FROM student";
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_students = $row['total_students'];
} else {
    $total_students = 0;
}

// Fetch the total number of students
$sql = "SELECT COUNT(*) AS total_course FROM course";
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_course = $row['total_course'];
} else {
    $total_course = 0;
}


// Fetch the total number of students
$sql = "SELECT COUNT(*) AS total_subject FROM subject";
$result = $conn->query($sql);

// Check if query was successful
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_subject = $row['total_subject'];
} else {
    $total_subject = 0;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- External CSS link for chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
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
        .container {
            margin: 20px auto;
            padding: 20px;
            max-width: 1000px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .charts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .chart-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .datas, .datas1, .datas2 {
            padding: 20px;
            border-radius: 10px;
            height: 100px;
            font-size: 20px;
            text-align: center;
            color: black;
            display: flex;
            justify-content: center;
            align-items: center;

        }
        .datas { 
            background-color: skyblue;
        }
        .datas1 {
            left: 5%;
            background-color: yellowgreen;
        }
        .datas2 {
            left: 10%;
            background-color: orange;
        }
        a {
            text-decoration: none;
            color: black;
            display: block;
            width: 100%;
            height: 100%;
        }

    </style>
</head>
<body>
    <?php include 'dashboard1.php'; ?>
    <section>
        <header>
            <article>
                <a href="studentlist.php">
                <div class="datas">
                    <center><p><b>Total Students</b></p>
                        <b><p><?php  echo $total_students ?></p></b></center>
                </div></a>
            </article>
            <article>
                <a href="course.php">
                <div class="datas1">
                    <center><p><b>Courses</b></p>
                        <b><p><?php  echo $total_course ?></p></b></center>
                </div></a>
            </article>
            <article>
                <a href="subjects.php">
                <div class="datas2">
                    <center><p><b>Message</b></p>
                        <b><p><?php  echo $total_subject ?></p></b></center>
                </div></a>
            </article>
        </header>
    </section>
    <div class="container">
        <div class="charts">
            <div class="chart-container">
                <canvas id="studentChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="courseChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Sample data for the chart (number of students in each year)
        var studentData = {
            labels: ['1st Year', '2nd Year', '3rd Year', '4th Year'],
            datasets: [{
                label: 'Total Students',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: [100, 120, 90, 80] // Sample data, replace with actual data
            }]
        };

        // Sample data for the pie chart (number of students in each course)
        var courseData = {
            labels: ['BSCS', 'BSTM', 'EDUC', 'BSBA'],
            datasets: [{
                label: 'Total Students',
                backgroundColor: ['#AC38F9','#FF6384', '#36A2EB', '#FFCE56'],
                borderWidth: 1,
                data: [150, 100, 80, 120] // Sample data, replace with actual data
            }]
        };

        // Chart configuration for student chart
        var studentChartOptions = {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        // Chart configuration for course chart
        var courseChartOptions = {
            responsive: true,
            legend: {
                position: 'right',
            },
        };

        // Get the canvas elements
        var studentCtx = document.getElementById('studentChart').getContext('2d');
        var courseCtx = document.getElementById('courseChart').getContext('2d');

        // Create the student chart
        var studentChart = new Chart(studentCtx, {
            type: 'bar',
            data: studentData,
            options: studentChartOptions
        });

        // Create the course chart
        var courseChart = new Chart(courseCtx, {
            type: 'pie',
            data: courseData,
            options: courseChartOptions
        });
    </script>
</body>
</html>
