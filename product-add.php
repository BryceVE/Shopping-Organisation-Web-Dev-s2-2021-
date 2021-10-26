<?php
//includes the Navbar
include "template.php";

/**
 * This page allows admins to add a product to the database that isnt already there
 */

ob_start(); //sometimes header redirects dont work this fixes the problem
?>
<!--title-->
<title>Create New Product</title>

<!--heading-->
<h1 class='text-primary'>Create New Product</h1>


<?php
//this gets all the different access levels that are currently in user table in database (should only be User or Administrator)
$query = $conn->query("SELECT DISTINCT category FROM products");
?>


<!-- A javascript function to preview the picture of the product -->
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

<!--form to create a product-->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">

            <!--Product Details-->

            <div class="col-md-6">
                <!--Product details-->
                <h2>Product Details</h2>
                <!--name input-->
                <p>Product Name<input type="text" name="prodName" class="form-control" required="required"></p>
                <!--category input-->
                <p>Product Category
                    <select name="prodCategory">
                        <?php
                        //while the query on line 15 is selecting this puts the separate information into it gets into options for the html dropdown select.
                        while ($row = $query->fetchArray()) {
                            echo '<option>'.$row[0].'</option>';
                        }
                        ?>
                    </select>
                </p>
                <!--quantity input-->
                <p>Quantity<input type="number" name="prodQuantity" class="form-control" required="required"></p>
            </div>
            <div class="col-md-6">

                <!--More details-->

                <h2>More Details</h2>
                <!--Price input-->
                <p>Price<input type="number" step="0.01" name="prodPrice" class="form-control" required="required"></p>
                <!--Product Code input-->
                <p>Product Code<input type="text" name="prodCode" class="form-control" required="required"></p>
                <!--Product picture input-->
                <p>Product Picture <input type="file" name="prodImage" class="form-control" required="required" onchange="preview_image(event)" accept="image/*"></p>
                <!--display product picture image preview-->
                <p>Image preview: <img id="output_image" width="100"></p>
            </div>
        </div>
    </div>
    <!--    submit button-->
    <input type="submit" name="formSubmit" value="Submit">
</form>

<?php
//if the user is logged in
if (isset($_SESSION["username"])) {

    //if the user is an admin
    if ($_SESSION["level"] == "Administrator") {

//if the user submits the register user form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//puts the product info into variables to be used later and sanitises the data for safety
            $prodName = sanitise_data($_POST['prodName']);
            $prodCategory = sanitise_data($_POST['prodCategory']);
            $prodQuantity = sanitise_data($_POST['prodQuantity']);
            $prodPrice = sanitise_data($_POST['prodPrice']);
            $prodCode = sanitise_data($_POST['prodCode']);


//check if user exists.
            //selects all rows where username is same as username user just submitted
            $query = $conn->query("SELECT COUNT(*) FROM products WHERE code='$prodCode'");
            //puts data into varaible array to use later
            $data = $query->fetchArray();
            //gets number of users with username
            $numberOfProducts = (int)$data[0];

//if there is a product already exists with same username if so display error message
            if ($numberOfProducts > 0) {
                //error message
                echo "Sorry, product code already taken";
            } else {
// Product Registration continues

//puts profile picture info into variable for use later
                $file = $_FILES['prodImage'];

//separates picture info for ease of access to use later
                $fileName = $_FILES['prodImage']['name'];
                $fileTmpName = $_FILES['prodImage']['tmp_name'];
                $fileSize = $_FILES['prodImage']['size'];
                $fileError = $_FILES['prodImage']['error'];
                $fileType = $_FILES['prodImage']['type'];

//defining what type of file is allowed
//separate the file to obtain the file type.
                $fileExt = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));

                //what picture formats are allowed
                $allowed = array('jpg', 'jpeg', 'png', 'pdf');

                //if the file type is allowed
                if (in_array($fileActualExt, $allowed)) {
                    //if there are no errors
                    if ($fileError === 0) {
                        //file is smaller than 10gb.
                        if ($fileSize < 10000000000) {
                            //file name is now a unique ID (name) based on time with IMG- precedding it, followed by the file type.
                            $fileNameNew = uniqid('IMG-', True) . "." . $fileActualExt;
                            //upload location
                            $fileDestination = 'images/product_pictures/' . $fileNameNew;
                            //command to upload data to database.
                            move_uploaded_file($fileTmpName, $fileDestination);

                            //SQL to upload new user info into database
                            $sql = "INSERT INTO products (productName, category, quantity, price, image, code) VALUES (:newProdName, :newProdCategory, :newProdQuantity, :newProdPrice, :newProdImage, :newProdCode)";
                            //prepares the SQL
                            $stmt = $conn->prepare($sql);
                            //binds values of user to the SQL; safer method of uploading
                            $stmt->bindValue(':newProdName', $prodName);
                            $stmt->bindValue(':newProdCategory', $prodCategory);
                            $stmt->bindValue(':newProdQuantity', $prodQuantity);
                            $stmt->bindValue(':newProdPrice', $prodPrice);
                            $stmt->bindValue(':newProdImage', $fileNameNew);
                            $stmt->bindValue(':newProdCode', $prodCode);
                            //executes the SQL to add new user into database
                            $stmt->execute();
                            //redirects to home page
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
            }
        }
    } else {
        //if the user is not an admin send them to the home page
        header("location:index.php");
    }
} else {
//if the user is not logged in send them to the home page
    header("location:index.php");
}

ob_end_flush(); //sometimes header redirects don't work this fixes the problem
?>
</body>
</html>
