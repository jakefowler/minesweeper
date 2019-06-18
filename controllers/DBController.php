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
            self::$dbconn = new PDO('mysql:host=localhost;dbname=se2', "student", "weber");
            self::$initialized = true;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function saveGame(MinesweeperGame $game, $username)
    {
        self::initialize();
        if ($game->gameWon()) {
            $score = $game->getScore();

            $stmt = self::$dbconn->prepare("INSERT INTO `scores` (`username`, `score`) VALUES (?, ?)");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $score);

            $stmt->execute();

            if (!$stmt) {
                echo "\nPDO::errorInfo():\n";
                print_r(self::$dbconn->errorInfo());
            }
        }
    }

    public static function getHighScores($limit)
    {
        self::initialize();
         $stmt = self::$dbconn->prepare("SELECT id, username, score, date_played, 1+(SELECT count(*) from scores a WHERE a.Score < b.Score) as RANK FROM `scores` b ORDER BY `score` LIMIT ".$limit);

         $stmt->execute();

         return $stmt->fetchAll();
    }

    /*public static function getGameRank(MinesweeperGame $game)
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
    }*/

    public static function authenticate($username, $hash)
    {
        self::initialize();
    }

}