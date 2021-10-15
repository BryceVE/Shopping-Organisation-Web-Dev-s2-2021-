<?php
//includes the navbar
include "template.php";
/**
 *  This is to update the details for products in the database
 *
 * @var SQLite3 $conn
 */
ob_start(); //sometimes header redirects dont work this fixes the problem
?>
    <!--title-->
    <title>Edit Product</title>

    <!--heading-->
    <h1 class='text-primary'>Edit Product</h1>

<?php
//if the product code it set
if (isset($_GET["prodCode"])) {
    //set it to a variable
    $prodCode = $_GET["prodCode"];
} else {
    //otherwise, redirects to the home page
    header("location:index.php");
}

//selects all data for the 'user to load'
$query = $conn->query("SELECT * FROM products WHERE code='$prodCode'");
//stores data into array for use later
$prodData = $query->fetchArray();
//separates the array data into variables for use later
$prodID = $prodData[0];
$prodName = $prodData[1];
$prodCategory = $prodData[2];
$prodQuantity = $prodData[3];
$prodPrice = $prodData[4];
$prodImage = $prodData[5];

?>

    <!-- A javascript function to preview the new product picture that has been chosen -->
    <script type="text/javascript">
        function preview_image(event){
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <!--Displays product information-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- display the product information-->
                <h3>Name: <?php echo $prodName; ?></h3>
                <p>Product Picture:</p>
                <?php
                //displays the users profile picture
                echo "<img src='images/product_pictures/" . $prodImage . "'height='100'>" ?>
            </div>
            <div class="col-md-6">
                <!--form for inputting new user information-->
                <form action="product-edit.php?prodCode=<?php echo $prodCode ?>" method="post" enctype="multipart/form-data">
                    <!-- displays it nicely with an input field for the user to edit-->
                    <p>Name: <input type="text" name="prodName" value="<?php echo $prodName ?>" required="required"></p>
                    <p>Category: <input type="text" name="prodCategory" value="<?php echo $prodCategory ?>" required="required"></p>
                    <p>Quantity: <input type="number" name="prodQuantity" value="<?php echo $prodQuantity ?>" required="required"></p>
                    <p>Price: <input type="number" name="prodPrice" value="<?php echo $prodPrice ?>" required="required"></p>
                    <p>Code: <input type="text" name="prodCode" value="<?php echo $prodCode ?>" required="required"></p>
                    <!-- new profile picture preview-->
                    <p>Profile Picture: <input type="file" name="prodImage_file" onchange="preview_image(event)" accept="image/*"></p>
                    <p><div style="color: darkgrey">Profile picture preview:</div><img id="output_image" width="130"></p>
                    <!--submit changes button-->
                    <input type="submit" name="formSubmit" value="Submit">
                </form>
            </div>
        </div>
    </div>

<?php
//if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //sanitise the data for the users new name and access level
    $newName = sanitise_data($_POST['name']);
    $newAccessLevel = sanitise_data($_POST['accessLevel']);

    //sets sql to override current user info with new user info in database
    $sql = "UPDATE user SET name = :newName, accessLevel=:newAccessLevel WHERE username='$prodName'";
    //prepares the SQL above
    $sqlStmt = $conn->prepare($sql);
    //binds template values with new user data
    $sqlStmt->bindValue(":newName", $newName);
    //only the admin can change that access level of a profile
    if ($prodImage == "Administrator") {
        //binds the new access level to user
        $sqlStmt->bindValue(":newAccessLevel", $newAccessLevel);
    } else {
        //binds the default (user) access level to user
        $sqlStmt->bindValue(":newAccessLevel", $prodImage);
    }
    //executes the SQL
    $sqlStmt->execute();

    //if there is no new profile picture selected
    if (!empty($_FILES['profile_file']['name'])){

        // Updating Profile picture
        //puts picture info into variable
        $file = $_FILES['profile_file'];

        //separates picture info for ease of access to use later
        $fileName = $_FILES['profile_file']['name'];
        $fileTmpName = $_FILES['profile_file']['tmp_name'];
        $fileSize = $_FILES['profile_file']['size'];
        $fileError = $_FILES['profile_file']['error'];
        $fileType = $_FILES['profile_file']['type'];

        //defining what type of file is allowed
        //we separate the file, and obtain the end.
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        //what picture formats are allowed
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        //if the picture is in one of the correct formats
        if (in_array($fileActualExt, $allowed)) {
            //if there are no errors
            if ($fileError === 0) {
                //File is smaller than 10gb.
                if ($fileSize < 10000000000) {
                    //file name is now a unique ID based on time with IMG- preceding it, followed by the file type.
                    $fileNameNew = uniqid('IMG-', True) . "." . $fileActualExt;
                    //where the picture will upload to
                    $fileDestination = 'images/profile_pictures/' . $fileNameNew;
                    //upload the picture to the file destination
                    move_uploaded_file($fileTmpName, $fileDestination);


                    //sql to insert new profile picture info into database
                    $sql = "UPDATE user SET profilePic=:newFileName WHERE username='$prodName'";
                    //prepare SQL above
                    $stmt = $conn->prepare($sql);
                    //binds new file name to the SQL; safer method of uploading
                    $stmt->bindValue(':newFileName', $fileNameNew);
                    //executes the SQL
                    $stmt->execute();
                    //resets the session profile picture variable to the new pic
                    $_SESSION['profilePicture'] = $fileNameNew;
                    //sends the user to the home page
                    header("location:index.php");
                } else {
                    //error message
                    echo "Your image is too big!";
                }
            } else {
                //error message
                echo "there was an error uploading your image!";
            }
        } else {
            //error message
            echo "You cannot upload files of this type!";
        }
    } else {
        echo "successfully updated your profile";
        header("location:index.php");
    }
}

ob_end_flush(); //sometimes header redirects don't work this fixes the problem
?>