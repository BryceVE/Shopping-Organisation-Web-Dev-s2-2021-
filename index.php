<?php include "template.php"; ?>
<title>Blocks</title>

<h1 class='text-primary'>Welcome to our shopfront</h1> <!--bootstrap colours-->
<?php if (!isset($_SESSION["username"])) : ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required="required"/>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required="required"/>
        </div>

        <center>
            <button name="login" class="btn btn-primary"><span
                        class="glyphicon glyphicon-log-in"></span> Login
            </button>
        </center>
    </form>
<?php endif; ?>
</body>
</html>