var gameBoard = [];
var startTime;
var intervalId;
var started = false;
var serverTime;

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


function changeSquare(squareValue, button) {
    if (squareValue) {
        document.getElementById(button.id).style.color = "white";
        document.getElementById(button.id).innerText = squareValue;
    }
    else {
        document.getElementById(button.id).style.backgroundColor = "darkred";
        disableButtons();
    }
}

async function requestSquareValue(id)
{
    let location = id.split("_");
    let xLoc = location[0];
    let yLoc = location[1];
    var squareValue = "";

    squareValue = await request({url: '/api/checkSquare.php',
            method: 'POST', 
            body: JSON.stringify({x: xLoc, y: yLoc})});
    return squareValue;
}

function checkSquare(event, button)
{
    if (!started){
        started = true;
        startInterval();
    }
    event = event || window.event;
    event.preventDefault();
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

function createBoard(size)
{
    console.log(size);
    var table = document.createElement("table");
    for(i = 0; i < size; i++)
    {
        gameBoard.push([]);
        var row = document.createElement('tr');
        for(j = 0; j < size; j++)
        {
            var cell = document.createElement('td');
            var btn = document.createElement("button");
            btn.id = (i + "_" + j);
            btn.addEventListener("click", function() {checkSquare(event, this);}, false);
            btn.addEventListener("contextmenu", function() {checkSquare(event, this);}, false);
            gameBoard[i].push(btn);
            cell.appendChild(btn);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    document.getElementById("gameBoard").appendChild(table);
}

function startTimer()
{
    let now = new Date().getTime();
    if (!startTime){
        startTime = new Date().getTime();
    }
    let deltaTime = now - startTime;
    let seconds = Math.floor(deltaTime / 1000);

    document.getElementById("timer").innerHTML = "Timer: " + seconds;
}

function startInterval()
{
    intervalId = setInterval(startTimer, 100);

    // request({url: '/api/.php',
    //         method: 'POST', 
    //         body: JSON.stringify({})});
}

function disableButtons()
{
    clearInterval(intervalId);
    gameBoard.forEach(list => list.forEach(button => button.disabled = true));
}

function close()
{
    request({url: '/api/pauseGame.php',
            method: 'POST', 
            body: JSON.stringify({pause: true})});
}

