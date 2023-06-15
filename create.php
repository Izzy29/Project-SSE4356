<?php
// Include config file
require_once "config.php";
session_start();
$userID = $_SESSION['userID'];

// Define variables and initialize with empty values
$stockID = $stockName = $category = $quantity = "";
$stockID = $stockName_err = $category_err = $quantity_err = $userID_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate stockID
    $input_stockID = trim($_POST["stockID"]);
    if (empty($input_stockID)) {
        $stockID_err = "Please enter a stockID.";
    } elseif (!ctype_digit($input_stockID)) {
        $name_err = "Please enter an integer value.";
    } else {
        $stockID = $input_stockID;
    }

    // Validate stockName
    $input_stockName = trim($_POST["stockName"]);
    if (empty($input_stockName)) {
        $stockName_err = "Please enter a stock name.";
    } elseif (!filter_var($input_stockName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid stock name.";
    } else {
        $stockName = $input_stockName;
    }

    // Validate category
    $input_category = trim($_POST["category"]);
    if (empty($input_category)) {
        // echo $input_category;
        $category_err = "Please enter a stock category.";
    } elseif (!filter_var($input_category, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $category_err = "Please enter a valid stock category.";
    } else {
        $category = $input_category;
    }

    // Validate quantity
    $input_quantity = trim($_POST["quantity"]);
    if (empty($input_quantity)) {

        $salary_err = "Please enter the stock quantity.";
    } else if ($input_category < 1) {
        $quantity_err = "Please enter a positive integer value." . $input_quantity;
    } else {
        $quantity = $input_quantity;
    }

    // Check input errors before inserting in database
    if (empty($stockID_err) && empty($stockName_err) && empty($category_err) && empty($quantity_err) && empty($userID_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO stock VALUES (:stockID, :stockName, :category, :quantity, :userID)";

        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_stockID = $stockID;
            $param_stockName = $stockName;
            $param_category = $category;
            $param_quantity = $quantity;
            $param_userID = $userID;

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":stockID", $param_stockID);
            $stmt->bindParam(":stockName", $param_stockName);
            $stmt->bindParam(":category", $param_category);
            $stmt->bindParam(":quantity", $param_quantity);
            $stmt->bindParam(":userID", $param_userID);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add stock record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>User ID</label>
                            <input type="text" name="userID" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $userID; ?>" readonly>
                            <span class="invalid-feedback"><?php echo $userID_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Stock ID</label>
                            <input type="text" name="stockID" class="form-control <?php echo (!empty($stockID_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stockID; ?>">
                            <span class="invalid-feedback"><?php echo $stockID_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Stock Name</label>
                            <input type="text" name="stockName" class="form-control <?php echo (!empty($stockName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $stockName; ?>">
                            <span class="invalid-feedback"><?php echo $stockName_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" id="categories" class="form-control">
                                <option value="All category">All category</option>
                                <option value="Food">Food</option>
                                <option value="Electronic">Electronic</option>
                                <option value="Beverages">Beverages</option>
                                <option value="Houshold">Household</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
                            <span class="invalid-feedback"><?php echo $quantity_err; ?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>