create  table IF NOT EXISTS user
(
    user_id INTERGER not null primary key,
    username TEXT,
    password TEXT,
    name TEXT,
    profilePic TEXT,
    accessLevel TEXT
);