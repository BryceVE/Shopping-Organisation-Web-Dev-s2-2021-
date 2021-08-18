<?php include "template.php";

/**
 * Shopping Cart.
 * Displays (and allows edits) of the items that the user has entered into their cart.
 * On submit, writes it to the orderDetails table.
 * Additionally updates messaging table to send message to admin to indicates order has been made.
 *
 * "Defines" the conn variable, removing the undefined variable errors.
 * @var SQLite3 $conn
 */
?>
<title>Cart</title>

<link rel="stylesheet" href="css/orderForm.css">


<?php

//function to remove item from shopping cart
if (isset($_POST['action']) && $_POST['action'] == "remove") {
    //if shopping cart is not empty
    if (!empty($_SESSION["shopping_cart"])) {
        //goes through each product and grabs the element out as $key
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            //if the item is the same as the element $key
            if ($_POST["code"] == $key) {
                //unset / delete that session variable out of the shopping cart array
                unset($_SESSION["shopping_cart"][$key]);
                //output the status saying that the product was removed successfully
                $status = "<div class='box' style='color:red;'>Product is removed from your cart!</div>";
            }
            //if the shopping cart is not empty
            if (empty($_SESSION["shopping_cart"]))
                //unset / delete the shopping_cart variable from the session / memory
                unset($_SESSION["shopping_cart"]);
        }
    }
}



//This code runs when the quantity changes for a row
if (isset($_POST['action']) && $_POST['action'] == "change") {
    //for each value / row in the shopping cart
    foreach ($_SESSION["shopping_cart"] as &$value) {
        //checks if code is same as code that has been updated
        if ($value['code'] === $_POST["code"]) {
            //grabs the quantity that has been set and stores it into the shopping cart variable
            $value['quantity'] = $_POST["quantity"];
            break; // Stop the loop after we've found the product
        }
    }
}
 ?>


<div class="cart">
    <?php
    //if there is something in the shopping_cart variable
    if (isset($_SESSION["shopping_cart"])) {
    //resets the total price if there is a product in the shopping cart
    $total_price = 0;
    ?>
    <table class="table">
        <tbody>
        <tr>
            <td></td>
            <td>ITEM NAME</td>
            <td>QUANTITY</td>
            <td>UNIT PRICE</td>
            <td>ITEMS TOTAL</td>
        </tr>
        <?php
        //for every product in variable shopping_cart create a row
        foreach ($_SESSION["shopping_cart"] as $product) {
            ?>
            <tr>
                <td>
                    <!--displays product image from folder-->
                    <img src='images/product_pictures/<?php echo $product["image"]; ?>' width="40"/>
                </td>
                <td>
                    <!--displays product name-->
                    <?php echo $product["productName"]; ?>
                    <form method='post' action=''>
                            <input type='hidden' name='code' value="<?php echo $product["code"]; ?>"/>
                            <input type='hidden' name='action' value="remove"/>
                            <button type='submit' class='remove'>Remove Item</button>
                        </form>
                </td>
                <td>
                    <!--form for selecting quantity-->
                    <form method='post' action=''>
                        <input type='hidden' name='code' value="<?php echo $product["code"]; ?>"/>
                        <input type='hidden' name='action' value="change"/>
                        <!--select box-->
                        <select name='quantity' class='quantity' onChange="this.form.submit()">
                            <!--different options in the dropdown-->
                            <!--option 1-->
                            <option <?php if ($product["quantity"] == 1) echo "selected"; ?>
                                    value="1">1
                                    <!--the option value is "1"-->
                            </option>
                            <!--option 2-->
                            <option <?php if ($product["quantity"] == 2) echo "selected"; ?>
                                    value="2">2
                            </option>
                            <!--option 3-->
                            <option <?php if ($product["quantity"] == 3) echo "selected"; ?>
                                    value="3">3
                            </option>
                            <!--option 4-->
                            <option <?php if ($product["quantity"] == 4) echo "selected"; ?>
                                    value="4">4
                            </option>
                            <!--option 5-->
                            <option <?php if ($product["quantity"] == 5) echo "selected"; ?>
                                    value="5">5
                            </option>
                        </select>
                    </form>
                </td>
                <td>
                    <!--Individual product price-->
                    <?php echo "$" . $product["price"]; ?>
                </td>
                <td>
                    <!--Subtotal price for product-->
                    <?php echo "$" . $product["price"] * $product["quantity"]; ?>
                </td>
            </tr>
            <?php
            //multiplying quantity by product price into a variable
            $total_price += ($product["price"] * $product["quantity"]);
            } //ends the foreach loop if
            ?>
            <tr>
                <td colspan="5" align="right">
                    <!--displays the total price of individual product-->
                    <strong>TOTAL: <?php echo "$" . $total_price; ?></strong>
                </td>
            </tr>
        </tbody>
    </table>
    <?php
} //ends the if statement
?>