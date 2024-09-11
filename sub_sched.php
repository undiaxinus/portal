<?php
session_start();
if ($_SESSION['Role'] != 'ADMIN') {
    header('Location: index.php?error=Access denied');
    exit;
}

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

// Fetch student information
$sql = "SELECT * FROM schedule WHERE Course = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$studentInfo = $result->fetch_assoc();

$stmt->execute();
$result = $stmt->get_result();
$studentRecords = $result->fetch_all(MYSQLI_ASSOC);

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
            max-width: 1500px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .add-record-btn {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .add-record-btn:hover {
            background-color: #45a049;
        }

        .student-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .student-info div {
            display: inline-block;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .buttons a {
            padding: 8px 12px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .buttons a.edit {
            background-color: #2196F3;
        }

        .buttons a.delete {
            background-color: #f44336;
        }

        /* Popup container */
        .popup-container {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Popup content */
        .popup-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            border-radius: 5px;
            text-align: center;
        }

        .popup-content h2 {
            margin-top: 0;
        }

        .popup-content button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .popup-content button.confirm {
            background-color: #4CAF50;
            color: white;
        }

        .popup-content button.cancel {
            background-color: #f44336;
            color: white;
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

        .back-arrow a:hover {
            color: #007bff;
        }

        .day-highlight {
            background-color: #ffeb3b;
        }
    </style>
</head>

<body>
    <?php include 'dashboard1.php'; ?>
    <div class="container">

        <div class="back-arrow"><a href="course.php" style="margin-right: 100%; "><strong><span class="material-symbols-outlined">arrow_back_ios</span></strong></a></div>

        <h2>Subject Schedule</h2>

        <div class="filter">
            <a class="add-record-btn" href="addsched.php?id=<?php echo htmlspecialchars($id); ?>&ids=<?php echo htmlspecialchars($ids); ?>&idss=<?php echo htmlspecialchars($idss); ?>">Add Subject schedule</a>
        </div>
        <table>
            <?php
            $hasRecords = false;
            foreach ($studentRecords as $record) {
                if ($id == $record['Course'] && $ids == $record['Major'] && $idss == $record['Year']) {
                    if (!$hasRecords) {
                        $hasRecords = true;
                        echo "<thead>";
                        echo "<tr><th colspan='12'>Course: {$record['Course']}</th></tr>";
                        echo "<tr>";
                        if ($ids != null) {
                            echo "<tr><th colspan='12'>Major: {$record['Major']}</th></tr>";
                        }
                        if ($ids != null) {
                            echo "<tr><th colspan='12'>Year: {$record['Year']}</th></tr>";
                        }
                        
                        echo "<tr>";
                        echo "<th>Prof</th>";
                        echo "<th>Code</th>";
                        echo "<th>Subject</th>";
                        echo "<th>Time</th>";
                        echo "<th>Monday</th>";
                        echo "<th>Tuesday</th>";
                        echo "<th>Wednesday</th>";
                        echo "<th>Thursday</th>";
                        echo "<th>Friday</th>";
                        echo "<th>Saturday</th>";
                        echo "<th>Sunday</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                    }
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($record['Prof']) . "</td>";
                    echo "<td>" . htmlspecialchars($record['Code']) . "</td>";
                    echo "<td>" . htmlspecialchars($record['Subject']) . "</td>";
                    echo "<td>" . htmlspecialchars($record['Timein']) . ' - ' . htmlspecialchars($record['Timeout']) . "</td>";
                    echo "<td class='" . ($record['Day'] == 'Monday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='" . ($record['Day'] == 'Tuesday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='" . ($record['Day'] == 'Wednesday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='" . ($record['Day'] == 'Thursday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='" . ($record['Day'] == 'Friday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='" . ($record['Day'] == 'Saturday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='" . ($record['Day'] == 'Sunday' ? 'day-highlight' : '') . "'></td>";
                    echo "<td class='buttons'>";
                    echo "<a href='edit_sched.php?id=" . htmlspecialchars($record["Course"]) . "&ids=" . htmlspecialchars($record["id"]) . "&idss=" . htmlspecialchars($record["Major"]) . "' class='edit'>Edit</a>";
                    echo "<a href='#' onclick='confirmDelete(" . $record["id"] . ")' class='delete'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            if ($hasRecords) {
                echo "</tbody>";
            }
            ?>
        </table>
    </div>

    <!-- The Popup -->
    <div id="confirmDeletePopup" class="popup-container">
        <div class="popup-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button id="deleteButton" class="confirm">Yes, Delete</button>
            <button onclick="closePopup()" class="cancel">Cancel</button>
        </div>
    </div>
    <script>
        function confirmDelete(recordId) {
            document.getElementById('confirmDeletePopup').style.display = 'block';
            document.getElementById('deleteButton').onclick = function() {
                window.location.href = 'delete_sched.php?id=' + recordId + '&ids=<?php echo htmlspecialchars($id); ?>&idss=<?php echo htmlspecialchars($ids); ?>';
            }
        }

        function closePopup() {
            document.getElementById('confirmDeletePopup').style.display = 'none';
        }
    </script>
</body>

</html>
