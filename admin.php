<?php
session_start();
$email = "";
$password = "";
$errors = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once "config.php";

    $stmt = $pdo->prepare("SELECT admin_id, username, password FROM admin WHERE username= :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo count($rows);
    if ($rows) {
        foreach ($rows as $row) {
            if ($password == $row['password']) {
                $_SESSION['adminID'] = $row['admin_id'];
                header("Location: indexAdmin.php");
            } else {
                $errors = "Your password is incorrect!";
            }
        }
    } else {
        $errors = "Your username is not found!";
    }
}
?>
<html lang="en">

<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="loginStyle.css">
</head>

<body>
    <div class="login-form">
        <form method="post">
            <h2 class="text-center">Admin Log in</h2>
            <?php
            if ($errors != "") {
                echo '<p style="color:red">' . $errors;
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Login">
            </div>
        </form>
        <p class="text-center"><a href="login.php">Company Login</a></p>
    </div>
</body>

</html>