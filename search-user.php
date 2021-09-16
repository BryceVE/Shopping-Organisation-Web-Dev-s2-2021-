<?php
//includes the nav bar
include "template.php"; ?>

<!--title-->
<title>Search Users</title>
<!--heading-->
<h1 class='text-primary'>Search Users</h1>

<div style="margin-left: 10px">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <!--heading-->
            <label>Type in UserName</label><br><br>
            <!--input box to search users in-->
            <input type="search" name="search-user" class="form-control" required="required" style="width: 40%"><br>
        </div>

        <!--centred search button-->
        <button name="search" class="btn btn-primary">Search</button>
    </form>

    <?php
    //if the user is logged in and is an admin
    if (isset($_SESSION['level']) == "Administrator") {
//  gets all the rows from the user table in the database
        $userCount = $conn->query("SELECT count(*) FROM user");
//  puts the data into a variable
        $results = $userCount->fetchArray();
//  puts the count of how many rows in the table into a variable
        $userCountNumber = $results[0];
//  displays how many rows there are in the users table (how many account there are)
        echo "<br>The number of users is: ".$userCountNumber."</br>";
        echo "</div>";

        //if the search for user button is pressed
        if (isset($_POST['search'])) {
            //sanitises the data the admin is searching so no malicious code runs into the website
            $userToSearch = sanitise_data($_POST['search-user']);

            //selects the row in the user table that matches the username the admin searched
            $userSearch = $conn->query("SELECT count(*) as count, * FROM user WHERE username LIKE '$userToSearch'");
            //puts the users' information into a variable
            $results = $userSearch->fetchArray();
            //puts the number of how many rows have been selected (should only by 1 or 0)
            $userNumberOfRows = $results[1];
            //if there are more than 0 rows (if there is a user with the username searched)
            if ($userNumberOfRows > 0) {
                //puts the searched users' information into variables
                //searched users' username
                $username = $results[2];
                //searches users' name
                $name = $results[4];
                //searched users' profile picture
                $profilePic = $results[5];
                //searched users' access level
                $accessLevel = $results[6];
                ?>
                <!--displays the searched users' information nicely-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!--                        searched users' username-->
                            <h3>Username: <?php echo $username; ?></h3>
                            <!--                        searched users' profile picture-->
                            <p>Profile Picture:</p>
                            <?php echo "<img src='images/profile_pictures/" . $profilePic . "'height='150'>" ?>
                        </div>
                        <div class="col-md-6">
                            <!--                        searched users' name-->
                            <p> Name: <?php echo $name ?> </p>
                            <!--                        searched users' access level-->
                            <p> Access Level: <?php echo $accessLevel ?> </p>
                            <!--                        edit searched users' details-->
                            <p><a href="edit.php" title="Edit">Edit Profile</a></p>
                        </div>
                    </div>
                </div>
                <?php
            } else { //else if there are no users with the username searched
                //displays an error message
                echo "No Users Found";
            }
        }
    }
    ?>
