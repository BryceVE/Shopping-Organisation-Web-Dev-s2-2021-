<title>Order Form</title>
<?php include "template.php";

//this gets rid of conn variable having error line under it
/**
 * @var SQLite3 $conn
 */

?>
<!--includes the css style sheet so this page is laid out properly-->
<link rel="stylesheet" href="css/orderForm.css">

<!--tile font-->
<h1 class="text-primary">Order Form</h1>


<?php
$status = "";

//selects all info from products and puts the data into variables
if (isset($_POST['code']) && $_POST['code'] != "") {
    $code = $_POST['code'];
    $row = $conn->querySingle("SELECT * FROM products WHERE code='$code'", true);
    $name = $row['productName'];
    $price = $row['price'];
    $image = $row['image'];

    $cartArray = array(
        $code => array(
            'productName' => $name,
            'code' => $code,
            'price' => $price,
            'quantity' => 1,
            'image' => $image)
    );

    //if the shopping cart is empty hide it
    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "
<div class='box'>Product is added to your cart!</div>";
    } else { //else check if product already in cart, display error message
        $array_keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($code, $array_keys)) {
            $status = "
<div class='box' style='color:red;'>
    Product is already added to your cart!
</div>";
        } else { //else if product not already in cart, add it and display success message
            $_SESSION["shopping_cart"] = array_merge(
                $_SESSION["shopping_cart"],
                $cartArray
            );
            $status = "
<div class='box'>Product is added to your cart!</div>";
        }
    }
}
?>

<!--display error/success message on the top of page in a box-->
<div class="message_box" style="margin:10px 0px">
    <?php echo $status; ?>
</div>


<?php

//if the cart is not empty, display cart picture and count how many products in cart, then display number of products in cart
if (!empty($_SESSION["shopping_cart"])) {
    $cart_count = count(array_keys($_SESSION["shopping_cart"]));
    ?>
    <div class="cart_div">
        <a href="cart.php"><img src="images/cart-icon.png"/> Cart<span>
<?php echo $cart_count; ?></span></a>
    </div>
    <?php
} //ends if statement


//selects all from products table and puts in 'result' variable
$result = $conn ->query("SELECT * FROM products");


//                 Display products neatly
//gets data from each row and repeats loop until all rows have been done.
while ($row = $result->fetchArray()) {

    //echos each product (row) using the css from orderForm.css file
    echo "<div class='product_wrapper'>
    <form method ='post' action =''>
    <!--hidden input of products unique code-->
    <input type='hidden' name='code' value=" . $row['code'] . " />
    <!--displays product image-->
    <div class='image'><img src='images/product_pictures/" . $row['image'] . "' width='100' height='100'/></div>
    <!--displays product name-->
    <div class='name'>" . $row['productName'] . "</div>
    <!--displays product price-->
    <div class='price'>$" . $row['price'] . "</div>
    <!--add to cart button-->
    <button type='submit' class='buy'>Add to Cart</button>
    </form>
    </div>";
}
?>