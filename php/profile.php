<?php
 include('config.php');


  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: ../php/login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: ../php/login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ratify</title>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
</head>
<body>

<div class="sidenav">
  <a href="../index.php">Home</a>
  <a href="./profile.php">Profile</a>
  <a href="./edit_profile.php">Update Profile</a>
</div>

<div class = "header">  <img class="logo" src="../img/logo.webp" alt="">
<?php  if (isset($_SESSION['username'])) : ?>
    	<div class="userinfo"><a  class="links"  href="profile.php?logout='1'"><button class="logout-button">Logout</button></a> <?php echo $_SESSION['profilePic']; ?> <?php echo $_SESSION['username']; ?></div>
    <?php endif ?></div>

    <div class="row">
  <div class="column side">
  </div>
  
  <div class="column middle">
    <h2>Profile</h2>

    <?php
    $db = mysqli_connect('localhost', 'root', '', 'demo');
    $username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
        echo "<ul class='userDataList'>";
        while($row = mysqli_fetch_assoc($results)) {
            echo "<li> Username: " . $row["username"]. "</li> <li> Name: " . $row["firstName"]. "</li><li> Lastname: " . $row["lastName"]. "</li> <li> Email: " . $row["email"]. "</li> <li> Created on: " . $row["signUpDate"];
          }
          echo "</ul>";
    }else {
        
    }
   


?>
 

 
   
  </div>
  
  <div class="column side">

  </div>
</div>



</body>
</html>