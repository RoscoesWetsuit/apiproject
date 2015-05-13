<?php
//configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//make constants using define
define('clientID', 'fba0fe2c6a004fbbb3ee10418800abdd');
define('clientSecret', '7c5dfa3acec045a0b2accd52499f73a6');
define('redirectURI', 'http://localhost/apiproject/index.php');
define('ImageDirectory', 'pics/');

if (isset($_GET['code'])){
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('cliend_id' => clientID,
									'client_secret' => clientSecret,
									'grant_type' => 'authorization_code',
									'redirect_uri' => redirectURI,
									'code' => $code
									);
//CURL is what we use in PHP, It's a library that calls to other API's
$curl = curl_init($url); //setting a curl session and we put in $curl because that's where we are getting the data from
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings); //setting the POSTFIELDS to the array setup that we created
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //setting it to eaual to 1 because we are getting strings back.
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true); //but in live work-production we want to set this to true

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($results, true);
echo $results['user']['username'];
}
else{
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<!-- creating a login for people to goand give aproval for our web app to access their instagram account
	after getting aproval, we are now going to ave the information so that we can play with it.
	 -->
	<a href="https:api.instagram.com/oauth/authorize/?client_id=<?php echo clientID;?>&redirect_uri=<?php echo redirectURI;?>&response_type=code">login</a>
<script type="text/javascript"></script>
</body>
</html>
<?php
}
?>
