<?php
session_start();
$firstName = "";
$lastName = "";
$companyName = "";
$email = "";
$password = "";
$confirmPassword = "";
$hash = "";
$errors = "";
$num = 0;

if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['companyName']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    $userID = rand(10, 100000);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $companyName = $_POST['companyName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password == $confirmPassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        require_once "config.php";
        $sql = "INSERT INTO companyuser VALUES (:userID, :firstName, :lastName, :companyName, :email, :password )";
        $stmt = $pdo->prepare($sql);

        $stmt->execute(array(
            ':userID' => $userID,
            ':firstName' => $firstName,
            ':lastName' => $lastName,
            ':companyName' => $companyName,
            ':email' => $email,
            ':password' => $hash
        ));
        $num = 1;
        $errors = "Successfully Registered";
    } else {
        $num = 2;
        $errors = "Password and Confirm Password Not Same!";
    }
}

?>


<html lang="en">



<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <title>Bootstrap Simple Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="myStyle.css">
</head>

<body>
    <div class="signup-form">
        <form method="post">
            <h2>Register</h2>
            <p class="hint-text">Create your account. It's free and only takes a minute.</p>
            <?php
            if ($num == 1) {
                echo '<p style="color:green">' . $errors;
            } else if ($num == 2) {
                echo '<p style="color:red">' . $errors;
            }
            ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6"><input type="text" class="form-control" name="firstName" placeholder="First Name" required="required"></div>
                    <div class="col-xs-6"><input type="text" class="form-control" name="lastName" placeholder="Last Name" required="required"></div>
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="companyName" placeholder="Company Name" required="required">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm Password" required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg btn-block">Register Now</button>
            </div>
        </form>
        <div class="text-center">Already have an account? <a href="login.php">Sign in</a></div>
    </div>
</body>

</html>