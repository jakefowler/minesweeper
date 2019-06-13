var game;

function Game(size)
{
    this.size = size;
    this.numBombs = size + 1;
    this.numMoves = 0;
    this.started = false;
    this.serverTime = 0;
    this.board = [];
    this.startTime;
    this.intervalId;
    this.movesToWin = size * size - this.numBombs;
}

var request = obj => {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();
        xhr.open(obj.method || "GET", obj.url);
        if (obj.headers) {
            Object.keys(obj.headers).forEach(key => {
                xhr.setRequestHeader(key, obj.headers[key]);
            });
        }
        xhr.onload = () => {
            if (xhr.status >= 200 && xhr.status < 300) {
                resolve(xhr.response);
            } else {
                reject(xhr.statusText);
            }
        };
        xhr.onerror = () => reject(xhr.statusText);
        xhr.send(obj.body);
    });
};

function getCoordinatesForId(id)
{
    let location = id.split("_");
    let xLoc = location[0];
    let yLoc = location[1];
    return {x: parseInt(xLoc), y: parseInt(yLoc)};
}

async function requestSquareValue(id)
{
    loc = getCoordinatesForId(id);
    return await request({url: 'api/checkSquare.php',
            method: 'POST', 
            body: JSON.stringify({x: loc.x, y: loc.y})});
}

function checkSquare(event, button)
{
    if (!game.started){
        game.started = true;
        startInterval();
    }
    event = event || window.event;
    event.preventDefault();
    if (button.innerText != "" && button.innerText != "F")
    {
        return
    }
    if (event.button == 2)
    {
        if (document.getElementById(button.id).innerText == 'F')
        {
            document.getElementById(button.id).innerText = '';
            document.getElementById(button.id).style.color = "white";
        }
        else if (document.getElementById(button.id).innerText == '')
        {
            document.getElementById(button.id).innerText = 'F';
            document.getElementById(button.id).style.color = "darkred";
        }
    }
    else
    {
        requestSquareValue(button.id.toString()).then(response => changeSquare(response, button));
    }
}

function addMadeMoves(moves)
{
    moves.forEach(move => game.board[move[0]][move[1]].click());
}

function createBoard(size)
{
    game = new Game(size);
    console.log(size);
    var table = document.createElement("table");
    for(i = 0; i < size; i++)
    {
        game.board.push([]);
        var row = document.createElement('tr');
        for(j = 0; j < size; j++)
        {
            var cell = document.createElement('td');
            var btn = document.createElement("button");
            btn.id = (i + "_" + j);
            btn.addEventListener("click", function() {checkSquare(event, this);}, false);
            btn.addEventListener("contextmenu", function() {checkSquare(event, this);}, false);
            game.board[i].push(btn);
            cell.appendChild(btn);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    document.getElementById("gameBoard").appendChild(table);
    request({url: 'api/getTime.php',
                method: 'GET'}).then(response => game.serverTime = response);
    request({url: 'api/getMadeMoves.php',
                method: 'GET'}).then(response => addMadeMoves(JSON.parse(response)));
}

function startTimer()
{
    let now = new Date().getTime();
    if (!game.startTime){
        game.startTime = new Date().getTime();
    }
    let deltaTime = now - game.startTime;
    let seconds = Math.floor(deltaTime / 1000);

    document.getElementById("timer").innerHTML = "Timer: " + (seconds + parseInt(game.serverTime));
}

function startInterval()
{
    game.intervalId = setInterval(startTimer, 100);
}

function disableButtons()
{
    clearInterval(game.intervalId);
    game.board.forEach(list => list.forEach(button => button.disabled = true));
}

function close()
{
    request({url: 'api/pauseGame.php',
            method: 'POST', 
            body: JSON.stringify({pause: true})});
}

function gameWon()
{
    disableButtons();
    close();
    console.log("You Won!!");
}

function changeSquare(squareValue, button) {
    if (squareValue) {
        if (button.innerText == "" || button.innerText == "F") 
        {
            game.numMoves++;
            document.getElementById(button.id).style.color = "white";
            document.getElementById(button.id).innerText = squareValue;
            if (squareValue == 0)
            {
                let loc = getCoordinatesForId(button.id);
                if (loc.x > 0)
                {
                    game.board[loc.x - 1][loc.y].click();
                    if (loc.y > 0)
                    {
                        game.board[loc.x - 1][loc.y - 1].click();
                    }
                    if (loc.y < game.board.length - 1)
                    {
                        game.board[loc.x - 1][loc.y + 1].click();
                    }
                }
                if (loc.x < game.board.length - 1)
                {
                    game.board[loc.x + 1][loc.y].click();
                    if (loc.y > 0)
                    {
                        game.board[loc.x + 1][loc.y - 1].click();
                    }
                    if (loc.y < game.board.length - 1)
                    {
                        game.board[loc.x + 1][loc.y + 1].click();
                    }
                }
                if (loc.y > 0)
                {
                    game.board[loc.x][loc.y - 1].click();
                }
                if (loc.y < game.board.length - 1)
                {
                    game.board[loc.x][loc.y + 1].click();
                }
            }
            if (game.numMoves >= game.movesToWin)
            {
                gameWon();
            }
        }
    }
    else {
        document.getElementById(button.id).style.backgroundColor = "darkred";
        disableButtons();
    }
}
