<?php

// initializing variables
$name = "";
$artist = "";
$album = "";
$yearOfRelease = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'demo');

$name = mysqli_real_escape_string($db, $audio->tags['song']);
$artist = mysqli_real_escape_string($db, $audio->tags['artist']);
$album = mysqli_real_escape_string($db, $audio->tags['album']);
$yearOfRelease = mysqli_real_escape_string($db, $audio->tags['year']);
<<<<<<< HEAD
$path = mysqli_real_escape_string($db, $s);
=======
>>>>>>> 633cf216eec2949d58348802c3d1158426a622e8

$user_check_query = "SELECT * FROM music WHERE name='$name' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$music = mysqli_fetch_assoc($result);

if ($music) { // if song exists
  if ($music['name'] === $name) {
    array_push($errors, "Song already exists");
  }
}

if (count($errors) == 0) {
<<<<<<< HEAD
    $query = "INSERT INTO music (name, artist, album, yearOfRelease, path) 
              VALUES('$name', '$artist', '$album', '$yearOfRelease', '$path')";
=======
    $query = "INSERT INTO music (name, artist, album, yearOfRelease) 
              VALUES('$name', '$artist', '$album', '$yearOfRelease')";
>>>>>>> 633cf216eec2949d58348802c3d1158426a622e8
    mysqli_query($db, $query);
}

?>