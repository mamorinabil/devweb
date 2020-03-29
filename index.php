<?php
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'dbrootghost');
  define('DB_PASSWORD', 'zuuNW6G64@~*+');
  define('DB_NAME', 'forumDb');
	$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	if ($mysqli->connect_errno) {
		  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
		  exit();
	}
	
		if (isset($_POST['submit'])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
      
        // Check if file already exists
      if (file_exists($target_file)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
      }
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
              $img= 'uploads/'.basename( $_FILES["fileToUpload"]["name"]);
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
			if (!empty($_server['http_client_ip'])) {
				 $ip = $_server['http_client_ip'];
			} elseif (!empty($_server['http_x_forwarded_for'])) {
				 $ip = $_server['http_x_forwarded_for'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
		    }
			$user=$mysqli->real_escape_string($_POST['user']);
			$message=$mysqli->real_escape_string($_POST['message']);
			$date=date('Y-m-d H:i:s');
		   
			$sql="INSERT INTO forum(id, user, message, date, ip,images) VALUES(0,'$user','$message','$date','$ip','$img')";
			$mysqli->query($sql);
		}
?>

<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {


    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LeV0-QUAAAAAEEUF0gPgWNM2p3NCDPPN0HGp6NC';
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    // Take action based on the score returned:
    if ($recaptcha->score >= 0.5) {
	
    } else {
		header("Location: http://google.com");
    }


} ?>

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
<script src="https://www.google.com/recaptcha/api.js?render=6LeV0-QUAAAAAKVtx9TqVIn-i2s4j5794YAXDPFc"></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LeV0-QUAAAAAKVtx9TqVIn-i2s4j5794YAXDPFc', {action: 'MyForm'}).then(function(token) {
	console.log(token)
    document.getElementById('recaptchaResponse').value = token;
    });
});
</script>
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
      <a href="login.php"> Flag </a> <br /><br />
     	<form enctype="multipart/form-data" class="login100-form validate-form" method="Post" action="index.php">
 		      <input type="hidden" name="recaptchaResponse" id="recaptchaResponse"> 
     	    <div class="wrap-input100 validate-input">
      		  <input class="input100" type="text" name="user" id="user" placeholder="User" />
  			    <span class="focus-input100-1"></span>
   				  <span class="focus-input100-2"></span>
          </div>
  		   <br /><br />
  		   <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
	          <textarea class="input100" name="message" id="message" cols="45" rows="5" placeholder="Message"></textarea>
            <span class="focus-input100-1"></span>
            <span class="focus-input100-2"></span>
  		   </div> <br /><br />
         Select image to upload: <br /><br />
         <div class="wrap-input100 rs1 validate-input" data-validate="Password is required">
           <input type="file" name="fileToUpload" id="fileToUpload">
           <span class="focus-input100-1"></span>
 				   <span class="focus-input100-2"></span>
  		   </div> <br /><br />
  		   <div class="container-login100-form-btn m-t-20">	
     		   <input class="login100-form-btn" type="submit" name="submit" id="submit" value="Post message" />
  			</div>
		</form>
		<br /><br />
		  <span class="login100-form-title p-b-33">
		   FORUM
		  </span>
			<h2></h2>

        <?php
        	$sql = "SELECT * FROM forum ORDER BY id DESC";
        	$result = $mysqli->query($sql);
        
        	while($row = $result->fetch_assoc()) {
        	  echo $row['user'].',  '.$row['date'].',  '.$row['ip'].','."<img src=".$row['images'].">" .', <br />';
        	  echo $row['message'].'<br />';
        	  echo '------------------------ <br />';
        
        }
        ?>
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
