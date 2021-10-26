<?php
//includes the Navbar
include "template.php";

/**
 * This displays a list of all products currently in the database
 *
 * Also shows buttons to edit or delete each product
 */


//if the user is logged in
if (isset($_SESSION["username"])) {
    //if the user is an admin
    if ($_SESSION["level"] == "Administrator") {
    } else {
        //if the user is not an admin send them to the home page
        header("location:index.php");
    }
} else {
    //if the user is not logged in send them to the home page
    header("location:index.php");
}

?>
<!--title-->
<title>Products List</title>

<!--heading-->
<h1 style='margin-left: 10px' class='text-primary'>Products List</h1> <!--bootstrap colours-->
<br>


<?php
//grabs all the product names and their images from the products table
$productList = $conn->query("SELECT productName, image, code FROM products");
?>

<!--Display the products and their images nicely-->
<div class="container-fluid">
    <?php
    //repeats the following code for each product in the database
    while ($productData = $productList->fetchArray()) {
        ?>
        <div class="row">
            <div class="col-md-2">
                <?php
                //displays the products image
                echo '<img src="images/product_pictures/' . $productData[1] . '" height="50">';
                ?>
            </div>
            <div class="col-md-4">
                <?php
                //displays the products name
                echo $productData[0]; ?>
            </div>
            <div class="col-md-2">
                <!--edit button-->
                <a href="product-edit.php?prodCode=<?php echo $productData[2]; ?>">Edit</a>
            </div>
            <div class="col-md-2">
                <!--delete button-->
                <a href="product-remove.php?prodCode=<?php echo $productData[2]; ?>">Delete</a>
            </div>
        </div>
        <?php
    } //end of while loop on line 21
    ?>


</div>