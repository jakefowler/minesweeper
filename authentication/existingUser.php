<?php
session_start();
$_SESSION['username'] = filter_var($_POST[username], FILTER_SANITIZE_STRING);
header("Location: ../game.php");
exit;