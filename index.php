<?php
//configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//make constants using define
define('clientID', 'fba0fe2c6a004fbbb3ee10418800abdd');
define('client_Secret', '7c5dfa3acec045a0b2accd52499f73a6');
define('redirectURI', 'http://localhost/apiproject/index.php');
define('ImageDirectory', 'pics/');

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<!-- creating a login for people to goand give aproval for our web app to access their instagram account
	after getting aproval, we are now going to ave the information so that we can play with it/
	 -->
	<a href="https:api.instagram/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">login</a>
</body>
</html>