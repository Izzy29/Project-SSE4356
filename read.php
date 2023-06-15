<?php
// Check existence of id parameter before processing further

$stockID = $stockName = $category = $quantity = $userID = "";

if (isset($_GET["stockID"]) && !empty(trim($_GET["stockID"]))) {
    $stockID = $_GET["stockID"];
    // Include config file
    require_once "config.php";


    // Prepare a select statement
    $sql = "SELECT * FROM stock WHERE stockID = :stockID";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":stockID", $stockID);

        // Set parameters
        $param_id = trim($_GET["stockID"]);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Retrieve individual field value
                $stockID = $row["stockID"];
                $stockName = $row["stockName"];
                $category = $row["category"];
                $quantity = $row["quantity"];
                $userID = $row["userID"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
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
    echo $_GET["stockID"];
    //header("location: error.php");
    //exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Stock ID</label>
                        <p><b><?php echo $row["stockID"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Stock Name</label>
                        <p><b><?php echo $row["stockName"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <p><b><?php echo $row["category"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <p><b><?php echo $row["quantity"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>User ID</label>
                        <p><b><?php echo $row["userID"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>