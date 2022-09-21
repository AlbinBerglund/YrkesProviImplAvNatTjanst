<?php
use wapmorgan\Mp3Info\Mp3Info;
// initializing variables
$name = "";
$artist = "";
$album = "";
$yearOfRelease = "";
$errors = array(); 
$allSongs = glob("./audio/*.{mp3,webm,ogg,wav}", GLOB_BRACE);

if (is_array($allSongs)) { foreach ($allSongs as $k=>$s) {
$audio = new Mp3Info($s, true);
$db = mysqli_connect('localhost', 'root', '', 'demo');
$name = mysqli_real_escape_string($db, $audio->tags['song']);
$artist = mysqli_real_escape_string($db, $audio->tags['artist']);
$album = mysqli_real_escape_string($db, $audio->tags['album']);
$yearOfRelease = mysqli_real_escape_string($db, $audio->tags['year']);
$path = mysqli_real_escape_string($db, $s);

$user_check_query = "SELECT * FROM music WHERE name='$name' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$music = mysqli_fetch_assoc($result);

if ($music) { // if song exists
  if ($music['name'] === $name) {
    array_push($errors, "Song already exists");
  }
}

if (count($errors) == 0) {
    $query = "INSERT INTO music (name, artist, album, yearOfRelease, path) 
              VALUES('$name', '$artist', '$album', '$yearOfRelease', '$path')";
    mysqli_query($db, $query);
}
}} else { echo "No songs found!"; }

?>