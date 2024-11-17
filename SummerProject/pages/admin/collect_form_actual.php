<?php
session_start();

// $user = $_SESSION['user_id'];
require "connection.php";
if(isset($_SESSION['admin'])){    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Item collection</title>
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="shortcut icon" href="../../images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="horizontal-menu">
            <nav class="navbar top-navbar col-lg-12 col-12 p-0">
                <div class="container-fluid">
                    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
                        <ul class="navbar-nav navbar-nav-left">
                            <li class="nav-item ms-0 me-5 d-lg-flex d-none">
                                <a href="#" class="nav-link horizontal-nav-left-menu">
                                    <i class="mdi mdi-format-list-bulleted"></i>
                                </a>
                            </li>
                            <li class="nav-item nav-search d-none d-lg-block ms-3">
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
                                    <li class="nav-item">
                                        <a class="nav-link" href="report_lost.php">Lost Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="">Claimed Report</a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" href="">Found Report</a>
                                    </li> -->
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

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                if (isset($_GET['ID'])) {
                                    $ID = $_GET['ID'];
                                } else {
                                    echo "Item ID not provided in the URL.";
                                }
                                $sql = "SELECT a.ID, a.image,a.ID,a.location, a.date, uc.ItemID, uc.item, uc.description,uc.date_claimed,  r.fname, r.lname, r.UID, uc.date_found
                                FROM  user_claim uc 
                                JOIN all_items a ON uc.ItemID = a.ID
                                JOIN register r ON uc.UID = r.UID where uc.ItemID=?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $ID);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if (!$result) {
                                    die("Query failed: " . $stmt->error);
                                }
                                if (mysqli_num_rows($result) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $UID = $row["UID"];
                                        $img = $row['image'];
                                        $uploadDir = "../images/";
                                        $targetPath = $uploadDir . basename($img);
                                        $item=$row['item'];
                                        $description=$row['description'];
                                        $date_found=$row['date'];
                                        $fname=$row['fname'];
                                        $lname=$row['lname'];
                                        $date_claimed=$row['date_claimed'];
                                        $location=$row['location'];
                                        $ID=$row['ID'];
                                ?>
                                <h4 class="card-title">Claim item: <?php echo '<td>' . $ID . '</td>';?></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Image</th>
                                            <?php echo '<td><img  style="width:100px; height:100px; border-radius:0;" src="' . $targetPath . '" alt="' . $img . '"></td>'; ?>
                                        </tr>
                                        <tr>
                                            <th>Item</th>
                                            <?php echo '<td>' . $item . '</td>';?>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <?php echo '<td>' . $description . '</td>';   ?>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <?php echo '<td>' . $location . '</td>';?>
                                        </tr>
                                        <tr>
                                            <th>Date found</th>
                                            <?php echo '<td>' . $date_found . '</td>';?>
                                        </tr>
                                    </table>
                                    <br><br>
                                    <h4 class="card-title">Claimed by:</h4>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <form action="" method="post">
                                                <tr>
                                                    <th>Name</th>
                                                    <?php echo '<td>' . $fname.' '.$lname . '</td>';?>
                                                </tr>
                                                <tr>
                                                    <th>Date claimed</th>
                                                    <?php   echo '<td>' . $date_claimed . '</td>'; ?>
                                                </tr>
                                                <tr>
                                                    <th>Enter Code</th>
                                                    <td><input class="form-control form-control-lg border-light" type="text" name="code" td></td>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <td><input class="btn btn-inverse-success btn-fw" type="submit" name="check" value="Check"></td>
                                                </tr>
                                            </form>
                                        </table>
                                        <?php
                                        }} else {
                                            echo  "No Data Found";
                                        }
                                        $stmt->close();
                                        mysqli_close($conn);
                                        ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            
        </div>
    </div>

    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../vendors/select2/select2.min.js"></script>
    <script src="../../js/file-upload.js"></script>
    <script src="../../js/typeahead.js"></script>
    <script src="../../js/select2.js"></script>

</body>

</html>

<?php
if(isset($_POST['check']) && isset($_POST["code"])) {
    $conn = new mysqli("localhost", "root", "", "LFSystem");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // to check code
    $sql = "SELECT Code FROM item_lost where code=?;";
    $stmt = $conn->prepare($sql);
    $code = $_POST["code"];
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die("Query failed: " . $stmt->error);
    }
    if ($result->num_rows == 1) {
        echo "<script> 
        window.location.href = 'collected.php?ID=' + $ID;
        </script>";
        exit();
    } else {
        echo "<script>alert('Wrong code');</script>";
    }
    $stmt->close();
    $conn->close();

}

}else{
    header("location:../user/login.php");
  }
?>