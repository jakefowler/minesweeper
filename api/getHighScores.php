<?php
include_once '../controllers/DBController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();

$data = json_decode(file_get_contents("php://input"));

echo json_encode(DBController::getHighScores($data->limit));