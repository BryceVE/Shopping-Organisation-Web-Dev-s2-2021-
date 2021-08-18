create  table IF NOT EXISTS orderDetails
(
    orderDetails_id INTEGER not null primary key,
    orderCode TEXT not null,
    userID INTEGER not null,
    productCode TEXT not null,
    orderDate DATETIME,
    quantity INTEGER,
    status TEXT default 'OPEN' not null
);