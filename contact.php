<?php
//includes the Navbar
include "template.php";

/**
 * Contact Us Page.
 * Collects the users email address and message.
 * Stores the details in the messaging table for the administrator to read.
 *
 * "Defines" the conn variable, removing the undefined variable errors.
 * @var SQLite3 $conn
 */
?>
<!--title-->
    <title>Contact Us</title>

    <div class="container-fluid">
<!--        Heading-->
        <h1 class="text-primary">Please Send us a Message</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-3">
<!--                Email Address heading-->
                <label for="contactEmail" class="form-label">Email address</label>
<!--                email address input-->
                <input type="email" class="form-control" id="contactEmail" name="contactEmail"
                       placeholder="name@example.com">
            </div>
            <div class="mb-3">
<!--                Message heading-->
                <label for="contactMessage" class="form-label">Message</label>
<!--                message input-->
                <textarea class="form-control" id="contactMessage" name="contactMessage" rows="3"></textarea>
            </div>
<!--            submit button-->
            <button type="submit" name="formSubmit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php

//if the submit button is pressed
if (isset($_POST['formSubmit'])) {
    //creates empty variable to be used later
    $errorMsg = "";

    //if the user is not logged in
    if (!isset($_SESSION["user_id"])) {
        //display error message
        echo "<div class='alert-danger'>Your not logged in. Please log in or register at the home page</div>";
    } else { //else if the user is logged in

        //if the email input is empty
        if (empty($_POST['contactEmail'])) {
            //puts an error message into the $errorMsg variable as a list to be displayed
            $errorMsg .= "<li class='alert-danger'>You didn't enter your email!</li>";
        }

        //if the message input is empty
        if (empty($_POST['contactMessage'])) {
            //puts an error message into the $errorMsg variable as a list to be displayed
            $errorMsg .= "<li class='alert-danger'>You didn't enter your message!</li>";
        }

        //sets the variables to what the user submitted
        $userEmail = sanitise_data($_POST["contactEmail"]);
        $userMessage = sanitise_data(($_POST["contactMessage"]));
        $userID = $_SESSION["user_id"];

        //if there are error messages (if the error message variable is not empty)
        if (!empty($errorMsg)) {
            //output the error/s
            echo("<p>There was an error:</p>");
            //displays the errors that were saved earlier (49, 55)
            echo("<ul>" . $errorMsg . "</ul>");
        } else { //else if the $errorMsg variable is empty
            //sets the default time zone to Sydney
            date_default_timezone_set('Australia/Sydney');
            //sets the date and time formatting wanted
            $submittedDateTime = date("Y-m-d h:i:sa");

            //prepares SQL to put the message into the database
            $sqlStmt = $conn->prepare("INSERT INTO messaging (sender, recipient, message, dateSubmitted) VALUES (:sender, :recipient, :message, :dateSubmitted)");
            //binds the values of the message details to the SQL; safer method of uploading
            $sqlStmt->bindValue(":sender", $userEmail);
            $sqlStmt->bindValue(":recipient", $userID);
            $sqlStmt->bindValue(":message", $userMessage);
            $sqlStmt->bindValue(":dateSubmitted", $submittedDateTime);
            //executes the SQL
            $sqlStmt->execute();
            //displays a success message
            echo "<div class='alert-primary'>Message Submitted</div>";
        }
    }
}
?>