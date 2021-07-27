create  table IF NOT EXISTS orderDetails
(
    orderDetails_id INTERGER not null primary key,
    orderCode TEXT not null,
    customerID INTERGER not null,
    productCode TEXT not null,
    orderDate DATETIME,
    quantity INTERGER,
    status TEXT default 'OPEN' not null
);