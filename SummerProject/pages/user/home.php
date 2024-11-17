<?php
session_start();
require_once("../includes/classes/FormSanitizer.php");
include "connection.php";

if (isset($_SESSION['user_id'])) {
    $UID = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Homepage</title>
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
                                    // Display notifications count
                                    $sql = "SELECT * FROM notification WHERE UID = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("i", $_SESSION['user_id']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if (!$result) {
                                        die("Query failed: " . $stmt->error);
                                    }

                                    $row_count = $result->num_rows;
                                    echo '<span class="count bg-info">'.$row_count.'</span>';
                                    ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                    <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                                    <?php
                                    if ($row_count > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            if ($row['UID'] == $_SESSION['user_id']) {
                                                echo '
                                                <a class="dropdown-item preview-item" href="claim.php?ID=' .$row['ID'].'&NID='.$row['NID'].'">
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
                                                </div>
                                            </a>';
                                    }
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
                                    <span class="nav-profile-name"><?php echo $_SESSION['fname']." ". $_SESSION['lname']; ?></span>
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
                            <a class="nav-link" href="#">
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
                    <div class="row">
                        <?php
                            $total_pages_query = 'SELECT COUNT(*) FROM `all_items` as a WHERE collected = 0 AND item IN (SELECT Item FROM `item_lost` WHERE UID = ?)  or a.description IN(select l.Description from `item_lost`as l where UID=?)';
                            $stmt = $conn->prepare($total_pages_query);
                            $stmt->bind_param('ii', $UID,$UID);
                            $stmt->execute();
                            $stmt->bind_result($total_pages);
                            $stmt->fetch();
                            $stmt->close();
                            
                            // Check if the page number is specified and check if it's a number, if not return the default page number which is 1.
                            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                            
                            // Number of results to show on each page.
                            $num_results_on_page = 6;
                            
                            // Calculate the page to get the results we need from our table.
                            $calc_page = ($page - 1) * $num_results_on_page;
                            
                            // Query to get the items for the current page
                            $items_query = 'SELECT * FROM `all_items` as a WHERE collected = ? AND a.item IN (SELECT Item FROM `item_lost` WHERE UID = ?)  or a.description IN(select l.Description from `item_lost`as l where UID=?) ORDER BY ID DESC LIMIT ?, ?';
                            $stmt = $conn->prepare($items_query);
                            $collected = 0;
                            $stmt->bind_param('iiiii', $collected, $UID, $UID, $calc_page, $num_results_on_page);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $img = $row['image'];
                                    $uploadDir = "../images/";
                                    $targetPath = $uploadDir . basename($img);
                        ?>
                        <div class="col-md-4 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><?php echo $row['item']; ?></h4>
                                    <img src="<?php echo $targetPath; ?>" class="card-img-top figure-img img-fluid rounded img-thumbnail" alt="No image found" style="width: 300px; height: 200px;">
                                    <p class="card-description">Description: <?php echo $row['description']; ?></p>
                                    <p class="card-description">Location: <?php echo $row['location']; ?></p>
                                    <p class="card-description">Date: <?php echo $row['date']; ?></p>
                                    <div class="template-demo">
                                        <a href="claim.php?ID=<?php echo $row['ID']; ?>" class="btn btn-outline-dark btn-lg btn-block text-decoration-none">Claim</a>
                                    </div>
                                </div>
                            </div>
                                </div>
                                    <?php
                                            }
                                        } else {
                                            echo "<div class='col grid-margin'> No Data Found</div>";
                                        }
                                        $stmt->close(); // Close the prepared statement
                                        $conn->close(); // Close the database connection
                                    ?>
                                </div>
                        </div>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
                                <?php if ($page > 1): ?>
                                    <li class="page-item"><a class="page-link" href="home.php?page=<?php echo $page - 1 ?>">Prev</a></li>
                                <?php endif; ?>

                                <?php if ($page > 3): ?>
                                    <li class="page-item"><a class="page-link" href="home.php?page=1">1</a></li>
                                    <li class="page-item"><span class="dots">...</span></li>
                                <?php endif; ?>

                                <?php for ($i = max(1, $page - 2); $i <= min($page + 2, ceil($total_pages / $num_results_on_page)); $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="home.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor; ?>

                                <?php if ($page < ceil($total_pages / $num_results_on_page) - 2): ?>
                                    <li class="page-item"><span class="dots">...</span></li>
                                <?php endif; ?>

                                <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
                                    <li class="page-item"><a class="page-link" href="home.php?page=<?php echo $page + 1 ?>">Next</a></li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
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
} else {
    header("location:login.php");
    exit();
}
?>
