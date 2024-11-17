<?php
session_start();
require "connection.php";
$user = $_SESSION['user_id'];
if(isset($_SESSION['user_id'])){    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Details of claimed items</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <script>
        function delete_claim() {
            var confirmDelete = confirm('Are you sure to delete this?\nThis action cannot be undone!');

            if (confirmDelete) {
                // User confirmed deletion
                // alert('Claim deletion successful.');
                return true;
            } else {
                // User canceled deletion
                // alert('Claim deletion cancelled.');
                return false;

            }
        }
    </script>
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
                                <a href="#" class="nav-link horizontal-nav-left-menu"><i
                                        class="mdi mdi-format-list-bulleted"></i></a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                                    id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-bell mx-0"></i>
                                    <?php
                                    $sql = "SELECT * FROM notification n
                                    join all_items a ON n.ID = a.ID
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
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                    aria-labelledby="notificationDropdown">
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
                                    $stmt->close(); // Close the prepared statement
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
                                        <input type="search" class="form-control text-dark " placeholder="Search"
                                            aria-label="search" aria-describedby="search" name="search">
                                    </form>
                                </div>
                            </li>
                        </ul>
                        <ul class="navbar-nav navbar-nav-right">

                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    id="profileDropdown">
                                    <span
                                        class="nav-profile-name"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?></span>
                                    <span class="online-status"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                                    aria-labelledby="profileDropdown">
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
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                            type="button" data-toggle="horizontal-menu-toggle">
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
                            <a href="#" class="nav-link">
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


                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Claimed items</h4>

                                <div class="table-responsive">
                                    <?php
                                    // shows claim that have 
                                    // doesn;t show items that have been collected or returned after being claimed and collected
                                    // $sql = "SELECT uc.*
                                    // FROM user_claim uc
                                    // LEFT JOIN collected c ON uc.ItemID = c.ItemID
                                    // WHERE uc.UID = $user
                                    // AND uc.ItemID = c.ItemID
                                    // AND c.returned = 1
                                    // AND c.UID IS NULL
                                    // ";


// $sql = "SELECT uc.*
// FROM user_claim uc
// LEFT JOIN collected c ON uc.ItemID = c.ItemID
// WHERE uc.UID = $user
// AND uc.ItemID = c.ItemID
// // AND c.ItemID IS NULL;";
//                                     $sql="SELECT uc.*
//                                     FROM user_claim uc
//                                     LEFT JOIN collected c ON uc.ItemID = c.ItemID AND c.UID = $user
//                                     WHERE uc.UID = $user
//                                     AND (c.ItemID IS NULL OR (c.returned = 0 AND c.UID = $user))";
// if not collected then show claim
                                    $sql = "SELECT uc.*,a.image from user_claim uc left join all_items a on uc.ItemID=a.ID where uc.UID=$user AND a.collected=0";
                                    // $sql = "SELECT uc.*,a.image from user_claim uc left join all_items a on uc.ItemID=a.ID where uc.UID=$user";
                                    
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if (!$result) {
                                        die("Query failed: " . $stmt->error);
                                    }
                                    if (mysqli_num_rows($result) > 0) {
                                    ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Image</th>
                                                <th>Date found</th>
                                                <th>Date claimed</th>
                                                <!-- <th>Code</th> -->
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 1;
                                                // Process the fetched data
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<tr>';
                                                    echo '<td>' . $count++ . '</td>';
                                                    echo '<td>' . $row['item'] . '</td>';
                                                    echo '<td>' . $row['description'] . '</td>';
                                                    $img = $row['image'];
                                                    $uploadDir = "../images/";
                                                    $targetPath = $uploadDir . basename($img);
                                                    echo '<td><img src="' . $targetPath . '" alt="' . $img . '" style="width:100px; height:100px; border-radius:0;"/></td>';
                                                    echo '<td>' . $row['date_found'] . '</td>';
                                                    echo '<td>' . $row['date_claimed'] . '</td>';
                                                    // echo '<td>' . $row['code'] . '</td>';
                                                    echo '<td><a onclick="return delete_claim()" class="text-danger text-decoration-none" href="delete_item.php?SN=' . $row['sn'] . '">Delete</a></td>';
                                                    echo '</tr>';
                                                }
                                            ?>

                                        </tbody>
                                        <?php
                                        } else {
                                            echo  "No Data Found";
                                        } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
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
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
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
$stmt->close(); // Close the prepared statement
mysqli_close($conn); // Close the database connection
} else {
    header("location:login.php");
}
?>
