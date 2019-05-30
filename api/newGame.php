<?php
include_once '../models/MinesweeperGame.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();

$data = json_decode(file_get_contents("php://input"));

print_r($data);

$_SESSION['game'] = new MinesweeperGame($data->size);

echo $_SESSION['game']->checkSquare(0,0);