<?php
include_once "MinesweeperBoard.php";

class MinesweeperGame
{
    private $board;

    public function __construct(int $size)
    {
        $this->board = new MinesweeperBoard($size, 10);
    }

    public function checkSquare(int $x, int $y)
    {
        $result = $this->board->getSquare($x, $y);

        if ($result < 0) {
            return false;
        } else {
            return $result;
        }
    }
}