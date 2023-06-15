<?php

session_start(); //session is a way to store information (in variables) to be used across multiple pages.  

if (isset($_GET['login'])) {
    session_unset();
    session_destroy();
    header("Location: login.php"); //use for the redirection to some page  
}
?>
<html>

<head>
    <title>
        <?php
        if (!isset($_SESSION['userID'])) {
        ?>
            Please login first!
        <?php
        }
        ?>
    </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .container {
            width: 1000px;
            margin: 100px auto;
        }

        .special {
            margin: 40px auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-md-12 text-center">
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    if (!isset($_SESSION['userID'])) {
                    ?>
                        <h2>Please login first before enter the system!</h2>
                    <?php
                    } else {
                    ?>
                        <h1>Log out Successfully</h1>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="special">
                        <form method="GET">
                            <input type="submit" class="btn btn-primary" name="login" value="Login" class="text-center">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>