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
    $errorMsg = "";

    if (empty($_POST['contactEmail'])) {
        $errorMsg .= "<li class='alert-danger'>You didn't enter your email!</li>";
    }

    if (empty($_POST['contactMessage'])) {
        $errorMsg .= "<li class='alert-danger'>You didn't enter your message!</li>";
    }

    $userEmail = sanitise_data($_POST["contactEmail"]);
    $userMessage = sanitise_data(($_POST["contactMessage"]));

    if (!empty($errorMsg)) {
        // Output the error/s
        echo("<p>There was an error:</p>");
        echo("<ul>" . $errorMsg . "</ul>");
    } else {
        date_default_timezone_set('Australia/Sydney');
        $submittedDateTime = date("Y-m-d h:i:sa");

        $sqlStmt = $conn->prepare("INSERT INTO messaging (sender, recipient, message, dateSubmitted) VALUES (:sender, :recipient, :message, :dateSubmitted)");
        $sqlStmt->bindValue(":sender", $userEmail);
        $sqlStmt->bindValue(":recipient", 1);
        $sqlStmt->bindValue(":message", $userMessage);
        $sqlStmt->bindValue(":dateSubmitted", $submittedDateTime);
        $sqlStmt->execute();
        echo "<div class='alert-primary'>Message Submitted</div>";
    }
}
?>