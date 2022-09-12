<?php
  require( './php/Mp3Info/src/Mp3Info.php' );  // Include _Mp3Info_'s source file with its declarations
  use wapmorgan\Mp3Info\Mp3Info;
  session_start(); 


  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: ./php/login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: ./php/login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ratify</title>
	<link rel="stylesheet" type="text/css" href="./css/home.css">
  <script src="./js/audio.js"></script>
</head>
<body>

<div class="sidenav">
  <a href="#">Profile</a>
  <a href="#">Search</a>
  <a href="#">Playlist</a>
</div>

<div class = "header">  <img class="logo" src="./img/logo.webp" alt="">
<?php  if (isset($_SESSION['username'])) : ?>
    	<div class="userinfo"><a  class="links"  href="index.php?logout='1'"><button class="logout-button">Logout</button></a> <?php echo $_SESSION['profilePic']; ?> <?php echo $_SESSION['username']; ?></div>
    <?php endif ?></div>

    <div class="row">
  <div class="column side">
  </div>
  
  <div class="column middle">
    <h2>Main Content</h2>
    

<!-- (B) PLAYLIST -->
<div id="demoList"><?php
  // (B1) GET ALL SONGS
  $songs = glob("./audio/*.{mp3,webm,ogg,wav}", GLOB_BRACE);

  // (B2) OUTPUT SONGS IN <DIV>
  if (is_array($songs)) { foreach ($songs as $k=>$s) {
    $audio = new Mp3Info($s, true);
    printf("<div data-src='%s' class='song'>%s</div>", $s, basename($audio->tags['song'].'<br> from '.$audio->tags['artist']));
    echo 'duration: '.floor($audio->duration / 60).' min '.floor($audio->duration % 60).' sec';
    include('./php/songDatabase.php');
  }} else { echo "No songs found!"; }
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