<?php
//includes the Navbar
include "template.php";
/**
 *  This is the user's profile page.
 * It shows the Users details including picture, and a link to edit the details.
 *
 * @var SQLite3 $conn
 */
?>
    <!--title-->
    <title>User Profile</title>

    <!--heading-->
    <h1 class='text-primary'>Your Profile</h1>

<?php

//if the user is logged in
if (isset($_SESSION["username"])) {
//session variables into php variables
    $userName = $_SESSION["username"];
    $userId = $_SESSION["user_id"];

//selects all data for user logged in
    $query = $conn->query("SELECT * FROM user WHERE username='$userName'");
    $userData = $query->fetchArray();
//stores data into variables
    $userName = $userData[1];
    $password = $userData[2];
    $name = $userData[3];
    $profilePic = $userData[4];
    $accessLevel = $userData[5];
} else {
    //if not logged in go to home page
    header("Location:index.php");
}
?>

    <!--Displays the user information-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!--            username-->
                <h3>Username: <?php echo $userName; ?></h3>
                <!--            profile picture-->
                <p>Profile Picture:</p>
                <?php echo "<img src='images/profile_pictures/" . $profilePic . "' width='100' height='100'>" ?>
            </div>
            <div class="col-md-6">
                <!--            user name-->
                <p> Name: <?php echo $name ?> </p>
                <!--            users' access level-->
                <p> Access Level: <?php echo $accessLevel ?> </p>
                <!--            edit profile button-->
                <p><a href="edit.php" title="Edit">Edit Profile</a></p>
            </div>
        </div>
    </div>


<?php
//queries the database to get how many rows there are where the recipient columns are the same the user id.
$numberOfRowsReturned = $conn->querySingle("SELECT count(*) FROM messaging WHERE recipient='$userId'");

//if the amount of rows is more than 0
if ($numberOfRowsReturned > 0) {
    //selects all rows where the recipient columns are the same the user id.
    $messages = $conn->query("SELECT * FROM messaging WHERE recipient='$userId'");
    ?>
    <div class="container-fluid">
    <div class="row">
<!--        display headings-->
        <div class="col-md-4 text-success"><h2>From</h2></div>
        <div class="col-md-4 text-success"><h2>Message</h2></div>
        <div class="col-md-4 text-success"><h2>Date Sent</h2></div>
    </div>

    <?php
//    loops following code for each message the user logged in has submitted
    while ($individual_message = $messages->fetchArray()) {
        //extracts the parts of the message into variables to use later
        $sender = $individual_message[1];
        $message = $individual_message[3];
        $dateSubmitted = $individual_message[4];
        ?>
        <div class="row">
<!--        displays the individual parts of each message-->
        <div class="col-md-4"><?php echo $sender; ?></div>
        <div class="col-md-4"><?php echo $message; ?></div>
        <div class="col-md-4"><?php echo $dateSubmitted; ?></div>
        </div>

        <?php
    }
}
?>