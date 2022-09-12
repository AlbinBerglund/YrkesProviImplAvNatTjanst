<?php
 include('config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
	<body>
        <div class="form-div form-div-register">
            <form action="register.php" method="post" >
               <img class="logo" src="../img/logo.webp" alt="" >
               <a class="links" href="login.php"><h3>SIGN IN</h3></a> 
               <h3 class="links link-main-page">SIGN UP</h3>

                <div>
                    <?php  include('error.php');  ?>
                    <input placeholder="Username" type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div>
                    <input placeholder="First name" type="text" name="firstName" value="<?php echo $firstName; ?>">
                </div>
                <div>
                    <input placeholder="Last name" type="text" name="lastName" value="<?php echo $lastName; ?>">
                </div>
                <div>
                    <input placeholder="Email" type="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div>
                    <input placeholder="Confirm Email" type="email" name="emailConfirm" >
                </div>
                <div>
                    <input placeholder="Password" type="password" name="password">
                </div>
                <div>
                    <input placeholder="Confirm Password" type="password" name="passwordConfirm" >
                </div>
                <section>
                    <input class="submit-register" name="register" type="submit"/>
                </section>
            </form>
        </div>
    


	</body>
</html>