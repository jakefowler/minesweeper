<?php
include_once "../models/MinesweeperGame.php";

class DBController
{
    private static $dbconn;
    private static $initialized = false;

    private static function initialize()
    {
        if (self::$initialized)
            return;

        try {
            self::$dbconn = new PDO('mysql:host=< INSERT HOST >;dbname=< INSERT DB >', "< INSERT USER NAME >", "< INSERT PASSOWORD >");
            self::$initialized = true;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function saveGame(MinesweeperGame $game)
    {
        self::initialize();
        // if ($game->gameWon()) {
        //     $name = $gameController->getName();
        //     $score = $gameController->getGuesses();

        //     $stmt = self::$dbconn->prepare("INSERT INTO `scores` (`NAME`, `SCORE`) VALUES (?, ?)");
        //     $stmt->bindParam(1, $name);
        //     $stmt->bindParam(2, $score);

        //     $stmt->execute();

        //     $stmt = self::$dbconn->prepare("SELECT MAX(ID) FROM scores");
        //     $stmt->execute();

        //     $gameController->setID($stmt->fetchColumn());
        // }
    }

    public static function getHighScores($limit)
    {
        self::initialize();
        // $stmt = self::$dbconn->prepare("SELECT ID, NAME, SCORE, DATE, 1+(SELECT count(*) from scores a WHERE a.Score < b.Score) as RANK FROM `scores` b ORDER BY `SCORE` LIMIT ".$limit);

        // $stmt->execute();

        // return $stmt->fetchAll();
    }

    public static function getGameRank(MinesweeperGame $game)
    {
        self::initialize();
        // if (!is_null($game->getID())) {
        //     $stmt = self::$dbconn->prepare("SELECT 1+(SELECT count(*) from scores a WHERE a.Score < b.Score) as GameRank FROM scores b WHERE id = ?");
        //     $stmt->bindParam(1, $game->getID());

        //     $stmt->execute();

        //     return $stmt->fetchColumn();
        // }
    }

    public static function getMaxRank()
    {
        self::initialize();
        // $stmt = self::$dbconn->prepare("SELECT MAX(1+(SELECT count(*) from scores a WHERE a.Score < b.Score)) as MaxRank FROM scores b");

        // $stmt->execute();

        // return $stmt->fetchColumn();
    }

    public static function authenticate($username, $hash)
    {
        self::initialize();
    }

}