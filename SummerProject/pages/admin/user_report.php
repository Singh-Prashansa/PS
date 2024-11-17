<?php
session_start();

require "connection.php";

if(isset($_SESSION['admin'])) {    
    $sql = "SELECT * FROM `register`";
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
        <title>List of collected items</title>
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
                    window.location.href = 'delete.php?CID=' + item;
                } else {
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
                                <a class="nav-link" href="index.php">
                                    <i class="mdi mdi-file-document-box menu-icon"></i>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="display_items.php" class="nav-link">
                                    <i class="mdi mdi-table menu-icon"></i>
                                    <span class="menu-title">All items</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="report_collected.php" class="nav-link">
                                    <i class="mdi mdi-dropbox menu-icon"></i>
                                    <span class="menu-title">Item Collected</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="add_item.php" class="nav-link">
                                    <i class="mdi mdi-database-plus menu-icon"></i>
                                    <span class="menu-title">Add item</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="mdi mdi-finance menu-icon"></i>
                                    <span class="menu-title">Reports</span>
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
                                <form method="post">
                                    <div class="form-group row" style="padding: 20px;">
                                        <label for="from">Select User</label>
                                        <div class="row">
                                            <div class="col-12 col-md-8">
                                            <select name="user" id="user" class="w-100 h-100">
                                                <option value="">Select user</option>
                                                <?php
                                                while ($row = $result->fetch_assoc()) {
                                                    $fname = $row['fname'];
                                                    $lname = $row['lname'];
                                                    $userId = $row['UID'];
                                                    echo "<option value='$userId'>$fname $lname</option>";
                                                }
                                                ?>
                                            </select>
                                            </div>
                                            <div class="col-4">
                                            <input type="submit" name="submit" class="btn btn-success">
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <div class="card-body">
                                    <div class="row">
                                        <h4 class="card-title col">All collected items</h4>
                                        <input type="button" id="export" value="Export" class="btn btn-info col col-lg-2" />
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <?php
                                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
                                            $UID = $_POST['user'];
                                            $sql1 = "SELECT * FROM `collected` WHERE UID = ? AND returned=0 ORDER BY CID desc";
                                            $stmt1 = $conn->prepare($sql1);
                                            $stmt1->bind_param("i", $UID);
                                            $stmt1->execute();
                                            $result1 = $stmt1->get_result();

                                            if (mysqli_num_rows($result1) > 0) {
                                                echo '<table class="table table-hover" id="pdf">';
                                                echo '<thead class="bg-dark text-white">';
                                                echo '<tr>';
                                                echo '<th>SN</th>';
                                                echo '<th>Collected ID</th>';
                                                echo '<th>Item</th>';
                                                echo '<th>Collected by</th>';
                                                echo '<th>Name</th>';
                                                echo '<th>Date found</th>';
                                                echo '<th>Found location</th>';
                                                echo '<th>Image</th>';
                                                echo '<th>Date collected</th>';
                                                echo '<th>Return</th>';
                                                echo '<th>Delete</th>';
                                                echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';

                                                $count = 1;
                                                while ($row1 = $result1->fetch_assoc()) {
                                                    echo '<tr>';
                                                    echo '<td>' . $count++ . '</td>';
                                                    echo '<td>' . $row1['CID'] . '</td>';
                                                    echo '<td>' . $row1['item'] . '</td>';
                                                    echo '<td>' . $row1['collected_by'] . '</td>';
                                                    echo '<td>' . $row1['fname'] . ' ' . $row1['lname'] . '</td>';
                                                    echo '<td>' . $row1['date_found'] . '</td>';
                                                    echo '<td>' . $row1['location'] . '</td>';
                                                    $img = $row1['image'];
                                                    $uploadDir = "../images/";
                                                    $targetPath = $uploadDir . basename($img);
                                                    echo '<td><img style="width:100px; height:100px; border-radius:0;" src="' . $targetPath . '" alt="' . $img . '"></td>';
                                                    echo '<td>' . $row1['date_collected'] . '</td>';
                                                    echo '<td><a class="text-primary text-decoration-none" href="return.php?ItemID=' . $row1['ItemID'] . '&UID=' . $row1['UID'] . '">Return</a></td>';
                                                    echo '<td><button class="btn btn-inverse-danger btn-fw" onclick="delete_item(' . $row1['CID'] . ')">Delete</button></td>';
                                                    echo '</tr>';
                                                }
                                                echo '</tbody>';
                                                echo '</table>';
                                            } else {
                                                echo "<p>No data found for the selected user.</p>";
                                            }
                                        }
                                        ?>
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

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
        <script type="text/javascript">
            // Export table to PDF
            $("body").on("click", "#export", function () {
                html2canvas($('#pdf')[0], {
                    onrendered: function (canvas) {
                        var dataUrl = canvas.toDataURL();
                        var data = {
                            content: [{
                                image: dataUrl,
                                width: 600
                            }]
                        };
                        pdfMake.createPdf(data).download("collected_items.pdf");
                    }
                });
            });
        </script>
    </body>

    </html>

    <?php
    $stmt->close();  // Close the prepared statement
    mysqli_close($conn);  // Close the database connection
} else {
    header("location:../user/login.php");
}
?>
