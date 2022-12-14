<?php
session_start();

// initializing variables
$username = "";
$email = "";
$firstName = "";
$lastName = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'demo');

// REGISTER USER
if (isset($_POST['register'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($db, $_POST['lastName']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $emailConfirm = mysqli_real_escape_string($db, $_POST['emailConfirm']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $passwordConfirm = mysqli_real_escape_string($db, $_POST['passwordConfirm']);
  $profilePic = "../img/basic_profile.webp";

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($firstName)) { array_push($errors, "Email is required"); }
  if (empty($lastName)) { array_push($errors, "Email is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password)) { array_push($errors, "Password is required"); }
  if ($email != $emailConfirm) {
	array_push($errors, "The two emails do not match");
  }
  if ($password != $passwordConfirm) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($passwordConfirm);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, firstName, lastName, email, password, profilePic) 
  			  VALUES('$username', '$firstName', '$lastName', '$email', '$password', '$profilePic')";
  	mysqli_query($db, $query);
    $_SESSION['password'] = $password;
  	$_SESSION['username'] = $username;
    $_SESSION['profilePic'] = $profilePic;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: ./index.php');
  }
}

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $profilePic = "../img/basic_profile.webp";

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
      $_SESSION['password'] = $password;
  	  $_SESSION['username'] = $username;
      $_SESSION['profilePic'] = $profilePic;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: ./index.php');
  	}else {
  		array_push($errors, "Wrong username or password");
  	}
  }
}

if (isset($_POST['update'])) {
  $oldUsername = $_SESSION['username'];
  $newUsername = mysqli_real_escape_string($db, $_POST['username']);
  $oldPassword = $_SESSION['password'];
  $password = md5(mysqli_real_escape_string($db, $_POST['password']));
  $newPassword = md5(mysqli_real_escape_string($db, $_POST['newPassword']));
  $newPasswordConfirm = md5(mysqli_real_escape_string($db, $_POST['newPasswordConfirm']));
  $OldProfilPic = $_SESSION['profilePic'];
  $profilPic = $_FILES['uploadfile']["name"];

  if (($password != empty($password)) && ($password == $oldPassword)) {
    
    if(empty($newUsername)){  
      $_SESSION['username'] = $oldUsername;
    }
    elseif ($newUsername !== empty($newUsername)) {
      $query = "UPDATE users SET username='$newUsername' WHERE username='$oldUsername'";
      mysqli_query($db, $query);
      $_SESSION['username'] = $newUsername;
    }

    if(empty($newPassword)){  
      $_SESSION['password'] = $oldPassword;
    }
    
    elseif (($newPassword !== empty($newPassword)) && ($newPassword == $newPasswordConfirm)) {
      $query = "UPDATE users SET password='$newPassword' WHERE password='$oldPassword'";
      mysqli_query($db, $query);
      $_SESSION['password'] = $newPassword;
    }
    if(empty($profilPic)){  
      $_SESSION['profilePic'] = $OldProfilPic;
    }
    elseif($profilPic !== empty($profilPic)){
      $tempname = $_FILES["uploadfile"]["tmp_name"];
      $folder = "../img/" .  $profilPic;
      $sql = "UPDATE users SET profilePic='$folder' WHERE profilePic='$OldProfilPic'";
   
      // Execute query
      mysqli_query($db, $sql);
   
      // Now let's move the uploaded image into the folder: image
      if (move_uploaded_file($tempname, $folder)) {
          $_SESSION['profilePic'] = $folder;
      } else {
        array_push($errors, "Failed to upload image");
      }
    }

    
  }else{
    array_push($errors, "Password is required or incorrect");
  }
}

mysqli_close($db);



?>