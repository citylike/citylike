<!DOCTYPE html>
<html>
<head></head>
<body>
<a href="https://api.instagram.com/oauth/authorize/?client_id=1658ab65bb8b480a869d1be346857070&amp;redirect_uri=http://city-like.ru&amp;response_type=code">Sign In with Instagram</a>


<?php 
	// if the code parameter has been sent, we retrieve the access_token
	if($_GET['code']) {
		$code = $_GET['code'];
		$url = "https://api.instagram.com/oauth/access_token";
		$access_token_parameters = array(
		        'client_id'                =>     '1658ab65bb8b480a869d1be346857070',
		        'client_secret'            =>     'd90e5c3697b442aba27601e09594b181',
		        'grant_type'               =>     'authorization_code',
		        'redirect_uri'             =>     'http://city-like.ru',
		        'code'                     =>     $code
		);
		$curl = curl_init($url);    // we init curl by passing the url
		curl_setopt($curl,CURLOPT_POST,true);   // to send a POST request
		curl_setopt($curl,CURLOPT_POSTFIELDS,$access_token_parameters);   // indicate the data to send
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);   // to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   // to stop cURL from verifying the peer's certificate.
		$result = curl_exec($curl);   // to perform the curl session
		curl_close($curl);   // to close the curl session

		$arr = json_decode($result,true);

		var_dump($arr);
	}
?>

<a href="https://api.instagram.com/v1/users/3/media/recent/?access_token=982695347.1658ab6.cb6606a73f6a4a899840f99ca6116c4b&count=10">photos</a>

</body>

</html>
