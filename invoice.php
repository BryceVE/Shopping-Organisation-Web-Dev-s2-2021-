<?php include "template.php"; ?>
<title>Invoicing</title>
<?php
/**
 * Invoicing page
 * This page is used for different cases:
 * 1) Users to view their "open" orders as a list.
 * 2) Users to view invoices from individual orders (using the order variable in url)
 * 3) Inform users if they have not previously made any orders.
 * 4) Administrators to view all orders.
 * 5) If user is not logged in, then redirect them to index.php
 *
 * "Defines" the conn variable, removing the undefined variable errors.
 * @var SQLite3 $conn
 */
?>

<?php
//is there nothing in the url that says "order"
if (empty($_GET["order"])) { // Showing the list of open order (case 1)
    //headings
    echo "<h1 class='text-primary'>Invoices</h1>";
    echo "<h2 class='text-primary'>Choose your invoice number below.</h2>";

    //if user is logged in
    if (isset($_SESSION["user_id"])) { // Case 1 or 3?

        //if user is an admin
        if($_SESSION["level"] =="Administrator") {
            //lists all the order codes of orders that the user logged in has made and the status is "OPEN"
            $query = $conn->query("SELECT orderCode FROM orderDetails");
            //only gets the first response
            $count = $conn->querySingle("SELECT orderCode FROM `orderDetails`");
        } else { //if user is not an admin
            $userID = $_SESSION["user_id"];
            //lists all the order codes of orders that the user logged in has made and the status is "OPEN"
            $query = $conn->query("SELECT orderCode FROM orderDetails WHERE userID='$userID' AND status='OPEN'");
            //only gets the first response
            $count = $conn->querySingle("SELECT orderCode FROM `orderDetails` WHERE userID='$userID' AND status='OPEN'");
        }

        $orderCodesForUser = [];

        //if user has any open orders
        if ($count > 0){  //Case 1
            //lists all the order codes
            while ($data = $query->fetchArray()) {
                $orderCode = $data[0];
                array_push($orderCodesForUser, $orderCode);
            }
            echo "<p>";

            //Gets the unique order numbers from the extracted table above.
            $unique_orders = array_unique($orderCodesForUser);
            // Produce a list of links of the Orders for the user.
            foreach ($unique_orders as $order_ID) {
                echo "<p><a href='invoice.php?order=" . $order_ID . "'>Order : " . $order_ID . "</a></p>";
            }
        } else{ // Case 3
            echo "You don't have any open orders. Please make an order to view them<br><br>";
            //displays button that takes user to order page
            echo '<button id="Order_page" class="btn btn-primary">Order Here</button>';?>
<script type="text/javascript">
    document.getElementById("Order_page").onclick = function () {
        location.href = "orderForm.php";
    };
</script>
<?php

        }
    }else {// Case 5
        header("Location:index.php");
    }
} else { // Case 2 - There is an order code in the URL
    $order_id = $_GET["order"];
    //heading
    echo"<h1 class='text-primary'>Invoice -". $order_id ."</h1>";
    //p = products table; o = order table
    $query = $conn->query("SELECT p.productName, p.price, o.quantity, p.price*o.quantity as SubTotal, o.orderDate, o.status FROM orderDetails o INNER JOIN products p on o.productCode = p.code WHERE orderCode='$order_id'");

    //total cost
    $total = 0;

    //display data
    echo"<div class='container-fluid'><div class='row'><div class='col text-success'>Product Name</div><div class='col text-success'>Price</div><div class='col text-success'>Quantity</div><div class='col text-success'>Subtotal</div></div>";
    while($data = $query->fetchArray()) {
        echo"<div class='row'>";
        $productName = $data[0];
        $price = $data[1];
        $quantity = $data[2];
        $subtotal = $data[3];
        $orderDate = $data[4];
        $status = $data[5];
        //calculating total cost
        $total = $total + $subtotal;
        echo"<div class='col'>". $productName ."</div>";
        echo"<div class='col'>$". $price ."</div>";
        echo"<div class='col'>". $quantity ."</div>";
        echo"<div class='col'>$". $subtotal ."</div>";

        echo"</div>";
    }

    echo"<div class='row'><div class='col'></div><div class='col'></div><div class='col display-4'>Total : $". $total ."</div></div>";
    echo"<div class='row'><div class='col'></div><div class='col'></div><div class='col'>". $orderDate ."</div></div>";

}
?>
