<?php
session_start();

require "connection.php";
if(isset($_SESSION['admin'])){    

$sql = "select * from register, all_items, item_lost, collected,user_claim";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $stmt->error);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>report</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <script>
        function delete_item(item) {
            var confirmDelete = confirm('Are you sure you want to delete the item?\nThis action cannot be undone!');

            if (confirmDelete) {
                // User confirmed deletion
                window.location.href = 'delete.php?ID=' + item;
            } else {
                // User canceled deletion
                alert('Item deletion canceled.');
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
                        <!-- Navbar left menu items -->
                        <ul class="navbar-nav navbar-nav-left">
                            <li class="nav-item ms-0 me-5 d-lg-flex d-none">
                                <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
                            </li>
                            <li class="nav-item nav-search d-none d-lg-block ms-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="search"><i class="mdi mdi-magnify"></i></span>
                                    </div>
                                    <form method="get" action="search.php">
                                        <input type="search" class="form-control text-dark" placeholder="Search" aria-label="search" aria-describedby="search" name="search">
                                    </form>
                                </div>
                            </li>
                        </ul>
                        <!-- Navbar brand and profile dropdown -->
                        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                            
                        </div>
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                    <span class="nav-profile-name">ADMIN</span>
                                    <span class="online-status"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                    <!-- <a class="dropdown-item">
                                        <i class="mdi mdi-settings text-primary"></i>
                                        Settings
                                    </a> -->
                                    <a class="dropdown-item" href="logout.php">
                                        <i class="mdi mdi-logout text-primary" ></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <!-- Navbar toggle button for mobile -->
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
                            <span class="mdi mdi-menu"></span>
                        </button>
                    </div>
                </div>
            </nav>
            <!-- Bottom navbar -->
            <nav class="bottom-navbar">
                <div class="container">
                    <ul class="nav page-navigation">
                        <!-- Navigation items -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="mdi mdi-file-document-box menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="mdi mdi-table menu-icon"></i>
                                <span class="menu-title">All items</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="report_collected.php" class="nav-link">
                                <i class="mdi mdi-dropbox menu-icon"></i>
                                <span class="menu-title">Item Collected</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="add_item.php" class="nav-link">
                                <i class="mdi mdi-database-plus menu-icon"></i>
                                <span class="menu-title">Add item</span>
                                <i class="menu-arrow"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="mdi mdi-finance menu-icon"></i>
                                <span class="menu-title">Reports</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="submenu">
                                <ul>
                                    <li class="nav-item"><a class="nav-link" href="report_lost.php">Lost Report</a></li>
                                    <li class="nav-item"><a class="nav-link" href="report_claimed.php">Claimed Report</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="report_users.php" class="nav-link">
                                <i class="mdi mdi-account-multiple menu-icon"></i>
                                <span class="menu-title">User Report</span>
                                <i class="menu-arrow"></i>
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
                                <h4 class="card-title">report</h4>
                                <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-info">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Item</th>
                                                    <th>Description</th>
                                                    <th colspan=2>Lost report</th>
                                                    <th colspan=2>Found</th>
                                                    <th>Image</th>  
                                                    <th colspan=3>Action</th>
                                                    <th colspan=2>Status</th>

                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>By</th>
                                                    <th>Date</th>
                                                    <th>Date</th>
                                                    <th>Location</th>
                                                    <th></th>
                                                    <th>Notify</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                    <th></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                <td>1</td>
                                                <td>Bottle</td>
                                                <td>Black bottle</td>
                                                <td>ram</td>
                                                <td>2024-05-01</td>
                                                <td>2024-05-02</td>
                                                <td>class 105</td>
                                                <td>iamge</td>
                                                <td>notified</td>
                                                <td>edit</td>
                                                <td>delete</td>
                                                <td>(claimed)</td>
                                                </tr>
                                                <tr>
                                                <td>2</td>
                                                <td>Keys</td>
                                                <td>Black keys</td>
                                                <td>sita</td>
                                                <td>2024-05-01</td>
                                                <td>2024-05-02</td>
                                                <td>class 105</td>
                                                <td>iamge</td>
                                                <td>notified</td>
                                                <td>edit</td>
                                                <td>delete</td>
                                                <td>(claimed)</td>
                                                </tr>
                                            </tbody>
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

}else{
    header("location:../user/login.php");
  }
?>
