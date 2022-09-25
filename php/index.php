<?php
  require( './Mp3Info/src/Mp3Info.php' );  // Include _Mp3Info_'s source file with its declarations
  use wapmorgan\Mp3Info\Mp3Info;
  session_start();



  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: ./login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: ./login.php");
  }
  $profilePath = $_SESSION['profilePic'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ratify</title>
	<link rel="stylesheet" type="text/css" href="../css/home.css">
  <script src="../js/audio.js"></script>
</head>
<body>

<div class="sidenav">
  <a href="./index.php">Home</a>
  <div class="dropdown">
  <a class="droplink" href="./profile.php">Profile
    <div class="dropdown-content">
    <a href="./edit_profile.php">Update Profile</a>
    </div>
  </a>
  </div>
</div>

<div class = "header">  <img class="logo" src="../img/logo.webp" alt="">
<div class="form-div search-header">
      <form action="index.php" method="POST">
        <input name="key" type="text" placeholder="Search"><input type="submit" value="Submit" name="search">
      </form>
    </div>
<?php  if (isset($_SESSION['username'])) : ?>
    	<div class="userinfo"><a  class="links"  href="index.php?logout='1'"><button class="logout-button">Logout</button></a> <?php echo "<img src='$profilePath' alt=Img >" ; ?> <?php echo $_SESSION['username']; ?></div>
    <?php endif ?></div>

    <div class="row">
  <div class="column side">
  </div>
  
  <div class="column middle">
  <?php 
  ?>

    <h2>Songs</h2>

<!-- (B) PLAYLIST -->
<div id="demoList"><?php
include('./songDatabase.php');
include('./search.php');



  // (B1) GET ALL SONGS


function playSong($music){
// (B2) OUTPUT SONGS IN <DIV>
if (is_array($music)) { foreach ($music as $s) {
  $audio = new Mp3Info($s, true);
  printf("<div data-src='%s' class='song'>%s</div>", $s, basename($audio->tags['song'].'<br> from '.$audio->tags['artist']));
  echo ' <p class="duration">duration: '.floor($audio->duration / 60).' min '.floor($audio->duration % 60).' sec </p>';
}} else {  array_push($errors, "No songs or artist found!"); }
}
playSong($songs);

?></div>
 
   
  </div>
  
  <div class="column side">

  </div>
</div>
 

<div class="footer">
        <!-- (A) AUDIO TAG -->
        <audio id="demoAudio" controls></audio>
</div>


</body>
</html>