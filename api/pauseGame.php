<?php
include_once '../models/MinesweeperGame.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();

$data = json_decode(file_get_contents("php://input"));

if ($data->pause) {
    $_SESSION['game']->pause();
} else {
    $_SESSION['game']->unpause();
}

//echo $_SESSION['game']->checkSquare($data->x,$data->y);