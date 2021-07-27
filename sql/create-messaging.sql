create  table IF NOT EXISTS messaging
(
    message_id INTERGER not null primary key,
    sender TEXT,
    recipient int,
    message TEXT,
    dateSubmitted DATETIME
);