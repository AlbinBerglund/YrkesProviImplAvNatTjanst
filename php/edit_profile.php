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
  $profilePath = $_SESSION['profilePic'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ratify</title>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
</head>
<body>

<div class="sidenav">
  <a href="./index.php">Home</a>
  <a href="./profile.php">Profile</a>
</div>

<div class = "header">  <img class="logo" src="../img/logo.webp" alt="">
<?php  if (isset($_SESSION['username'])) : ?>
    	<div class="userinfo"><a  class="links"  href="edit_profile.php?logout='1'"><button class="logout-button">Logout</button></a> <?php echo "<img src='$profilePath' alt=Img width=40 height=40  >" ; ?> <?php echo $_SESSION['username']; ?></div>
    <?php endif ?></div>

    <div class="row">
  <div class="column side">
  </div>
  
  <div class="column middle">
    <h2>Update Profile</h2>
    <div class="form-div">
    <form action="edit_profile.php" method="post" enctype="multipart/form-data" >


                <div>
                    <?php  include('error.php');  ?>
                    <input placeholder="New Username" type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div>
                    <input placeholder="Password" type="password" name="password">
                </div>
                <div>
                    <input placeholder="New Password" type="password" name="newPassword" >
                </div>
                <div>
                    <input placeholder="Confirm New Password" type="password" name="newPasswordConfirm" >
                </div>
                <label for="image_uploads">Choose images to upload (PNG, JPG, WEBP)</label>
                <div>
                <input type="file" id="uploadfile" name="uploadfile" accept=".jpg, .jpeg, .png, .webp" />
                </div>
                <section>
                    <input class="submit-register" name="update" type="submit"/>
                </section>
            </form>
   </div>

 
   
  </div>
  
  <div class="column side">

  </div>
</div>



</body>
</html>