<?php
session_start();
$user = $_SESSION['user_id'];
// echo $username;
require "connection.php";
if(isset($_SESSION['user_id'])){    

// after clicking the notification then  it will be seen that the notification is read by user so the code deletes it
if (isset($_GET['NID'])) {
    // Sanitize the input to prevent SQL injection
    $notification_id = filter_var($_GET['NID'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare the SQL query to delete the notification with the specified ID
    $sql1 = "DELETE FROM notification WHERE NID = ?";

    // Prepare the statement
    $stmt1 = $conn->prepare($sql1);

    // Bind the notification_id parameter
    $stmt1->bind_param("i", $notification_id);

    $stmt1->execute();

    $stmt1->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Claim item</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    
    
</head>

<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_horizontal-navbar.html -->
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container-fluid">
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                        <ul class="navbar-nav navbar-nav-left">
                            <li class="nav-item ms-0 me-5 d-lg-flex d-none">
                                <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-bell mx-0"></i>
                                    <?php
                                    $sql = "SELECT * FROM notification n
                                            JOIN all_items a ON n.ID = a.ID
                                            WHERE UID = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $_SESSION['user_id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if (!$result) {
                                        die("Query failed: " . $stmt->error);
                                    }

                                    $row = mysqli_num_rows($result);

                                    echo '<span class="count bg-info">' . $row . '</span>';
                                    ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                                    <?php
                                    if ($row > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row['UID'] == $_SESSION['user_id']) {
                                                echo '
                                                <a class="dropdown-item preview-item" href="claim.php?ID=' . $row['ID'] . '&NID=' . $row['NID'] . '">
                                                    <div class="preview-thumbnail">
                                                        <div class="preview-icon bg-warning">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline mx-0"></i>
                                                        </div>
                                                    </div>
                                                    <div class="preview-item-content">
                                                        <h6 class="preview-subject font-weight-normal">New item found</h6>
                                                        <p class="font-weight-light small-text mb-0 text-muted">
                                                            Is this your belonging?
                                                        </p>
                                                    </div>
                                                </a>
                                                ';
                                            }
                                        }
                                    } else {
                                        echo '<a class="dropdown-item preview-item">
                                            <div class="preview-thumbnail">
                                                <div class="preview-icon bg-danger">
                                                    <i class="mdi mdi-checkbox-blank-circle-outline mx-0"></i>
                                                </div>
                                            </div>
                                            <div class="preview-item-content">
                                                <h6 class="preview-subject font-weight-normal">No new notification</h6>
                                                <p class="font-weight-light small-text mb-0 text-muted">
                                                </p>
                                            </div>
                                        </a>';
                                    }
                                    $stmt->close();
                                    ?>
                                </div>
                            </li>
                            <li class="nav-item nav-search d-none d-lg-block ms-3 border border-2 rounded">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="search">
                                            <i class="mdi mdi-magnify"></i>
                                        </span>
                                    </div>
                                    <form method="get" action="search.php">
                                        <input type="search" class="form-control text-dark" placeholder="Search" aria-label="search" aria-describedby="search" name="search">
                                    </form>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                    <span class="nav-profile-name"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?></span>
                                    <span class="online-status"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="setting.php">
                                        <i class="mdi mdi-settings text-primary"></i>
                                        Settings
                                    </a>
                                    <a class="dropdown-item" href="logout.php">
                                        <i class="mdi mdi-logout text-primary"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </div>
                </div>
            </nav>
            <nav class="bottom-navbar">
                <div class="container">
                    <ul class="nav page-navigation">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                                <i class="mdi mdi-home menu-icon"></i>
                                <span class="menu-title">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="all_item.php" class="nav-link">
                                <i class="mdi mdi-table menu-icon"></i>
                                <span class="menu-title">All items</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="item_lost_form.php" class="nav-link">
                                <i class="mdi mdi-border-color menu-icon"></i>
                                <span class="menu-title">Report lost item</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="claimed.php" class="nav-link">
                                <i class="mdi mdi-book menu-icon"></i>
                                <span class="menu-title">Claimed items</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="item_collected.php" class="nav-link">
                                <i class="mdi mdi-dropbox menu-icon"></i>
                                <span class="menu-title">Item Collected</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Claimed item</h4>
                                <?php
                                // set session of user
                                if (isset($_GET['ID'])) {
                                    $ID =filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
                                    
                                    // echo "Item ID: " . $ID;
                                } else {
                                    echo "Item ID not provided in the URL.";
                                }
                                $sql = "SELECT * FROM `all_items`  WHERE ID=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $ID);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if (!$result) {
                                    die("Query failed: " . $stmt->error);
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    $count = 1;
                                    // Process the fetched data
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $img = $row['image'];
                                        $uploadDir = "../images/";
                                        $targetPath = $uploadDir . basename($img);
                                        $item = $row['item'];
                                        $description = $row['description'];
                                        $date_found = $row['date'];
                                ?>
                                        <div class="table-responsive">
                                            <table class="table ">
                                                <tr>
                                                    <th>Image</th>
                                                    <?php echo '<td><img  style="width:100px; height:100px; border-radius:0;" src="' . $targetPath . '" alt="' . $img . '"></td>'; ?>
                                                </tr>
                                                <tr>
                                                    <th>Item</th>
                                                    <?php echo '<td>' . $item . '</td>'; ?>
                                                </tr>
                                                <tr>
                                                    <th>Description</th>
                                                    <?php echo '<td>' . $description . '</td>';   ?>
                                                </tr>
                                                <tr>
                                                    <th>Location</th>
                                                    <?php echo '<td>' . $row['location'] . '</td>'; ?>
                                                </tr>
                                                <tr>
                                                    <th>Date</th>
                                                    <?php echo '<td>' . $date_found . '</td>'; ?>
                                                </tr>
                                            </table>
                                
                                        <br><br>
                                        <h4 class="card-title">Claimed by:</h4>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <form action="" method="post">
                                                    <tr>
                                                        <th>Name</th>
                                                        <?php echo '<td>' . $_SESSION['fname'] . " " . $_SESSION['lname'] . '</td>'; ?>
                                                    </tr>
                                                    <tr>
                                                        <th>Date claimed</th>
                                                        <td id="td"><?php   date_default_timezone_set('Asia/Kathmandu');
                                                                        $current_date = date('Y-m-d h:i:s A');
                                                                        echo $current_date; ?></td>
                                                    </tr>
                                                    <tr>
                                                    <th>Enter Code </th>
                                                    <td><input class="form-control form-control-lg border-light" type="text" name="code" td></td>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <td><input class="btn btn-outline-info btn-fw" onclick="return checkFormCompletion()" type="submit" name="claim" value="Claim"></td>
                                                    </tr>
                                                </form>
                                            </table>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <!-- table  -->
                    <?php
                                    }
                                } else {
                                    echo  "No Data Found";
                                }
                                $stmt->close();  // Close the prepared statement
                                mysqli_close($conn);  // Close the database connection
                                ?>
                </div>
            
        </div>
        <!-- content-wrapper ends -->
        
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <!-- base:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></s>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="../../js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../vendors/select2/select2.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="../../js/file-upload.js"></script>
    <script src="../../js/typeahead.js"></script>
    <script src="../../js/select2.js"></script>
    <!-- End custom js for this page-->
