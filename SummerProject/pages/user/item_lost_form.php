<?php
session_start();
// include 'itemlostClass.php';
$user = $_SESSION['user_id'];
// echo $username;
require "connection.php";
require_once("../includes/classes/FormSanitizer.php");
if(isset($_SESSION['user_id'])){    

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Item lost form</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <script>
        function delete_report() {
    var confirmDelete = confirm('Are you sure to delete the report?\nThis action cannot be undone!');

    if (confirmDelete) {
        // User confirmed deletion
        // window.location.href = 'delete_item.php';
        // alert("Report deleted successfully!");
        return true;
    } else {
        // User canceled deletion
        alert('Report deletion canceled.');
        // Optionally, you can remove the redirection here if you want
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
                                        
                                        // $row = mysqli_fetch_assoc($result);
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
                                    <span class="nav-profile-name"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?></span>
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
                            <a href="#" class="nav-link">
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
                                <h4 class="card-title">Information of lost item</h4>
                                <form class="forms-sample" method="post" action="" enctype="multipart/form-data" onsubmit="validateForm()">
                                <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">Code:</label>
                                        <div class="col-sm-9">

                                        <?php   date_default_timezone_set('Asia/Kathmandu');
                                                                        $current_date = date('Y-m-d h:i:s A');
                                                                        $current_timestamp = strtotime($current_date);
                                                                        mt_srand($current_timestamp);
                                                                        $code = mt_rand(1000, 9999);
                                                                        // $code = uniqid();

                                        ?>
                                                                        
                                                                    
                                                                    </td>
                                            <input type="text" class="form-control" id="code" name="code"
                                                required name="item_name"readonly value="<?php echo $code.' [This code must be used while claiming the item.]'?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">Item name:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="exampleInputUsername2"
                                                placeholder="BOTTLE" required name="item_name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">Description (optional): </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="exampleInputUsername2"
                                                placeholder="BLACK 1 LITRE BOTTLE" name="description">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">Image (optional): </label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" id="image"
                                                name="image">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">Date lost (optional): </label>
                                        <div class="col-sm-9">
                                            <input type="datetime-local" class="form-control" id="date"
                                                name="date_lost">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="exampleInputUsername2"
                                            class="col-sm-3 col-form-label">Possible location (optional): </label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="exampleInputUsername2"
                                                name="location">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2" name="submit">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- table  -->
                    <?php
                        $sql = "SELECT * FROM item_lost WHERE `UID` = $user order by Lost_ID desc ";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if (!$result) {
                            die("Query failed: " . $stmt->error);
                        }
                        
                        if (mysqli_num_rows($result) > 0) {

                    ?>      
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="here">All reported items</h4>

                                <div class="table-responsive" >
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Code</th>
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Date lost</th>
                                                <th>Possible location</th>
                                                <th>Image</th>
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
                                                    echo '<td>' . $row['Code'] . '</td>';
                                                    echo '<td>' . $row['Item'] . '</td>';
                                                    echo '<td>' . $row['Description'] . '</td>';
                                                    echo '<td>' . $row['Date'] . '</td>';
                                                    echo '<td>' . $row['Location'] . '</td>';
                                                    $img = $row['Image'];
                                                    $uploadDir = "lost_images/";
                                                    $targetPath = $uploadDir . basename($img);
                                                    echo '<td><img style="width:100px; height:100px; border-radius:0;" src="' . $targetPath . '" alt="' . $img . '"></td>';
                                                    echo '<td><a onclick=" return delete_report()" class="text-decoration-none text-danger" href="delete_item.php?Lost_ID=' . $row['Lost_ID'] . '">Delete</a></td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <?php
                                                }
                                                // else {
                                                //     echo  "<h1>No Items Claimed</h1>";
                                                // }
                                                $stmt->close(); // Close the prepared statement
                                                mysqli_close($conn); // Close the database connection
                                                ?>
                                                
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

                            var itemInput=document.getElementById("item_name");
                            var letters = /^[A-Za-z]+$/;
                            if (!itemInput.match(letters)){
                                alert("Item name must contain only alphabetic characters");
                                return false;
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
</body>

</html>

<?php
require_once("../includes/classes/FormSanitizer.php");

//  session_start();

if (isset($_POST['submit'])) {
    require "connection.php";

    // Validate and sanitize user inputs
    $UID = $_SESSION['user_id'];
    // echo $UID;
    $item = FormSanitizer::sanitizeFormName($_POST["item_name"]);
    $description = FormSanitizer::sanitizeFormDescription($_POST['description']);
    // $contact =FormSanitizer::sanitizeFormForTags($_POST['contact']);
    $location = FormSanitizer::sanitizeFormForTags($_POST['location']);
    $date = FormSanitizer::sanitizeFormForTags($_POST['date_lost']);
    $code = FormSanitizer::sanitizeFormForTags($_POST['code']);


    $image = $_FILES['image']['name'];

    $uploadDirectory = "lost_images/";
    $targetPath = $uploadDirectory . $image;

    move_uploaded_file($_FILES['image']['tmp_name'], $targetPath);


    // Insert data into database
    $stmt = $conn->prepare("INSERT INTO `item_lost`(`UID`, `Item`, `Description`, `Date`, `Location`, `Image`, `Code`) VALUES ( ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isssssi", $UID, $item, $description, $date, $location, $image, $code);

    if ($stmt->execute()) {
        echo "<script> 
                window.location.href = 'item_lost_form.php';
        </script>";
        // header("location: first.php?lt=true");
        exit(); // Make sure to exit after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
} else {
    header("location:login.php");
}
?>
