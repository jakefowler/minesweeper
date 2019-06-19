<?php
$servername = "localhost";
$username = "student";
$password = "weber";
$dbname = "se2";

function download($query) {
	global $servername, $username, $password, $dbname;

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
		$data = $stmt->fetchAll();
		
		return $data;
	} catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	} finally {
		$conn = null;
	}
}

function upload($query, $debug = false) {
	global $servername, $username, $password, $dbname;

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $query;
		$conn->exec($sql);
		return true;
    } catch(PDOException $e) {
	    if ($debug) {
	    	echo $sql . "<br>" . $e->getMessage();
	    }
	    return false;
    } finally {
    	$conn = null;
    }
}

function strongRandomBytes($byteCount) {
	## https://stackoverflow.com/questions/637278/what-is-the-best-way-to-generate-a-random-key-within-php
    $fp = @fopen('/dev/urandom','rb');
    if ($fp !== FALSE) {
    	$raw = @fread($fp,$byteCount);
        //$key = bin2hex($raw);
        $key = $raw;
        @fclose($fp);
        return $key;
    }
    return null;
}

function passwordHash($password, $rawSalt) {
	// salt must be raw bytes and the returned derived key is raw bytes
	$rawDK = hash_pbkdf2("sha256", $password, $rawSalt, 1024, 32, true);
	return $rawDK;
}


?>
