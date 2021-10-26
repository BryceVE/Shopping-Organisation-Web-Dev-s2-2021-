<?php
//includes the nav bar
include "template.php";
/**
 * This page allows admins to remove a user from the database
 *
 * @var SQLite3 $conn
 */
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