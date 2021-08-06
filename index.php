<?php include "template.php"; ?>
<title>Blocks Home</title>

<h1 style='margin-left: 10px' class='text-primary'>Welcome to Blocks</h1> <!--bootstrap colours-->
<br><div style='margin-left: 10px; font-size: large'>Blocks<sup>TM</sup> is an Australian company that sells micro sized lego sets, the smallest block being just 4x4mm!</div>

<?php if (!isset($_SESSION["username"])) : ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" style="width: 25%; float: right; margin-right: 10px">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required="required"/>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required="required"/>
        </div>
        <div style="margin-top: 5px">
            <button name="login" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span> Login </button>
            <button name="register" onclick="location.href = 'registration.php'" style="float: right"> Register </button>
            </div>
    </form>
<?php endif; ?>
</body>
</html>