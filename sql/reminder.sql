CREATE TABLE user (
	username VARCHAR(150),
	password CHAR(64),
	salt CHAR(32),
	PRIMARY KEY(username)
);



