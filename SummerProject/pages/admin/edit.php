<?php 
session_start();
require "connection.php";
require_once("../includes/classes/FormSanitizer.php");
if(isset($_SESSION['admin'])){    

$ID = FormSanitizer::sanitizeFormForTags($_GET["ID"]);
// $sql = "SELECT * FROM `all_items` WHERE ID='{$ID}' ";
// $result = mysqli_query($conn, $sql) or die("Query Failed");
$sql = "SELECT * FROM `all_items`  WHERE ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    die("Query failed: " . $stmt->error);
}
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $img = $row['image']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit item details</title>
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
                        <ul class="navbar-nav navbar-nav-right">
                            <li class="nav-item nav-profile dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                                    <span class="nav-profile-name">ADMIN</span>
                                    <span class="online-status"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                    <a class="dropdown-item" href="logout.php">
                                        <i class="mdi mdi-logout text-primary" ></i>
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
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit information</h4>
                                <form class="forms-sample" action="update.php?ID=<?php echo $ID;?>" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Item</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="item" name="item" value="<?php echo $row['item'];?>" required><br><br>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="description" name="description" value="<?php echo $row['description'];?>"><br><br>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Date found</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="datetime-local" id="date" name="date" value="<?php echo $row['date'];?>"><br><br>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Location found</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" id="location" name="location" value="<?php echo $row['location'];?>"><br><br>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Image</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="image" id="image" ><br><br>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <img src="../images/<?php echo $img ?>" alt="No Image Found" class="form-control img-fluid w-50">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-success me-2">Submit</button>
                                    <button type="reset" class="btn btn btn-outline-danger">Cancel</button>
                                </form>
                                <br>
                                <a href="display_items.php" class="btn btn-outline-info me-2 float-end">Back</a>

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
    }
}else{
    echo  "No Data Found";
}
?>
<script>
// validate form
function validateForm() {
    var fileInput = document.getElementById("image");
    if (fileInput.value) {
        // Get the selected file
        var file = fileInput.files[0];
        // Check if the file is an image
        if (!file || !file.type.startsWith("image/")) {
            alert("Invalid file type. Please choose an image file");
            return false;
        }
    }
    return true; // Form submission will proceed if the image is valid
}


    // Get the input element
    var entryDateInput = document.getElementById('date');

    // Add an event listener for input change
    entryDateInput.addEventListener('input', function () {
        // Get the value of the input
        var enteredDateTime = new Date(this.value);
        var currentDateTime = new Date();

        // Compare the entered date with the current date
        if (enteredDateTime > currentDateTime) {
            // If entered date is in the future, show an alert and clear the input
            alert("Entry date cannot exceed the current date and time.");
            this.value = ''; // Clear the input
        }
    });
</script>

<?php
}else{
    header("location:../user/login.php");
  }
?>
