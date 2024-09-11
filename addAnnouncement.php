<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentportal_db";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];

    date_default_timezone_set('Asia/Manila');
    $date = date('Y-m-d h:i A');
    
    // Insert record
    $stmt = $conn->prepare("INSERT INTO message (description, date) VALUES (?, ?)");
    $stmt->bind_param("ss", $description, $date);

    if ($stmt->execute()) {

        header('Location: messages.php');
        exit();
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
            <div class="back-arrow"><a href="messages.php" style="margin-right: 100%; "><strong><span class="material-symbols-outlined">arrow_back_ios</span></strong></a></div>
            <table>
                <tr>
                    <th colspan="2">ADD ANNOUNCEMENT</th>
                </tr>
                <tr>
                <th>Description:</th>
                <th><textarea name="description" rows="4" cols="35"></textarea></th>
            </tr>
                
                <tr>
                    <th colspan="2"><input type="submit" value="Submit"></th>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
