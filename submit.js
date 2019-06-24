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

function checkLogin(response)
{
    console.log(response);
    if(response['auth']['type'] == "signup")
    {
        if(response['auth']['success'])
        {
            window.location.assign("createGame.php");
        }
        else
        {
            document.getElementById("newUserStatus").innerHTML = "Your username or password is invalid";
        }
    }
    if(response['auth']['type'] == "login")
    {
        if(response['auth']['success'])
        {
            window.location.assign("createGame.php");
        }
        else
        {
            document.getElementById("existingUserStatus").innerHTML = "Your username or password was incorrect";
        }
    }  
}

function submit(user, pass, sendLocation)
{
    let hash = sha256.create();
    hash.update(pass);
    pass = hash.hex();
    request({url: sendLocation, method: 'POST', body: JSON.stringify({username: user, password: pass})}).then(response => checkLogin(JSON.parse(response)));
}

function existingUser()
{
    document.getElementById("existingUserStatus").innerHTML = "";
    let username = document.getElementById("existingUsername").value;
    let password = document.getElementById("existingPassword").value;
    submit(username, password, 'authentication/login.php');
}

function newUser()
{
    document.getElementById("newUserStatus").innerHTML = "";
    let username = document.getElementById("newUsername").value;
    let password = document.getElementById("newUserPassword").value;
    submit(username, password, 'authentication/signup.php');
}

function enterEventHandler(event)
{
    if (event && event.keyCode == 13)
    {
        event.preventDefault();
        if (event.target.id == "newUsername" || event.target.id == "newUserPassword")
        {
            document.getElementById("newUserBtn").click();
        }
        if (event.target.id == "existingUsername" || event.target.id == "existingPassword")
        {
            document.getElementById("existingUserBtn").click();
        }
    }
}

function addEnterEvent()
{
    document.getElementById("newUsername").addEventListener("keyup", enterEventHandler, false);
    document.getElementById("newUserPassword").addEventListener("keyup", enterEventHandler, false);
    document.getElementById("existingUsername").addEventListener("keyup", enterEventHandler, false);
    document.getElementById("existingPassword").addEventListener("keyup", enterEventHandler, false);
}


