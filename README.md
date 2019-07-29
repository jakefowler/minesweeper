# Minesweeper

Hosted at https://www.ezekielnewren.com/minesweeper/

![Minesweeper](/screenshots/minesweeper.PNG)

The site needs the following requirements:

A user login system
* An option to register a new user
** username
** password
*** Warn the user if the username already exists
* A separate option to login with existing credentials (username/password)
** If the login failed, inform the user, and let the user try again

* Password should be salted, then the password + salt should be hashed, and then hashed at least one more time with a good hash algorithm
** Round 1: User hashes password once (in JavaScript) then sends the hash to the server
** Round 2: PHP code takes the hash, appends the salt, then hashes that again and stores that
** Round 2.5? You can have the client or server rehash their result as many times as you desire

* Once logged in, use PHP SESSION to track the user's login throughout all other pages of this assignment (cookies)
** The browser can close, then be reopened and you are still logged in

* A logout button, which PHP side clears the SESSION variables
** The user should be redirected to the login page.

A Minesweepper game

* The server should keep the entire game board's info server side.  No game board knowledge should exist client side except for what the client discovers.

* The board should be at a minimum 9x9 with 10 mines.

* All client->server->client communication should be asynchronous and use AJAX.  (Check with me if you want to use another tool that abstracts the AJAX or JavaScript in general.  I have already given approval for JQuery and TypeScript to two other groups.) 

* The Minesweeper game should have similar behavior to the common game.  Similar behavior means flagging mines and clicking squares to get numbers.   However, if the user selects a square with a 0, you can just display 0 or blank, and not auto discover all neighbors. 

* The game needs a timer and a high score table.

* The game should be stored on the server either in your own database or in session variables, so that a user could close down the browser, reopen the browser, and still continue play.
