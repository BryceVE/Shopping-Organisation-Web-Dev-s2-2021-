<?php
//starts the user's session when they open the page
session_start();

//connects to database
$conn = new SQLite3("db/Blocks") or die ("unable to open database");

//function to create default tables into database
function createTable($sqlStmt, $tableName)
{
    global $conn;
    $stmt = $conn->prepare($sqlStmt);
    if ($stmt->execute()) {
        //success message (commented out)
        //echo "<p style='color: green'>" . $tableName . ": Table Created Successfully</p>";
    } else {
        //error message
        echo "<p style='color: red'>" . $tableName . ": Table Created Failure</p>";
    }
}

//    executes the SQL in the saved SQL files and executes the createTable function to make a new table
//creates user table
$createUserTableQuery = file_get_contents("sql/create-user.sql");
createTable($createUserTableQuery, "User");

//creates products table
$createProductsTableQuery = file_get_contents("sql/create-products.sql");
createTable($createProductsTableQuery, "Products");

//creates order details table
$createOrderDetailsTableQuery = file_get_contents("sql/create-orderDetails.sql");
createTable($createOrderDetailsTableQuery, "Order Details");

/* commented out tables that are not needed yet
//creates messages table
$createMessagingTableQuery = file_get_contents("sql/create-messaging.sql");
createTable($createMessagingTableQuery, "Messages");
*/


//function to add default users to database
function addUser($username, $unhashedPassword, $name, $profilePic, $accessLevel) {
    global $conn;
    //hashes the password to make it secure
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
        //user created error message
        echo "<p style='color: red'>User: ".$username. ": Created Failure</p>";
    }
}

//gets the count of rows in user table to count how many accounts
$query = $conn->query("SELECT COUNT(*) as count FROM user");
//stores data into variable array for use later
$rowCount = $query->fetchArray();
//gets the count of rows
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
    //prepares SQL code to add products to products table in database
    $sqlstmt = $conn->prepare("INSERT INTO products (productName, category, quantity, price, image, code) VALUES (:productName, :category, :quantity, :price, :image, :code)");
    //binds values to variables; safer method to insert users
    $sqlstmt->bindValue(':productName', $productName);
    $sqlstmt->bindValue(':category', $category);
    $sqlstmt->bindValue(':quantity', $quantity);
    $sqlstmt->bindValue(':price', $price);
    $sqlstmt->bindValue(':image', $image);
    $sqlstmt->bindValue(':code', $code);
    //executes the SQL code above
    if ($sqlstmt->execute()) {
        //success message (commented out)
        //echo "<p style='color: blue'>Product: ".$productName. ": Created Successfully</p>";
    } else {
        //error message
        echo "<p style='color: red'>Product: ".$productName. ": Created Failure</p>";
    }
}

//gets the count of rows in products table
$query = $conn->query("SELECT COUNT(*) as count FROM products");
//stores data into variable array for use later
$rowCount = $query->fetchArray();
//stores the count of rows
$productCount = $rowCount["count"];

//if there are no rows (products) inserts products using the addProduct function
if ($productCount == 0){
    //buildings category
    addProduct("Sydney Opera House", "Buildings", 10, 20, "SydneyOperaHouse.jpg", "37c7ie3");
    addProduct("Leaning Tower of Pisa", "Buildings", 10, 30, "TowerOfPisa.jpg", "sj6ksa9");
    addProduct("Taj Mahal", "Buildings", 10, 70, "TajMahal.jpg", "3hlam7s");
    addProduct("Himeji Castle", "Buildings", 10, 20, "HimejiCastle.jpg", "akl90an");
    addProduct("Windmill", "Buildings", 10, 20, "Windmill.jpg", "nm89sh2");
    //transport category
    addProduct("Pirate Ship", "Transport", 10, 90, "PirateShip.png", "CarAb3n");
    addProduct("Titanic", "Transport", 10, 80, "Titanic.jpg", "H01dM3J");
    addProduct("Tram", "Transport", 10, 20, "Tram.jpg", "b8sn642");
    addProduct("Motorcycle", "Transport", 10, 15, "Motorcycle.jpg", "bv763ns");
    addProduct("Taxi", "Transport", 10, 20, "Taxi.jpg", "sdnmio4");
    //animals category
    addProduct("Koala", "Animals", 10, 20, "Koala.jpg", "akisk4s");
    addProduct("Kangaroo", "Animals", 10, 20, "Kangaroos.jpg", "km538vc");
    addProduct("Dog", "Animals", 10, 10, "Dog.jpg", "Cut3d0g");
    addProduct("Kookaburra", "Animals", 10, 10, "Kookaburra.jpg", "sni874m");
    addProduct("Killer Whale", "Animals", 10, 10, "KillerWhale.jpg", "SW1lb3r");
    //fantasy category
    addProduct("Unicorn", "Fantasy", 10, 10, "Unicorn.jpg", "Gg3raed");
    addProduct("Pegasus", "Fantasy", 10, 10, "Pegasus.jpg", "l0rdfqd");
    addProduct("Dragon", "Fantasy", 10, 50, "Dragon.jpg", "e1isbth");
    addProduct("Werewolf", "Fantasy", 10, 10, "Werewolf.jpg", "Rl0op1n");
    addProduct("Phoenix", "Fantasy", 10, 10, "Phoenix.jpg", "fawk3s");

    //addProduct("", "", "", "", "", "");
}
?>