<?php
#session_start();
#$_SESSION['username'] = filter_var($_POST[username], FILTER_SANITIZE_STRING);
#header("Location: ../createGame.php");
#exit;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require 'common.php';



function goodLogin($username) {
	$_SESSION['username'] = $username;
	$body = new stdClass;
	$body->type = "login";
	$body->success = true;
	$body->username = $username;
	$json->auth = $body;
	echo json_encode($json);
}

function badLogin($username) {
	$body = new stdClass;
	$body->type = "login";
	$body->success = false;
	$body->username = $username;
	$json->auth = $body;
	echo json_encode($json);
}

function main() {
	session_start();
	$data = json_decode(file_get_contents("php://input"));
	$user = filter_var($data->username, FILTER_SANITIZE_STRING);
	$pass = filter_var($data->password, FILTER_SANITIZE_STRING);

	#echo "username: ".$user."</br>\n";
	#echo "password: ".$pass."</br>\n";

	$qry = "SELECT salt FROM user WHERE username = '".$user."';";
	#echo $qry."<br/>\n";
	$data = download($qry);
	$salt = $data[0]['salt'];
	$rawSalt = hex2bin($salt);
	#echo "salt: ".json_encode($data[0]['salt'])."<br/>";
	
	#echo "salt: ".$salt."</br>\n";
	
	$rawHash = passwordHash($pass, $rawSalt);
	$hash = bin2hex($rawHash);
	#echo "hash: ".$hash."</br>\n";

	$qry = "SELECT * FROM user WHERE username = '".$user."' AND password = '".$hash."';";
	#echo $qry."<br/>\n";
	$data = download($qry);
	if (sizeof($data) == 1) {
		goodLogin($user);
	} else {
		badLogin($user);
	}
}

main()
?>

