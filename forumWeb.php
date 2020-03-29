

<?php

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
		   
			$sql="INSERT INTO forum(id, user, message, date, ip) VALUES(0,'$user','$message','$date','$ip')";
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

<!doctype html>
<html lang="fr">
<a href="logout.php"> Logout </a>
<head>
<script src="https://www.google.com/recaptcha/api.js?render=6LeV0-QUAAAAAKVtx9TqVIn-i2s4j5794YAXDPFc"></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LeV0-QUAAAAAKVtx9TqVIn-i2s4j5794YAXDPFc', {action: 'MyForm'}).then(function(token) {
	console.log(token)
    document.getElementById('recaptchaResponse').value = token;
    });
});
</script>
  <meta charset="utf-8">
  <title>Titre de la page</title>
  <link rel="stylesheet" href="style.css">
	<form method="Post" action="forum.php">
		<input type="hidden" name="recaptchaResponse" id="recaptchaResponse">
		<p>User:
		  <label for="user"></label>
		  <input type="text" name="user" id="user" />
		  <br />
		</p>
		<p>Message: <br />
		  <label for="message"></label>
		  <textarea name="message" id="message" cols="45" rows="5"></textarea>
		</p>
		<p>
		  <input type="submit" name="submit" id="submit" value="Post message" />
		</p>
			
	</form>

</head>
<body>
<h2>FORUM</h2>

<?php
	$sql = "SELECT * FROM forum";
	$result = $mysqli->query($sql);

	while($row = $result->fetch_assoc()) {
	  echo $row['user'].',  '.$row['date'].',  '.$row['ip'].', <br />';
	  echo $row['message'].'<br />';
	  echo '------------------------ <br />';

}
?>
</body>
</html>

