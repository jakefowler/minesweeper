<?php

require __DIR__.'/common.php';


function main() {
	$user = $_POST["username"];
	$pass = $_POST["password"];


	$userh = bin2hex($user);
	$passh = bin2hex($pass);

	#echo "user: ".$userh."<br>\n";
	#echo "pass: ".$passh."<br>\n";
	#echo hex2bin($userh)."<br>\n";

	$rawSalt = strongRandomBytes(16); // 128 bits read from /dev/random
	$salt = bin2hex($rawSalt);
	#$salt = "3bea8f25027406f267b0fdcc9828331f";
	#$rawSalt = hex2bin($salt);

	$sql = "select username from user where username = '".$user."';";
	download($sql);
	
	$algo = "sha256";
	$iterations = 1024;
	$length = 32;
	$raw_output = true;
	$rawHash = passwordHash($pass, $rawSalt);
	$hash = bin2hex($rawHash);
	
	echo "password: ".$hash." salt: ".$salt."<br>\n";
	
	
	if (sizeof($data) == 0) {
		// create a new user
		$sql = "insert into user VALUES ('".$user."', '".$hash."', '".$salt."');";
		upload($sql);
		echo "Your account has been successfully created :D<br>\n";
	} else {
		// report that the username has already been taken
		echo "That username has already been taken :(<br>\n";
	}
}


main();

?>
