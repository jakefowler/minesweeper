<?php
    include "./models/MinesweeperGame.php";
    $boardSize = 9;
    $game = new MinesweeperGame($boardSize);
    header("Location: game.html");
    exit;
?>