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

//function that connects to instagram
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array( 
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,
	));
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
//Function to get userID cause username doesnt allow us to get pictures!
function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q'.$userName.'&client_id='.clientID;
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);

	echo $results['data'][0]['id'];
}
//funcltion to print out images onto our screen
function printImages($userID){
	$url = 'https://api.instagram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=S';
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//parse through the information one by one.
	foreach($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url']; //going to go through all of my results and give myself back the URL of those pictures
		//because we went to save it in the PHP sever. 
		echo '<img src=" '.$image_url.'"/><br/>';
        //calling a function to save that $image_url
        savePictures($image_url)

	}
}
//dunction to save image to server
function savePictures($image_url){
	echo $image_url.'<br>'; 
	$filename = $basename($image_url); // the filename is what we are storing. basename is the PHP built in method that we are using to store $image_url
	echo $filename . '<br>';

	$destination = imageDirectory . $filename; //we are making sure that the image doesn't exist in the storage
	file_put_contents($destination, file_get_contents($image_url)); //goes and grabs as imagefile and stores it into our server
}


if (isset($_GET['code'])){
	$code = $_GET['code'];
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

$results = json_decode($result, true);

$userName = $results['user']['username'];

$userID = getUserID($userName);

printImages($userID);
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
	<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID;?>&redirect_uri=<?php echo redirectURI;?>&response_type=code">login</a>
<script type="text/javascript"></script>
</body>
</html>
<?php
}
?>
