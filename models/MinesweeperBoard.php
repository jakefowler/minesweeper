<?php
class MinesweeperBoard {

    private $board;
    private $seen;
    private $size;

    function __construct(int $size, int $numMines) 
    {
        $this->board = array_fill(0, $size, array_fill(0, $size, 0));
        $this->seen = array_fill(0, $size, array_fill(0, $size, false));
        $this->size = $size;

        //Generate the board, algorithm from https://stackoverflow.com/questions/3578456/whats-the-algorithm-behind-minesweeper-generation
        for ($i=0; $i < $numMines; $i++) {
            do {
                $mine_x = rand(0, ($size - 1));
                $mine_y = rand(0, ($size - 1));
            } while ($this->board[$mine_x][$mine_y] < 0);
            for ($x=-1; $x <= 1; $x++) { 
                for ($y=-1; $y <= 1; $y++) { 
                    if ($x == 0 && $y == 0) {
                        $this->board[$mine_x][$mine_y] = -$numMines;
                    } else {
                        $this->board[$mine_x + $x][$mine_y + $y] += 1;
                    }
                }
            }
        }
    }

    public function getSquare(int $x, int $y)
    {
        $this->seen[$x][$y] = true;
        return $this->board[$x][$y];
    }

    public function size()
    {
        return $this->size;
    }

    public function seen(int $x, int $y)
    {
        return $this->seen[$x][$y];
    }
}
