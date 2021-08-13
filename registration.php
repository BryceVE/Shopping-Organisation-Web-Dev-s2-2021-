<?php include "template.php"; ?>
<title>User Registration</title>
<h1 class='text-primary'>User Registration</h1>

<!-- A javascript function to preview the new profile picture the user has chosen -->
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

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <!--Customer Details-->

            <div class="col-md-6">
                <!--Account details-->
                <h2>Account Details</h2>
                <p>Please enter username and password:</p>
                <p>User Name<input type="text" name="username" class="form-control" required="required"></p>
                <p>Password<input type="password" name="password" class="form-control" required="required"></p>

            </div>
            <div class="col-md-6">
                <!--More details-->
                <h2>More Details</h2>
                <p>Please enter More Personal Details:</p>
                <p>Name<input type="text" name="name" class="form-control" required="required"></p>
                <p>Profile Picture <input type="file" name="file" class="form-control" required="required" onchange="preview_image(event)" accept="image/*"></p>
                <!--display profile picture image preview-->
                <p>Image preview: <img id="output_image" width="100"></p>
            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Customer Details
    $username = sanitise_data($_POST['username']);
    $password = sanitise_data($_POST['password']);
    $name = sanitise_data($_POST['name']);

//check if user exists.
    $query = $conn->query("SELECT COUNT(*) FROM user WHERE username='$username'");
    $data = $query->fetchArray();
    $numberOfUsers = (int)$data[0];

//if there a user already exists with same username display error message
    if ($numberOfUsers > 0) {
        echo "Sorry, username already taken";
    } else {
// User Registration commences

//for the user-hashed table. Hashes te password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//for the image table.
        $file = $_FILES['file'];

//Variable Names
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];

//defining what type of file is allowed
//separate the file to obtain the file type.
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
//allowed file types.
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        //if the file type is allowed
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                //file is smaller than allowed size.
                if ($fileSize < 10000000000) {
                    //file name is now a unique ID (name) based on time with IMG- precedding it, followed by the file type.
                    $fileNameNew = uniqid('IMG-', True) . "." . $fileActualExt;
                    //upload location
                    $fileDestination = 'images/profile_pictures/' . $fileNameNew;
                    //command to upload data to database.
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $sql = "INSERT INTO user (username, password, name, profilePic, accessLevel) VALUES (:newUsername, :newPassword, :newName, :newImage, 'User')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':newUsername', $username);
                    $stmt->bindValue(':newPassword', $hashed_password);
                    $stmt->bindValue(':newName', $name);
                    $stmt->bindValue(':newImage', $fileNameNew);
                    $stmt->execute();
                    //redirects to home page
                    header("location:index.php");
                } else {
                    echo "Your image is too big!";
                }
            } else {
                echo "there was an error uploading your image!";
            }
        } else {
            echo "You cannot upload files of this type!";
        }
    }
}
?>

</body>
</html>
