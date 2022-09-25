<?php
$errors = array(); 
$songs = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'demo');

if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($db, $_POST['key']);
    $query = "SELECT * FROM music WHERE name LIKE '%$search%' OR artist LIKE '%$search%' ORDER BY name";
    $results = mysqli_query($db, $query); 
  
    if (mysqli_num_rows($results) > 0) {
      while($row = mysqli_fetch_assoc($results)) {
        array_push($songs, $row['path']);
        }
  
  }else {
    array_push($errors, "No songs or artist found!");
  }
   
  }
  

?>