<?php include "template.php";
/**
 * This is for admins to remove a given product from the database
 *
 * @var SQLite3 $conn
 */
?>
    <!--title-->
    <title>Remove Product from Database</title>

    <!--heading-->
    <h1 class='text-primary'>Remove Product from Database</h1>

<?php
//if the user is logged in
if (isset($_SESSION["username"])) {
    //if the user is an admin
    if ($_SESSION["level"] == "Administrator") {

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
            echo "<p>Product " . $productToDelete . " has been removed from the database";
        } else {
            //error message
            echo "No Product to Delete";
        }
    } else {
        //if the user is not an admin send them to the home page
        header("location:index.php");
    }
} else {
    //if the user is not logged in send them to the home page
    header("location:index.php");
}

?>