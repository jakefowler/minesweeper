<?php
include_once '../models/MinesweeperGame.php';
include_once '../controllers/DBController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

session_start();

$gameWon = $_SESSION['game']->gameWon();

if ($gameWon) {
    DBController::saveGame($_SESSION['game'], $_SESSION['username']);
}

echo $gameWon;
