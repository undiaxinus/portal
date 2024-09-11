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

// Check if form is submitted
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $student_id = $_POST['student_id'];
    $year = $_POST['year'];
    $course = $_POST['course'];
    $address = $_POST['address'];
    $picture = $_FILES['picture'];

    if ($picture['size'] > 0) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($picture["name"]);
        move_uploaded_file($picture["tmp_name"], $target_file);
    } else {
        $target_file = $_POST['existing_picture'];
    }

    // Update record
    $sql = "UPDATE student SET name = ?, student_id = ?, address = ?, picture = ?, year = ?, course = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $student_id, $address, $target_file, $year, $course, $id);


    if ($stmt->execute()) {
        header("Location: studentlist.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing record
    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "Student not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Student</title>
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
        input[type="text"], input[type="file"] {
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
        #profileDisplay {
            display: block;
            margin: 10px auto;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        select {
            appearance: none; /* Remove default arrow */
            -webkit-appearance: none; /* Safari and Chrome */
            -moz-appearance: none; /* Firefox */
            background-color: #f2f2f2; /* Background color */
            padding: 8px; /* Padding */
            border: 1px solid #ccc; /* Border */
            border-radius: 4px; /* Border radius */
            width: calc(100% - 16px); /* Width */
            font-size: 16px; /* Font size */
        }
        /* Style the arrow */
        select::after {
            content: '\25BC'; /* Unicode character for down arrow */
            position: absolute; /* Position */
            top: 50%; /* Position from the top */
            right: 8px; /* Position from the right */
            transform: translateY(-50%); /* Translate Y */
            pointer-events: none; /* Disable mouse events */
        }
        .back-arrow a:hover {
            color: #007bff; /* Change the color on hover */
        }
    </style>
</head>
<body>
    <?php include 'dashboard1.php'; ?>
    <div class="center">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
            <input type="hidden" name="existing_picture" value="<?php echo $student['picture']; ?>">
            <table>
                <tr>
                    <th colspan="2"  class="back-arrow"><a href="studentlist.php" style="margin-right: 100%; "><strong><span class="material-symbols-outlined">arrow_back_ios</span></strong></a></th>
                </tr>
                <tr>
                    <th colspan="2">EDIT STUDENT</th>
                </tr>
                <tr>
                    <th>Name:</th>
                    <th><input type="text" name="name" value="<?php echo $student['name']; ?>" required></th>
                </tr>
                <tr>
                    <th>ID No.:</th>
                    <th><input type="text" name="student_id" value="<?php echo $student['student_id']; ?>" required></th>
                </tr>
                <tr>
                    <th>Year:</th>
                    <th><select name="year" required>
                        <option hidden><?php echo $student['year']; ?></option>
                        <option>1st year</option>
                        <option>2nd year</option>
                        <option>3rd year</option>
                        <option>4th year</option>
                    </select></th>
                </tr>
                
                <tr>
                    <th>Course:</th>
                    <th><select name="course" required>
                        <option hidden><?php echo $student['course']; ?></option>
                        <option>Bachelor of Science in Computer Science</option>
                        <option>Bachelor of Science in Information System</option>
                        <option>Bachelor of Science in Computer Science</option>
                        <option>Bachelor of Science in Tourism Management</option>
                        <option>Bachelor of Science in Business Administration</option>
                        <option>Bachelor of Secondary Education</option>
                        <option>Bachelor Technical-Vocational Teacher Education</option>
                        <option>Diploma in Computer Programming and Software Technology</option>
                        <option>Associate in Computer Technology</option>
                    </select></th>
                </tr>
                <tr>
                    <th>Major:</th>
                    <th><input type="text" name="major"></th>
                </tr>
                <tr>
                    <th>Address:</th>
                    <th><input type="text" name="address" value="<?php echo $student['address']; ?>" required></th>
                </tr>
                <tr>
                    <th>Picture:</th>
                    <th>
                        <input type="file" name="picture" id="Profile" accept="image/*" onchange="displayImage(this)">
                        <img id="profileDisplay" src="images/<?php echo $student['picture']; ?>" alt="Profile Picture">
                    </th>
                </tr>
                <tr>
                    <th colspan="2"><input type="submit" value="Update"></th>
                </tr>
            </table>
        </form>
    </div>
    <script>
        function displayImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileDisplay').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
