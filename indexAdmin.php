<?php
session_start();
if (!isset($_SESSION['adminID'])) {
    header("Location: logoutAdmin.php");
}
?>
<html lang="en">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 700px;
            margin: 0 auto;
        }

        table tr td:last-child {
            width: 120px;
        }

        h5 {
            color: darkgreen;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Company Registered Details</h2>
                        <h5 class="pull-right"><?php echo "User ID: <small>" . $_SESSION['adminID'] . "</small>"; ?></h5>
                    </div>
                    <div class="mt-3 mb-3 clearfix">
                        <a href="logoutAdmin.php" class="btn btn-warning pull-right">Log Out</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT userID, firstName, lastName, companyName FROM companyuser";
                    if ($result = $pdo->query($sql)) {
                        if ($result->rowCount() > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>User ID</th>";
                            echo "<th>Manager Name</th>";
                            echo "<th>Company Name</th>";
                            echo "<th>Tools</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = $result->fetch()) {
                                echo "<tr>";
                                echo "<td>" . $row['userID'] . "</td>";
                                echo "<td>" . $row['firstName'] . " " . $row['lastName'] . "</td>";
                                echo "<td>" . $row['companyName'] . "</td>";
                                echo "<td>";
                                //echo '<a href="read.php?id=' . $row['userID'] . '" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                //echo '<a href="update.php?id=' . $row['userID'] . '" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="deleteCompany.php?id=' . $row['userID'] . '" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    unset($pdo);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>