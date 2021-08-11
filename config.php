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
        //echo "<p style='color: green'>" . $tableName . ": Table Created Successfully</p>";
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
/*
//creates order details table
$createOrderDetailsTableQuery = file_get_contents("sql/create-orderDetails.sql");
createTable($createOrderDetailsTableQuery, "Order Details");
//creates messages table
$createMessagingTableQuery = file_get_contents("sql/create-messaging.sql");
createTable($createMessagingTableQuery, "Messages");
*/

//function to add default users to database
function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel) {
    global $conn;
    //hashes password
    $hashedPassword = password_hash($unhashedPassword, PASSWORD_DEFAULT);
    //prepares query to insert data into table
    $sqlstmt = $conn->prepare("INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:userName, :hashedPassword, :name, :profilePic, :accessLevel)");
    //binds values to variables; safer method to insert users
    $sqlstmt->bindValue(':userName', $username);
    $sqlstmt->bindValue(':hashedPassword', $hashedPassword);
    $sqlstmt->bindValue(':name', $name);
    $sqlstmt->bindValue(':profilePic', $profilePic);
    $sqlstmt->bindValue(':accessLevel', $accessLevel);
    //displays success message or error message
    if ($sqlstmt->execute()) {
        //echo "<p style='color: green'>User: ".$username. ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>User: ".$username. ": Created Failure</p>";
    }
}

//gets the count of rows in table
$query = $conn->query("SELECT COUNT(*) as count FROM user");
$rowCount = $query->fetchArray();
$userCount = $rowCount["count"];

//if there are no rows (users) in the users table this inserts users using the addUser function
if ($userCount == 0) {
    addUser("admin", "admin", "Administrator", "admin.png", "Administrator");
    addUser("user", "user", "User", "user.png", "User");
    addUser("Bryce", "Bryce", "Bryce", "Bryce.png", "User");
}

//function to add products into database
function addProduct($productName, $category, $quantity, $price, $image, $code) {
    global $conn;
    $sqlstmt = $conn->prepare("INSERT INTO products (productName, category, quantity, price, image, code) VALUES (:productName, :category, :quantity, :price, :image, :code)");
    $sqlstmt->bindValue(':productName', $productName);
    $sqlstmt->bindValue(':category', $category);
    $sqlstmt->bindValue(':quantity', $quantity);
    $sqlstmt->bindValue(':price', $price);
    $sqlstmt->bindValue(':image', $image);
    $sqlstmt->bindValue(':code', $code);
    if ($sqlstmt->execute()) {
        //echo "<p style='color: blue'>Product: ".$productName. ": Created Successfully</p>";
    } else {
        echo "<p style='color: red'>Product: ".$productName. ": Created Failure</p>";
    }
}

//gets the count of rows in table
$query = $conn->query("SELECT COUNT(*) as count FROM products");
$rowCount = $query->fetchArray();
$productCount = $rowCount["count"];

//if there are no rows (products) inserts products using the addProduct function
if ($productCount == 0){
    addProduct("Sydney Opera House", "Buildings", 10, 20, "SydneyOperaHouse.jpg", "37c7ie3");
    addProduct("Leaning Tower of Pisa", "Buildings", 10, 30, "TowerOfPisa.jpg", "sj6ksa9");
    addProduct("Taj Mahal", "Buildings", 10, 70, "TajMahal.jpg", "3hlam7s");
    addProduct("Himeji Castle", "Buildings", 10, 20, "HimejiCastle.jpg", "akl90an");
    addProduct("Windmill", "Buildings", 10, 20, "Windmill.jpg", "nm89sh2");
    addProduct("Pirate Ship", "Transport", 10, 90, "PirateShip.png", "hfn5lks");
    addProduct("Titanic", "Transport", 10, 80, "Titanic.jpg", "asdjhk6");
    addProduct("Tram", "Transport", 10, 20, "Tram.jpg", "b8sn642");
    addProduct("Motorcycle", "Transport", 10, 15, "Motorcycle.jpg", "bv763ns");
    addProduct("Taxi", "Transport", 10, 20, "Taxi.jpg", "sdnmio4");

    //addProduct("", "", "", "", "", "");
}
?>