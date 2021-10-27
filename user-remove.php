<?php
//includes the nav bar
include "template.php";
/**
 * This page allows admins to remove a user from the database
 *
 * @var SQLite3 $conn
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
    <title>Remove User from Database</title>
<!--heading-->
    <h1 class='text-primary'>Remove User from Database</h1>

<?php
// if a user is logged in
if (isset($_GET["user_id"])) {
    //delete user from database
    $userToDelete = $_GET["user_id"];
    //echo "<p>".$userToDelete."</p>";
    $query = "DELETE FROM user WHERE user_id='$userToDelete'";
    $sqlstmt = $conn->prepare($query);
    $sqlstmt->execute();
    //success message
    echo "<p>User ".$userToDelete." has been deleted from the database";
} else {
    echo "No User to Delete";
}
?>