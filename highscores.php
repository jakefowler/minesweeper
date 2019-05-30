<!DOCTYPE html>
<html>
<head>
    <title>High Scores</title>
    <link rel="stylesheet" href="styles/styles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
    <body>
    <div class="container">
        <div class="title">
            <h1>High Scores</h1>
        </div>
        <?php
            session_start();
            // server side code
            $servername = "sql209.epizy.com";
            $username = "epiz_23954976";
            $password = "Eyq2IRSBT4Jrv";
            $dbname = "epiz_23954976_Minesweeper";
            $playerName = $_SESSION['username'];

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            //Check connnection
            if ($conn->connect_error)
            {
                die("Connection failed: " . $conn->connect_error);
            }
        ?>
        <div class="footer">
            <button onclick="window.location.href = 'index.html';">Home</button>
        </div>
    </div>
    </body>
</html>