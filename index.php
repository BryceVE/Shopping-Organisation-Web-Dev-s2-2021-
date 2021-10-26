<?php
//includes the Navbar
include "template.php";

/**
 * Index page is the home page of the website
 * The use can log in from this page if not already logged in
 */
?>
<!--title-->
<title>Blocks Home</title>

<!--heading-->
<h1 style='margin-left: 10px' class='text-primary'>Welcome to Blocks</h1> <!--bootstrap colours-->
<br>
<!--commented out description-->
<!--<div style='margin-left: 10px; font-size: large'>Blocks<sup>TM</sup> is an Australian company that sells micro sized
    lego sets, the smallest block being just 4x4mm!
</div>-->


<!--displays info-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">

<!--            display login info-->
            Default user: user, user <br>
            Default admin: admin, admin

        </div>
        <div class="col-md-4">

<!--            login Form -->
<!--            if the user is not logged in-->
            <?php if (!isset($_SESSION["username"])) : ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
<!--                        user name-->
                        <label>Username</label>
<!--                        user name input bot-->
                        <input type="text" name="username" class="form-control" required="required"/>
                    </div>
                    <div class="form-group">
<!--                        password-->
                        <label>Password</label>
<!--                        password input bot-->
                        <input type="password" name="password" class="form-control" required="required"/>
                    </div>
                    <div style="margin-top: 5px">
<!--                        login button-->
                        <button name="login" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span>
                            Login
                        </button>
<!--                        register button-->
                        <button name="register" onclick="location.href = 'registration.php'" style="float: right">
                            Register
                        </button>
                    </div>
                    <br>
                </form>
            <?php
            else:
                echo "<div style='font-size: large'>Blocks<sup>TM</sup> is an Australian company that sells micro sized lego sets, the smallest block being just 4x4mm!</div><br>";
                echo "<div style='font-size: medium'>Our products are delivered all over Australia with free delivery on orders over $75!<br>Delivery Australia-wide will cost $9 if the order is under $75.</div>";



            endif; ?>
        </div>
    </div>
</div>
</body>
</html>