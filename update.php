<?php
// Include config file
require_once "config.php";
session_start();

// Define variables and initialize with empty values
$stockID = $stockName = $category = $quantity = $userID = "";
$stockID_err = $stockName_err = $category_err = $quantity_err = $userID_err = "";

//$userID = $_SESSION['userID'];
// Processing form data when form is submitted
if (isset($_POST['stockID']) && !empty($_POST['stockID'])) {
    $stockID = $_POST["stockID"];
    $userID = $_POST['userID'];
    $stockName = $_POST['stockName'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];

    // Validate stockName
    $input_stockName = trim($stockName);
    if (empty($input_stockName)) {
        $stockName_err = "Please enter a stock name.";
    } elseif (!filter_var($input_stockName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid stock name.";
    } else {
        $stockName = $input_stockName;
    }

    // Validate category
    $input_category = trim($category);
    if (empty($input_category)) {
        // echo $input_category;
        $category_err = "Please enter a stock category.";
    } elseif (!filter_var($input_category, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $category_err = "Please enter a valid stock category.";
    } else {
        $category = $input_category;
    }

    // Validate quantity
    $input_quantity = trim($quantity);
    if (empty($input_quantity)) {

        $salary_err = "Please enter the stock quantity.";
    } else if ($input_category < 1) {
        $quantity_err = "Please enter a positive integer value." . $input_quantity;
    } else {
        $quantity = $input_quantity;
    }

    // Check input errors before inserting in database
    if (empty($stockID_err) && empty($stockName_err) && empty($category_err) && empty($quantity_err) && empty($userID_err)) {
        // Prepare an update statement
        $sql = "UPDATE stock SET stockName=:stockName, category=:category, quantity=:quantity WHERE stockID=:stockID";

        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_stockName = $stockName;
            $param_category = $category;
            $param_quantity = $quantity;

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":stockName", $param_stockName);
            $stmt->bindParam(":category", $param_category);
            $stmt->bindParam(":quantity", $param_quantity);
            $stmt->bindParam(":stockID", $stockID);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["stockID"]) && !empty(trim($_GET["stockID"]))) {
        // Get URL parameter
        $stockID =  trim($_GET["stockID"]);

        // Prepare a select statement
        $sql = "SELECT * FROM stock WHERE stockID = :stockID";
        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_stockID = $stockID;
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":stockID", $param_stockID);

            // Set parameters
            $param_stockID = $stockID;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Retrieve individual field value
                    $stockName = $row["stockName"];
                    $category = $row["category"];
                    $quantity = $row["quantity"];
                    $userID = $_SESSION['userID'];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);

        // Close connection
        unset($pdo);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the stock record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Stock ID</label>
                            <input type="text" name="stockID" class="form-control <?php echo (!empty($stockID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stockID; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Stock Name</label>
                            <input type="text" name="stockName" class="form-control <?php echo (!empty($stockName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stockName; ?>">
                            <span class="invalid-feedback"><?php echo $stockName_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $category; ?>">
                            <span class="invalid-feedback"><?php echo $category_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
                            <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>User ID</label>
                            <input type="text" name="userID" class="form-control <?php echo (!empty($userID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $userID; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $userID_err; ?></span>
                        </div>
                        <input type="hidden" name="stockID" value="<?php echo $stockID; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>