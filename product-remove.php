<?php include "template.php";
/**
 *  This will remove a given product
 *
 * @var SQLite3 $conn
 */
?>
<!--title-->
    <title>Remove Product from Database</title>

<!--heading-->
    <h1 class='text-primary'>Remove Product from Database</h1>

<?php
// this gets a product code of the product that has been selected
if (isset($_GET["prodCode"])) {
    // delete product from database
    $productToDelete = $_GET["prodCode"];
    //delete the product that has the same code that was selected to be deleted
    $query = "DELETE FROM products WHERE code='$productToDelete'";
    //prepares the query
    $sqlstmt = $conn->prepare($query);
    //executed the query
    $sqlstmt->execute();
    //display a success message
    echo "<p>Product ".$productToDelete." has been removed from the database";
} else {
    //error message
    echo "No Product to Delete";
}
?>