<!DOCTYPE html>
<html lang="en">
<head>
	<title>GHOSTBUSTER</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/risi-full.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
<?php
require('config.php');
session_start();

if (isset($_POST['username'])){
	$username = stripslashes($_REQUEST['username']);
	$username = mysqli_real_escape_string($conn, $username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($conn, $password);
    $query = "SELECT * FROM `users` WHERE username='$username' and password='".hash('sha256', $password)."'";
	$result = mysqli_query($conn,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
	if($rows==1){
	    $_SESSION['username'] = $username;
	    header("Location: index.php");
	}else{
		$message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
	}
}
?>	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
        <?php
          require('config.php');
          if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])){
          	// r�cup�rer le nom d'utilisateur et supprimer les antislashes ajout�s par le formulaire
          	$username = stripslashes($_REQUEST['username']);
          	$username = mysqli_real_escape_string($conn, $username); 
          	// r�cup�rer l'email et supprimer les antislashes ajout�s par le formulaire
          	$email = stripslashes($_REQUEST['email']);
          	$email = mysqli_real_escape_string($conn, $email);
          	// r�cup�rer le mot de passe et supprimer les antislashes ajout�s par le formulaire
          	$password = stripslashes($_REQUEST['password']);
          	$password = mysqli_real_escape_string($conn, $password);
          	//requ�te SQL + mot de passe crypt�
              $query = "INSERT into `users` (username, email, password)
                        VALUES ('$username', '$email', '".hash('sha256', $password)."')";
          	// Ex�cute la requ�te sur la base de donn�es
              $res = mysqli_query($conn, $query);
              if($res){
                 echo "<div class='sucess'>
                       <h3>Signed in successfully </h3>
                       <p>Click here to connect <a href='login.php'>Sign in</a></p>
          			 </div>";
              }
          }else{
         ?>
				<form class="login100-form validate-form"  action="" method="post" name="login">
					<span class="login100-form-title p-b-33">
						GHOSTBUSTER
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>
                
          <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="email" name="email" placeholder="Email">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
           <input type="submit" value="Sign in " name="submit" class="login100-form-btn">
					</div>
      
				</form>
        <?php } ?>
			</div>
		</div>
	</div>
	

	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>