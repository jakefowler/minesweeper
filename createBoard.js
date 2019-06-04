function checkSquare(button)
{
    console.log(button.id);
    let tempId = button.id.toString();
    let location = tempId.split("_");
    let xLoc = location[0];
    let yLoc = location[1];
    console.log(xLoc);
    console.log(yLoc);

    let request = obj => {
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

    request({url: '/api/checkSquare.php',
            method: 'POST', 
            body: JSON.stringify({x: xLoc, y: yLoc})}).then((request) => {
                if (request) {
                    document.getElementById(button.id).innerText = request;
                }
                else {
                    document.getElementById(button.id).style.backgroundColor = "darkred";
                }
            });
}

function createBoard(size)
{
    console.log(size);
    var table = document.createElement("table");
    var gameBoard = [size][size];
    for(i = 0; i < size; i++)
    {
        var row = document.createElement('tr');
        for(j = 0; j < size; j++)
        {
            var cell = document.createElement('td');
            var btn = document.createElement("button");
            btn.id = (i + "_" + j);
            btn.onclick = function() {checkSquare(this);};
            cell.appendChild(btn);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    document.getElementById("gameBoard").appendChild(table);
}