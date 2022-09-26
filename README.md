# YrkesProviImplAvNatTjanst ::: Ratify
En spotify clone som heter Ratify. Den använder sig av php och mysqli och lite javascript.

### Projektet
poängen med Projektet är för TekniskImplementeringAvNatTjanst examsdel prov.

### Database
Om man vill göra en copia av min copia av spotify så måste du använda en databas. Men det är enkelt allt du måste göra är att öppna din [localhost](https://www.awordfromnet.com/install-xampp-setup-localhost/) och [phpmyadmin](https://blog.templatetoaster.com/xampp-phpmyadmin/). Sen ska du klicka på Importera knappen och sätt in [demo.sql](demo.sql) filen.

### Funktion
Jag kan börjar med att förklara hur login och register fungerar. 

I Register använder jag av mig en form attribut för att få informationen från input fälderna och skicka de till config.php. Jag har också en link och en h3 rubrik för att kunna gå fram och tillbacka mellan Login och Register. Jag includear också [Error.php](error.php) för att visa mysslyckande. Jag tog delar ifrån [codewithawa.com](https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database)
```html
 <div class="form-div form-div-register">
      <form action="register.php" method="post" >
         <a class="links" href="login.php"><h3>SIGN IN</h3></a> 
         <h3 class="links link-main-page">SIGN UP</h3>
          <div>
              <?php  include('error.php');  ?>
              <input placeholder="Username" type="text" name="username" value="<?php echo $username; ?>">
          </div>
      </form>
</div>
```
Register är inte mycket svårar än det.

Login är lika enklet med samma system som Register. Och märke till på båda formerna att vi har i sista inputen en namn som T.ex. login, det är mycket viktigt senare. 
```html

        <div class="form-div form-div-login">
            <form action="login.php" method="post">
               <img class="logo" src="../img/logo.webp" alt="">
               <div class="links-con">
               <h3 class="links link-main-page">SIGN IN</h3>
                <a class="links" href="register.php"><h3>SIGN UP</h3></a> 
                </div>
                <?php include('error.php'); ?>
                <div>
                    <input placeholder="Username" type="text" name="username" id="username">
                </div>
                <div>
                    <input placeholder="Password" type="password" name="password" id="password">
                </div>
                <section>
                    <input name="login" type="submit"/>
                </section>
            </form>
        </div>
```

Nu går jag till viktigast file i Ratify [config.php](config.php). Filen har all logik olika former vi använder, här börjar vi med mysqli och sessions. 
Först så klart måste man delcara sinna variablar och sätter på session som är ett sätt att spara huvud lika variablar som T.ex. Username. Vi också behöver att konnetarar med databasen. 

```php
session_start();

$username = "";
$email = "";
$firstName = "";
$lastName = "";
$errors = array(); 

$db = mysqli_connect('localhost', 'root', '', 'demo');
```
Efter vi har declerara våra variablar så använder vi oss av input fälden i registerna som heter `register`. Det kanske ser skrämmande ut men det är mycket enklet, allt vi göra att att ta input fälderna från [register.php](register.php) med `$_POST`. `mysqli_real_escape_string` är ett sätt att ta bort onödiga karatäerar från text stränger som vi sparar i en variablar. `$profilePic` är vår default profile pic som vi kan ändra i [edit_profile](edit_profile.php).
```php
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
  ```
Nästa steg bara tittar om nån av variablarna är ennu tomma och här börjar vi använda oss av [Error.php](error.php) som knuffar en error kommentar i en arrayen. Den tittar också om `$password` och `$passwordConfirm` är samma.
```php
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
  ```
  Här så tittar om namnet och email är inte redan på databasen, om det finns så skickar den ut en error meddlande.
  ```php
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
  ```
Jag tittar här om det finns någon errors och om allting fungerar som det skall så försöker den sätta alla variabler till databasen. Jag declarar olika sessions för varaibler som jag behöver runt programmet. När allt har gått igenom så för vi user till [hemsidan](index.php). Kom ihåg att krypterar lösenordet.
```php
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
```
Till näst har vi login logiken. Den följer ennufär samma väg som Register men lite annat. Vi declearar bara den här gången `$username`, `$password` och `$profilePic`. Något nytta som jag göra är att använda [WHERE](https://www.w3schools.com/php/php_mysql_select_where.asp) för att hitta `$username` och `$password` om den finns i databasen och om den finns så sätter vi dem som sessions.
```php
if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

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
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: ./index.php');
  	}else {
  		array_push($errors, "Wrong username or password");
  	}
  }
}
```
Sista formen som är [update](edit_profile.php) där vi kan uppdaterar profilen med nytt username, password och profil bild. Först tittar vi om fälden för lössenordet är tomt, om det är inte så börjar vi titta om någon annan av dem är och bara skippar över dem om de är. Att sätta en ny profil var mycket svårt att få fungera men jag först satt en temp namn i en variable för att sätta bilden i rätt mapp och sen spara vart den skall. Till sista så sparade jag pathen i databasen och om man behöver den så kan man ta ner pathen och använda den. Jag använde [geeksforgeeks.org](https://www.geeksforgeeks.org/how-to-upload-image-into-database-and-display-it-using-php/) exemple här.
```php
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
```

Och till sista så stänger vi databasen
```php
mysqli_close($db);
```
Nu så kan jag förklara [huvudsidan](index.php) av Ratify. jag kan börjar med [Mp3Info](https://github.com/wapmorgan/Mp3Info) som är en libaray som låter mig ta extra information från mp3 filer som T.ex. namn och artist. Vi också starta här en session för att se om usern är inloggade. Om det finns ingen `$username` i session så kaster den ut till login sidan och vi göra logout logiken här.
```php
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
```
nästa sak jag tar upp är headern där vi har profil bilden, namn och en logout knapp. När knappen är tryckt så kommer de loga ut dig. 

```php
<div class = "header">  <img class="logo" src="../img/logo.webp" alt="">
<div class="form-div search-header">
      <form action="index.php" method="POST">
        <input name="key" type="text" placeholder="Search"><input type="submit" value="Submit" name="search">
      </form>
    </div>
<?php  if (isset($_SESSION['username'])) : ?>
    	<div class="userinfo"><a  class="links"  href="index.php?logout='1'"><button class="logout-button">Logout</button></a> <?php echo "<img src='$profilePath' alt=Img width=30 height=30 >" ; ?> <?php echo $_SESSION['username']; ?></div>
    <?php endif ?></div>
```    
Här kommer den minst roliga saken i världen. Det tog minståne 30 timmar att få det här att fungera. Jag includar [songDatabase.php](songDatabase.php) och [search.php](search.php). `songDatabase.php` innehåller alla sånger med variabeln `$songs` och sätter alla sånger i databasen fint. `search.php` letar genom databasen med `LIKE` och tar upp alla sånger den hittar som är nära vad den söker. Jag kommer gå bat-shit-crazy snart, klockan är 2:00, jag fungerar på 5 timmar sömn. Med [Mp3Info](https://github.com/wapmorgan/Mp3Info) så kan jag få veta mera information om sången som T.ex. tiden och namn. För att få audio player att fungera blev jag tvingade att använda Javascript. Jag tog mycket saker ifrån [code-boxx.com](https://code-boxx.com/custom-audio-player-playlist/).
```php
<!-- (B) PLAYLIST -->
<div id="demoList"><?php
include('./songDatabase.php');
include('./search.php');

// (B2) OUTPUT SONGS IN <DIV>
if (is_array($songs)) { foreach ($songs as $s) {
  $audio = new Mp3Info($s, true);
  include('./coverArt.php');
  printf( '<div class="box"><img src= alt=Img width=70 height=70 ></div>' .  "<div data-src='%s' class='song'>%s</div>", $s, basename($audio->tags['song'] . '<br> from '.$audio->tags['artist']));
  echo ' <p class="duration">duration: '.floor($audio->duration / 60).' min '.floor($audio->duration % 60).' sec </p>';
}} else {  array_push($errors, "No songs or artist found!"); }
```
Till sista har jag min jätte finna audio player
```html
<div class="footer">
        <!-- (A) AUDIO TAG -->
        <audio id="demoAudio" controls></audio>
</div>
```
#### ⚠️ det fanns mycket mera av annan kod men jag orkar inte längre. Jag har satt kanske 150 timmar på den här med alla clean resets och förhand functions.
#### ⚠️ Please ge mig en 5, aint no way nån annan göra så här doc





  
  

  
  


