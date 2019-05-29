<?php
include_once 'MinesweeperBoard';

class MinesweeperGame
{
    private $board;

    public function __construct()
    {
        $this->board = new MinesweeperBoard(9, 10);
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

?>