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
?>
