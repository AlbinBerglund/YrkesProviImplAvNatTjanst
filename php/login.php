<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
	<body>
		<?php?>


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
    


	</body>
</html>