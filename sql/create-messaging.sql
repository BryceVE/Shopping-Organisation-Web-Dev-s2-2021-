create  table IF NOT EXISTS messaging
(
    message_id INTEGER not null primary key,
    sender TEXT,
    recipient int,
    message TEXT,
    dateSubmitted DATETIME
);