</body>

</html>
<?php
if(isset($_POST['claim'])) {
    if(empty($_POST["code"])) {
        echo "<script>alert('Enter code')</script>";
    } else {

    $conn = new mysqli("localhost", "root", "", "LFSystem");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // attempts
    $max_attempts = 5;
    if (!isset($_SESSION['attempts'])) {
        $_SESSION['attempts'] = [];
    }
    
    // Check if the user has already made attempts for this item
    if (!isset($_SESSION['attempts'][$ID])) {
        $_SESSION['attempts'][$ID] = 0;
    }
    
    // Get the current number of attempts for the item
    $current_attempts = $_SESSION['attempts'][$ID];
    
    // Check if the user has exceeded max attempts
    if ($current_attempts >= $max_attempts) {
        echo "<script>alert('You have been denied the claim for this item due to too many failed attempts.');</script>";
        exit();
    }

    // Prepare SQL statement to check the code
    $sql = "SELECT Code FROM item_lost WHERE code=? AND UID=? AND Item like ?";
    $stmt = $conn->prepare($sql);
    $search = '%' . $item . '%';
    $code = $_POST["code"];
    $stmt->bind_param("sis", $code, $_SESSION['user_id'],$search);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die("Query failed: " . $stmt->error);
    }

    
    // If code is valid, proceed with claiming
    if ($result->num_rows == 1) {
        // Generate a random code
        $UID = $_SESSION['user_id'];
        $_SESSION['attempts'][$ID] = 0;
       // Generate a random code
        $current_timestamp = strtotime($current_date);
        mt_srand($current_timestamp);
        $claim_code = mt_rand(1000, 9999);

        // Insert data into database
        $stmt_claim = $conn->prepare("INSERT INTO `user_claim`(`UID`, `ItemID`, `item`, `description`, `date_claimed`, `date_found`) VALUES ( ?, ?, ?, ?, ?,?)");
        $stmt_claim->bind_param("iissss", $UID, $ID, $item, $description, $current_date, $date_found);

        if ($stmt_claim->execute()) {
            // Redirect after successful claim
            echo "<script>window.location.href = 'claimed.php';</script>";
            exit(); // Make sure to exit after redirection
        } else {
            echo "Error: " . $stmt_claim->error;
        }

        // Close the statement for claim
        $stmt_claim->close();
    } else {
        $_SESSION['attempts'][$ID]++;
        echo "<script>alert('Invalid code. You have " . ($max_attempts - $_SESSION['attempts'][$ID]) . " attempts left.');</script>";
    }

    // Close the statement and connection for code check
    $stmt->close();
    $conn->close();
}  
}

} else {
    header("location:login.php");
}
?>
