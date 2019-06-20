<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require __DIR__.'/common.php';


function main() {
	$data = json_decode(file_get_contents("php://input"));
	$user = $data->username;
	$pass = $data->password;

	#$userh = bin2hex($user);
	#$passh = bin2hex($pass);

	$rawSalt = strongRandomBytes(16);
	$salt = bin2hex($rawSalt);

	$sql = "select username from user where username = '".$user."';";
	$data = download($sql);
	
	$rawHash = passwordHash($pass, $rawSalt);
	$hash = bin2hex($rawHash);
	
	$body = new stdClass;
	$body->type = "signup";
	$body->username = $user;
	$body->success = false;
	if (sizeof($data) == 0) {
		// create a new user
		$sql = "insert into user VALUES ('".$user."', '".$hash."', '".$salt."');";
		if (upload($sql)) {
			$body->success = true;
			session_start();
			$_SESSION['username'] = $user;
		}
	}
	$json->auth = $body;
	$jsonstr = json_encode($json);
	
	echo $jsonstr;
}

main();

?>
