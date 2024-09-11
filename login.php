<?php
require_once('mysql_connection.php');
session_start();

// Set default value for $type if not set
$type = isset($_GET['usertype']) ? $_GET['usertype'] : '';

// Initialize an error message variable
$error_message = '';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $user_type = $_POST['type'];
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($user_type == 'ADMIN') {
        // Admin login process
        $sql = "SELECT * FROM accounts WHERE username = ?";
        $stmt = $bd->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // User found in the database
                $row = $result->fetch_assoc();
    $passwords = $row['password'];

    if ($passwords === $password) {
        // Password is correct
        $_SESSION['login'] = $row['id'];
        $_SESSION['Role'] = $row['usertype'];

        if ($_SESSION['Role'] == 'ADMIN') {
            
                        header('Location: dashboard.php?id=' . $row['id']);
                        exit();
                    }
                } else {
                    $error_message = "Invalid password for admin.";
                }
            } else {
                $error_message = "Admin username not found.";
            }
        } else {
            $error_message = "Error preparing statement: " . $bd->error;
        }
    } elseif ($user_type == 'USER') {
        // Student login process with student ID
        $sql_student = "SELECT * FROM student WHERE student_id = ?";
        $stmt = $bd->prepare($sql_student);
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Student ID exists in the student_records table
                header('Location: record.php?id=' . urlencode($username));
                exit();
            } else {
                $error_message = "Student ID not found.";
            }
            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $bd->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container header img {
            width: 100%;
            height: auto;
            display: block;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }
        .container img {
            width: 50%;
            height: auto;
            border: 2px solid black;
            border-radius: 10px;
            background-color: #f9f5f5;
            margin-bottom: 20px;
        }
        .container h1 {
            font-size: 25px;
            margin-bottom: 10px;
        }
        .container h2 {
            font-size: 15px;
            margin-bottom: 20px;
            color: #888;
        }
        .container input[type="text"],
        .container input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .container input[type="submit"]:hover {
            background-color: #45a049;
        }
        .container a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #333;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .container a:hover {
            background-color: #f1f1f1;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <header>
            <img src="images/SchoolBanner.png" alt="Banner Image">
        </header>
        <h1>Login Form</h1>
        <h2>(<?php echo htmlspecialchars($type); ?>)</h2>
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <?php if ($type == "ADMIN"): ?>
                <img src="images/icon2.gif" alt="User Image">
            <?php endif; ?>
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>">
            <input type="text" name="username" placeholder="<?php echo $type == 'ADMIN' ? 'Username' : 'Present your school ID no.'; ?>" required>
            <?php if ($type == "ADMIN"): ?>
                <input type="password" name="password" placeholder="Password" required>
            <?php endif; ?>
            <input type="submit" name="submit" value="Login">
            <a href="index.php">Back</a>
        </form>
    </div>
</body>
</html>
