<?php
session_start();

$conn = new SQLite3("db/Blocks") or die ("unable to open database");

function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
        echo "<p style='color: green'>" . $tableName . ": Table Created Successfully</p>";
    } else {
        echo "<p style='color: red'>" . $tableName . ": Table Created Failure</p>";
    }
}

$createUserTableQuery = file_get_contents("sql/create-user.sql");
createTable($createUserTableQuery, "User");
$createProductsTableQuery = file_get_contents("sql/create-products.sql");
createTable($createProductsTableQuery, "Products");
$createOrderDetailsTableQuery = file_get_contents("sql/create-orderDetails.sql");
createTable($createOrderDetailsTableQuery, "Order Details");
$createMessagingTableQuery = file_get_contents("sql/create-messaging.sql");
createTable($createMessagingTableQuery, "Messages");
?>