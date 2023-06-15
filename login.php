<?php
session_start();
$email = "";
$password = "";
$errors = "";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once "config.php";
    $stmt = $pdo->prepare("SELECT userID, email, password FROM companyuser WHERE email= :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($rows) {
        foreach ($rows as $row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['userID'] = $row['userID'];
                header("Location: index.php");
            } else {
                $errors = "Your password is incorrect!";
            }
        }
    } else {
        $errors = "Your email is not found!";
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
            <h2 class="text-center">Company Log in</h2>
            <?php
            if ($errors != "") {
                echo '<p style="color:red">' . $errors;
            }
            ?>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="Login">
            </div>
        </form>
        <p class="text-center"><a href="register.php">Create an Account</a></p>
        <p class="text-center"><a href="admin.php">Admin Login</a></p>
    </div>
</body>

</html>