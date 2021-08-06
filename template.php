<?php require_once 'config.php'; ?>
<?php include 'login.php'; ?>

    <html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
<body>

    <!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation">
    <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="" width="80" height="80">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse w-100 order-3 dual-collapse2" id="navbarNav">

    <!--Default navbar items-->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
    </ul>

<!--Left side of Navbar-->
<?php if (isset($_SESSION["username"])) : ?>


<?php if ($_SESSION["level"] == "Administrator") : ?>


    <?php endif; ?>
<?php endif; ?>



<!--Right side of Navbar-->

<!--Style for Right side alignment in NavBar-->
<div class="mx-auto order-0"></div>
<!--Unauthenticated user-->
<?php if (!isset($_SESSION["username"])) : ?>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="registration.php">Register</a>
        </li>
    </ul>
<?php endif; ?>

<!--Authenticated user-->
<?php if (isset($_SESSION["username"])) : ?>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="profile.php">User Profile</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
<?php endif; ?>
    </ul>
    </div>
    </div>
    </nav>


    <script src="js/bootstrap.bundle.js"></script>

    <?php
    function sanitise_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function outputFooter()
    {
        date_default_timezone_set('Australia/Canberra');
        echo "<footer>This page was last modified: " . date("F d Y H:i:s.", filemtime("index.php")) . "</footer>";
    }

    ?>