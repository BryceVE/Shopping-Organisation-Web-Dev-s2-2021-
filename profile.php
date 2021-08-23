<?php include "template.php";
/**
 *  This is the user's profile page.
 * It shows the Users details including picture, and a link to edit the details.
 *
 * @var SQLite3 $conn
 */
?>
<title>User Profile</title>

<h1 class='text-primary'>Your Profile</h1>

<?php
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
?>

<!--Displays the user information-->
<div class ="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h3>Username :  <?php echo $userName; ?></h3>
            <p>Profile Picture:</p>
            <?php echo "<img src='images/profile_pictures/".$profilePic."' width='100' height='100'>"   ?>
        </div>
        <div class="col-md-6">
            <p> Name : <?php echo $name ?> </p>
            <p> Access Level : <?php echo $accessLevel ?> </p>
            <p><a href="edit.php" title="Edit">Edit Profile</a></p>
        </div>
    </div>
</div>
