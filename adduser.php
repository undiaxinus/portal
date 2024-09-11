 <?php
include_once("conn.php");
$conn = connection();

$sql = "SELECT * FROM accounts";
$employees = $conn->query($sql) or die($conn->error);
$row = $employees->fetch_assoc();
if(isset($_POST['submit'])){
  $fname = $_POST['fname'];
  $mname = $_POST['mname'];
  $lname = $_POST['lname'];
  $uname = $_POST['uname'];
  $pass = $_POST['password'];
  //$role = $_POST['role'];
  $Profile = $_FILES['Profile']['name'];
  if(!empty($Profile)){
      move_uploaded_file($_FILES['Profile']['tmp_name'], 'images/'.$Profile); 
    }
  $sql = "INSERT INTO `accounts`(`firstname`,`middlename`, `lastname`, `username`, `password`, `Profile`) VALUES ('$fname','$mname','$lname','$uname','$pass','$Profile')";
  $conn->query($sql) or die ($conn->error);

  

  header('Location: account.php?success=Record added');

}
?>
