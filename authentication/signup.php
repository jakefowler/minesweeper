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
	
	echo "salt: ".$salt."<br>\n";

	$sql = "select username from user where username = '".$user."';";
	download($sql);
	
	/*
	if (sizeof($data) == 0) {
		// create a new user
	} else {
		// report that the username has already been taken
	}
	*/
}


main();

?>
