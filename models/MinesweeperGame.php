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
        $this->paused = true;
        $this->timeUnpaused = time();
    }

    public function checkSquare(int $x, int $y)
    {
        $result = $this->board->getSquare($x, $y);
        
        $addMove = true;

        foreach ($this->moves as $move) {
            if ($x == $move['x'] && $y == $move['y']) {
                $addMove = false;
                break;
            }
        }

        if ($addMove) {
            $this->moves[] = array('x' => $x, 'y' => $y, 'result' => $result);
        }    

        if ($result < 0) {
            $this->gameLost = true;
            return array(array('x' => $x, 'y' => $y, 'result' => false));
        } elseif ($result == 0) {
            $toreturn = array(array('x' => $x, 'y' => $y, 'result' => $result));

            $toCheck = array(
                ['x' => $x + 1, 'y' => $y + 1],
                ['x' => $x + 1, 'y' => $y],
                ['x' => $x + 1, 'y' => $y - 1],
                ['x' => $x, 'y' => $y + 1],
                ['x' => $x, 'y' => $y - 1],
                ['x' => $x - 1, 'y' => $y + 1],
                ['x' => $x - 1, 'y' => $y],
                ['x' => $x - 1, 'y' => $y - 1],
            );

            $boardSize = $this->board->size();

            $filterInvalidCoordinates = function($coordinates) use ($boardSize) {
                return $coordinates['x'] >= 0 && $coordinates['y'] >= 0 && $coordinates['x'] < $boardSize && $coordinates['y'] < $boardSize;
            };

            $toCheck = array_filter($toCheck, $filterInvalidCoordinates);

            foreach ($toCheck as $coordinate) {
                if (!$this->board->seen($coordinate['x'], $coordinate['y'])) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($coordinate['x'], $coordinate['y']));
                }
            }

            return $toreturn;
        } else {
            return array(array('x' => $x, 'y' => $y, 'result' => $result));
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

    public function getMadeMoves()
    {
        return $this->moves;
    }
}
