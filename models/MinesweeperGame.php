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

        error_log("Board size is {$this->board->size()}");
    }

    public function checkSquare(int $x, int $y)
    {
        $result = $this->board->getSquare($x, $y);

        error_log("Checking x={$x}, y={$y} = {$result}");
        
        $addMove = true;

        foreach ($this->moves as $move) {
            if ($x == $move['x'] && $y == $move['y']) {
                $addMove = false;
                //return array($move);
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
            error_log("Result is 0");
            $toreturn = array(array('x' => $x, 'y' => $y, 'result' => $result));

            if ($x > 0) {

                if (!$this->board->seen($x - 1, $y)) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($x - 1, $y));
                }

                if ($y > 0 && !$this->board->seen($x - 1, $y - 1)) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($x - 1, $y - 1));
                }

                if ($y < $this->board->size() - 1 && !$this->board->seen($x - 1, $y + 1)) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($x - 1, $y + 1));
                }

                error_log(implode(" ",$toreturn));
            }

            if ($x < $this->board->size() - 1) {

                if (!$this->board->seen($x + 1, $y)) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($x + 1, $y));
                }

                if ($y > 0 && !$this->board->seen($x + 1, $y - 1)) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($x + 1, $y - 1));
                }

                if ($y < $this->board->size() - 1 && !$this->board->seen($x + 1, $y + 1)) {
                    $toreturn = array_merge($toreturn, $this->checkSquare($x + 1, $y + 1));
                }

                error_log(implode(" ",$toreturn));
            }

            if ($y > 0 && !$this->board->seen($x, $y - 1)) {
                $toreturn = array_merge($toreturn, $this->checkSquare($x, $y - 1));
            }

            if ($y < $this->board->size() - 1 && !$this->board->seen($x, $y + 1)) {
                $toreturn = array_merge($toreturn, $this->checkSquare($x, $y + 1));
            }

            return $toreturn;
        } else {
            return array(array('x' => $x, 'y' => $y, 'result' => $result));
        }
        //}
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
