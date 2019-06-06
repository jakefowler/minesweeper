<?php
    session_start();
    include "./models/MinesweeperGame.php";
    $boardSize = 9;
    $_SESSION['game'] = new MinesweeperGame($boardSize);
    header("Location: game.html");
    exit;