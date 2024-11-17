<?php
session_start();
require "connection.php";
// require "dashboard.php";
require_once("../includes/classes/FormSanitizer.php");
if(isset($_SESSION['admin'])){    


if (isset($_GET['search'])) {
    // validation of search
      $search = FormSanitizer::sanitizeFormName($_GET['search']);                                
      $search = '%' . $search . '%';
      // $sql = "SELECT * FROM all_items WHERE item LIKE ? OR description LIKE ?";
      $sql = "SELECT * FROM all_items WHERE (item LIKE ? OR description LIKE ?) AND collected=?";
      $collected=0;
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi", $search, $search, $collected);
      //                       $sql = "SELECT a.* FROM all_items a
      //                       LEFT JOIN collected c ON a.ID = c.ItemID
      //                       WHERE (a.item LIKE ? OR a.description LIKE ?) 
      //                       AND (a.collected = ? OR c.returned = ?)";
      //                       $stmt = $conn->prepare($sql);
      //                       $collected=0;
      //                       $returned=1;
      //                       $stmt->bind_param("ssii", $search, $search,$collected,$returned);
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
  <title>Search result</title>
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
                alert('Account deletion canceled.');
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
                <a href="#" class="nav-link horizontal-nav-left-menu"><i class="mdi mdi-format-list-bulleted"></i></a>
              </li>
              <li class="nav-item nav-search d-none d-lg-block ms-3">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="search">
                      <i class="mdi mdi-magnify"></i>
                    </span>
                  </div>
                  <form method="get" action="search.php">
                  <input type="search" class="form-control text-dark " placeholder="Search" aria-label="search"
                    aria-describedby="search" name="search">
                  </form>
                </div>
              </li>
            </ul>
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
                  <a class="dropdown-item"  href="logout.php">
                    <i class="mdi mdi-logout text-primary"></i>
                    Logout
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
              data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
      <nav class="bottom-navbar">
        <div class="container">
          <ul class="nav page-navigation">
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <i class="mdi mdi-file-document-box menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="display_items.php" class="nav-link">
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
                  <!-- <li class="nav-item"><a class="nav-link" href="">Found Report</a></li> -->
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a href="report_users.php" class="nav-link">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">User Details</span>
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
                <h4 class="card-title">All items</h4>

                <div class="table-responsive">
                  <?php
if (mysqli_num_rows($result) > 0) {
?>
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>SN</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Date found</th>
                        <th>Found location</th>
                        <th>Image</th>
                        <th>Edit</th>
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
                                        echo '<td>' . $row['date'] . '</td>';
                                        echo '<td>' . $row['location'] . '</td>';
                                        $img = $row['image'];
                                        $uploadDir = "../images/";
                                        $targetPath = $uploadDir . basename($img);
                                        echo '<td><img " style="width:100px; height:100px; border-radius:0;" src="' . $targetPath . '" alt="' . $img . '"></td>';
                                        echo '<td><a class="text-decoration-none" href="edit.php?ID=' . $row['ID'] . '">Edit</a></td>';
                                        echo '<td><button class="btn btn-inverse-danger btn-fw" onclick="delete_item(' . $row['ID'] . ')">Delete</button></td>';        
                                        echo '</tr>';
                                    }
                                ?>
                    </tbody>
                  <?php
                  } else {
                    echo  "No Data Found";
                }?>
                
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
    
    $stmt->close();  // Close the prepared statement
    mysqli_close($conn); 
             }
             }else{
              header("location:../user/login.php");
            }
    ?>