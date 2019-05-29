<!DOCTYPE html>
<html>
<head>
    <title>Minesweeper</title>
    <link rel="stylesheet" href="styles/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <body>
        <div class="container">
            <h1 class="title">Minesweeper</h1>
            <div class="gameBoard">
                <?php
                include 'models/MinesweeperGame.php';
                $boardSize = 9;
                $game = new MinesweeperGame($boardSize);

                echo "<table>";
                for($i = 0; $i < $boardSize; $i++)
                {
                    echo "<tr>";
                    for($j = 0; $j < $boardSize; $j++)
                    {
                        echo "<td><button>" . $game->checkSquare($j, $i) . "</button></td>"; 
                    }
                    echo "</tr>";
                }

                echo "</table>";
                ?>
            </div>
            <div class="footer">
                <button onclick="window.location.href = 'highscores.php';">View High Scores</button>
            </div>
        </div>
    </body>
</html>