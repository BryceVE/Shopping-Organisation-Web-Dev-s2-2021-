create table IF NOT EXISTS user
(
    user_id INTEGER not null PRIMARY KEY AUTOINCREMENT ,
    username TEXT,
    password TEXT,
    name TEXT,
    profilePic TEXT,
    accessLevel TEXT
);