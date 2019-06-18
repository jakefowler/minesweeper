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

function upload($query) {
	global $servername, $username, $password, $dbname;

	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = $query;
		$conn->exec($sql);
    } catch(PDOException $e) {
	    echo $sql . "<br>" . $e->getMessage();
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


?>
