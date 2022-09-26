<?php
  use wapmorgan\Mp3Info\Mp3Info;
// initializing variables
$name = "";
$artist = "";
$album = "";
$yearOfRelease = "";
$errors = array(); 
$path = "";
$albumCover = "";
$replace = "";
$songs = glob("../audio/*.{mp3,webm,ogg,wav}", GLOB_BRACE);


$db = mysqli_connect('localhost', 'root', '', 'demo');
if (is_array($songs)) { foreach ($songs as $k=>$s) {
$audio = new Mp3Info($s, true);
$name = mysqli_real_escape_string($db, $audio->tags['song']);
$artist = mysqli_real_escape_string($db, $audio->tags['artist']);
$album = mysqli_real_escape_string($db, $audio->tags['album']);
$yearOfRelease = mysqli_real_escape_string($db, $audio->tags['year']);
$path = mysqli_real_escape_string($db, $s);
$removeAudioPath = array("/audio", ".mp3");
$addCoverPath = array("/img/SongImages", "_artwork.jpg");
$albumCover = mysqli_real_escape_string($db, str_replace($removeAudioPath, $addCoverPath, $s));

$user_check_query = "SELECT * FROM music WHERE name='$name' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$music = mysqli_fetch_assoc($result);

if ($music) { // if song exists
  if ($music['path'] === $path) {
    array_push($errors, "Song already exists");
  }
}

if (count($errors) == 0) {
    $query = "INSERT INTO music (name, artist, album, yearOfRelease, path, albumCover) 
              VALUES('$name', '$artist', '$album', '$yearOfRelease', '$path', '$albumCover')";
    mysqli_query($db, $query);
}
}} else {array_push($errors, "No songs or artist found"); }


mysqli_close($db);

?>