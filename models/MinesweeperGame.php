<?php
include_once "MinesweeperBoard.php";

class MinesweeperGame
{
    private $board;
    private $moves;
    private $gameLost;
    private $timeElapsed;
    private $paused;
    private $timeUnpaused;

    public function __construct(int $size)
    {
        $this->board = new MinesweeperBoard($size, $size + 1);
        $this->moves = [];
        $this->gameLost = false;
        $this->timeElapsed = 0;
        $this->paused = false;
        $this->timeUnpaused = time();
    }

    public function checkSquare(int $x, int $y)
    {
        $result = $this->board->getSquare($x, $y);

        $this->moves[] = [$x, $y];
        $this->moves = array_unique($this->moves);

        if ($result < 0) {
            $this->gameLost = true;
            return false;
        } else {
            return $result;
        }
    }

    public function pause()
    {
        if (!$this->paused) {
            $this->paused = true;
            $this->timeElapsed = $this->timeElapsed + (time() - $this->timeUnpaused);
        }
    }

    public function unpause()
    {
        if ($this->paused) {
            $this->paused = false;
            $this->timeUnpaused = time();
        }
    }

    public function gameWon()
    {
        $boardSize = $this->board->size();
        $minMovesToWin = ($boardSize * $boardSize) - ($boardSize + 1);

        return !$this->gameLost && count($this->moves) >= $minMovesToWin;
    }

    public function getScore()
    {
        if ($this->paused) {
            return $this->timeElapsed;
        } else {
            return $this->timeElapsed + (time() - $this->timeUnpaused);
        }
    }
}
