<?php
//includes the Navbar
include "template.php"; ?>
<!--title-->
<title>Products List</title>

<!--heading-->
<h1 style='margin-left: 10px' class='text-primary'>Products List</h1> <!--bootstrap colours-->
<br>


<?php
//grabs all the product names and their images from the products table
$productList = $conn->query("SELECT productName, image FROM products");
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
                echo '<img src="images/product_pictures/'.$productData[1].'" height="50">';
                ?>
            </div>
            <div class="col-md-4">
                <?php
                //displays the products name
                echo $productData[0]; ?>
            </div>
            <div class="col-md-2">
                <!--edit button-->
                Edit
            </div>
            <div class="col-md-2">
                <!--delete button-->
                Delete
            </div>
        </div>
        <?php
    } //end of while loop on line 21
    ?>


</div>