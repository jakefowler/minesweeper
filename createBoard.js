function checkSquare(id)
{
    console.log(id);
    let tempId = id.toString();
    let location = tempId.split("_");
    console.log(location[0]);
    console.log(location[1]);
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
            btn.onclick = function() {checkSquare(this.id);};
            cell.appendChild(btn);
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
    document.getElementById("gameBoard").appendChild(table);
}
