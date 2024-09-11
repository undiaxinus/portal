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
$sql = "SELECT * FROM accounts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
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
            text-align: center;
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
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }

        .popup-content h2 {
            margin-top: 0;
        }

        .popup-content label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .popup-content input[type="text"],
        .popup-content input[type="password"],
        .popup-content select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
                window.location.href = 'delete_student.php?id=' + studentId;
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
            <!-- Button to trigger the popup for adding a new user account -->
            <a href="#" onclick="showAddUserPopup()" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px;">Add New User account</a>
        </div>
        <table>
            <tr>
                <th colspan="9"><center><h2 style="text-align: center;">Account</h2></center></th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Firstname</th>
                <th>Middlename</th>
                <th>Lastname</th>
                <th>Username</th>
                <th>Password</th>
                <th>User type</th>
                <th>Picture</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["firstname"] . "</td>";
                    echo "<td>" . $row["middlename"] . "</td>";
                    echo "<td>" . $row["lastname"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["password"] . "</td>";
                    echo "<td>" . $row["usertype"] . "</td>";
                    echo "<td><img src='" . $row["Profile"] . "' alt='Profile Picture'></td>";
                    echo "<td class='buttons'>
                            <a href='edit_student.php?id=" . $row["id"] . "' class='edit'>Edit</a>
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
<div id="addUserPopup" class="popup-container">
        <div class="popup-content">
            <h2>Add New User Account</h2>
            <form action="adduser.php" method="POST">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="fname" required><br>
                
                <label for="middlename">Middle Name:</label>
                <input type="text" id="middlename" name="mname"><br>
                
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lname" required><br>
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="uname" required><br>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                
                <label for="profile">Profile Picture:</label>
                <input type="file" id="profile" name="Profile"><br>
                <!-- 
                <label for="usertype">User Type:</label>
                
                <select id="usertype" name="role">
                    <option value="ADMIN">Admin</option>
                    <option value="USER">User</option>
                </select> --><br>
                
                <button type="submit" name="submit">Create Account</button>
                <button type="button" onclick="closePopup()">Cancel</button>

            </form>
        </div>
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
<script>
        function confirmDelete(studentId) {
            document.getElementById('confirmDeletePopup').style.display = 'block';
            document.getElementById('deleteButton').onclick = function() {
                window.location.href = 'deleteaccount.php?id=' + studentId;
            }
        }

        function closePopup() {
            document.getElementById('confirmDeletePopup').style.display = 'none';
        }

        // Function to display the popup for adding a new user account
        function showAddUserPopup() {
            document.getElementById('addUserPopup').style.display = 'block';
        }
    </script>
    <script>
    function closePopup() {
        document.getElementById('addUserPopup').style.display = 'none';
        window.location.href = 'account.php'; // Redirect to account.php
    }
</script>

</html>
