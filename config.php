<?php
session_start();

//connects to database
$conn = new SQLite3("db/Blocks") or die ("unable to open database");

//function to create tables into database
function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
        //success message
        echo "<p style='color: green'>" . $tableName . ": Table Created Successfully</p>";
    } else {
        //error message
        echo "<p style='color: red'>" . $tableName . ": Table Created Failure</p>";
    }
}

//executes the SQL in the saved SQL files and executes the createTable function
//creates user table
$createUserTableQuery = file_get_contents("sql/create-user.sql");
createTable($createUserTableQuery, "User");
//creates products table
$createProductsTableQuery = file_get_contents("sql/create-products.sql");
createTable($createProductsTableQuery, "Products");
//creates order details table
$createOrderDetailsTableQuery = file_get_contents("sql/create-orderDetails.sql");
createTable($createOrderDetailsTableQuery, "Order Details");
//creates messages table
$createMessagingTableQuery = file_get_contents("sql/create-messaging.sql");
createTable($createMessagingTableQuery, "Messages");

//function to add default users to database
function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel) {
    global $conn;
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:userName, :hashedPassword, :name, :profilePic, :accessLevel)");
    $sqlstmt->bindValue(':userName', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    if ($sqlstmt->execute()) {
        echo "<p style='color: green'>User: ".$username. ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>User: ".$username. ": Created Failure</p>";
    }
}

$query = $conn->query("SELECT COUNT(*) as count FROM user");
$rowCount = $query->fetchArray();
$userCount = $rowCount["count"];

if ($userCount == 0) {
    addUser("admin", "admin", "Administrator", "admin.png", "Administrator");
    addUser("user", "user", "User", "user.png", "User");
    addUser("Bryce", "Bryce", "Bryce", "Bryce.png", "User");
}
?>