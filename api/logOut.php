<?php
include_once '../models/MinesweeperGame.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();

session_destroy();

echo "Logged out";