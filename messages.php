<?php
session_start();
if($_SESSION['Role'] != 'ADMIN'){
header('Location: index.php?error=Access denied'); 

 exit;
}
// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "studentportal_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT * FROM message";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Students</title>
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
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        td img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
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
        .buttons a.view {
            background-color: #ffa500;
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
            background-color: rgba(0,0,0,0.4);
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
        .container {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
    <script>
        function confirmDelete(studentId) {
            document.getElementById('confirmDeletePopup').style.display = 'block';
            document.getElementById('deleteButton').onclick = function() {
                window.location.href = 'delete_annoucement.php?id=' + studentId;
            }
        }

        function closePopup() {
            document.getElementById('confirmDeletePopup').style.display = 'none';
        }
    </script>
</head>
<body>
    <?php include 'dashboard1.php'; ?>
    <div class="center">
        
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="addAnnouncement.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Add New Announcement</a>
        </div>
        <table>
            <tr>
                <th colspan="8"><center><h2 style="text-align: center;">ANNOUNCEMENT</h2></center></th>
            </tr>
            <tr>
                <th>Description</th>
                <th>Release Date</th>
                <th>Action</th>
                
                
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                    
                    echo "<td class='buttons'>
                            <a href='edit_announcement.php?id=" . $row["id"] . "' class='edit'>Edit</a>
                            <a href='#' onclick='confirmDelete(" . $row["id"] . ")' class='delete'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align: center;'>No records found</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>

    <!-- The Popup -->
    <div id="confirmDeletePopup" class="popup-container">
        <div class="popup-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this student?</p>
            <button id="deleteButton" class="confirm">Yes, Delete</button>
            <button onclick="closePopup()" class="cancel">Cancel</button>
        </div>
    </div>
</body>
</html>
