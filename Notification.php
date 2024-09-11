<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentportal_db";

// Create connection
$conns = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conns->connect_error) {
    die("Connection failed: " . $conns->connect_error);
}

// Fetch messages from the database
$sqls = "SELECT description, date FROM message";
$results = $conns->query($sqls);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Announcements</title>
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
    </style>
</head>
<body>
    <?php include 'dashboard2.php'; ?>
    <div class="center">
        <?php if (!empty($_GET['id'])): ?>
        <table>
            <tr>
                <th colspan="2"><center><h2>ANNOUNCEMENT</h2></center></th>
            </tr>
            <tr>
                <th>Description</th>
                <th>Release Date</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($rows = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo isset($rows['description']) ? htmlspecialchars($rows['description']) : 'N/A'; ?></td>
                        <td><?php echo isset($rows['date']) ? htmlspecialchars($rows['date']) : 'N/A'; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No announcements found</td>
                </tr>
            <?php endif; ?>
            <?php $conn->close(); ?>
        </table>
        <?php endif; ?>
    </div>
</body>
</html>
