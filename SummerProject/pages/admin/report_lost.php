<?php
session_start();

require "connection.php";
if(isset($_SESSION['admin'])){    
  
  if (isset($_POST['srh-btn'])) {
    $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : null;
    $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : null;

    if (!empty($from_date) && !empty($to_date)) {
        // Convert dates to proper format if necessary
        $from_date = date('Y-m-d ', strtotime($from_date));
        $to_date = date('Y-m-d ', strtotime($to_date));

        $sql = "SELECT r.`fname`, r.`lname`, il.`Lost_ID`, il.`Item`, il.`Description`, il.`Location`, il.`Date`, il.`Image`
                FROM item_lost il
                JOIN register r ON il.`UID` = r.`UID`
                WHERE DATE(il.`Date`) BETWEEN ? AND ? order by Lost_ID desc" ;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $from_date, $to_date);
    } else {
        $sql = "SELECT r.`fname`, r.`lname`, il.`Lost_ID`, il.`Item`, il.`Description`, il.`Location`, il.`Date`, il.`Image`
                FROM item_lost il
                JOIN register r ON il.`UID` = r.`UID` order by Lost_ID desc";
        $stmt = $conn->prepare($sql);
    }
  } else {
      $sql = "SELECT r.`fname`, r.`lname`, il.`Lost_ID`, il.`Item`, il.`Description`, il.`Location`, il.`Date`, il.`Image`
              FROM item_lost il
              JOIN register r ON il.`UID` = r.`UID` order by Lost_ID desc";
      $stmt = $conn->prepare($sql);
  }
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
  <title>List of lost items</title>
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
        var confirmDelete = confirm('Are you sure you want to delete this?\nThis action cannot be undone!');

        if (confirmDelete) {
                // User confirmed deletion
                window.location.href = 'delete.php?Lost_ID=' + item;
            } else {
                // User canceled deletion
                alert('Report deletion canceled.');
            }
    }

    document.addEventListener('DOMContentLoaded', (event) => {
            var from_date = document.getElementById('from_date');
            var to_date = document.getElementById('to_date');
            var currentDateTime = new Date();

            function validateDateInput(input) {
                var enteredDateTime = new Date(input.value);
                if (enteredDateTime > currentDateTime) {
                    alert("Entered date cannot exceed the current date and time.");
                    input.value = '';
                }
            }

            function validateDateRange() {
                if (from_date.value && to_date.value) {
                    var fromDateTime = new Date(from_date.value);
                    var toDateTime = new Date(to_date.value);

                    if (fromDateTime > toDateTime) {
                        alert("The 'from' date cannot be later than the 'to' date.");
                        from_date.value = '';
                        to_date.value = '';
                    }
                }
            }

            from_date.addEventListener('input', function() {
                validateDateInput(from_date);
                validateDateRange();
            });

            to_date.addEventListener('input', function() {
                validateDateInput(to_date);
                validateDateRange();
            });
        });
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
                  <a class="dropdown-item" href="logout.php">
                    <i class="mdi mdi-logout text-primary" ></i>
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
                  <li class="nav-item"><a class="nav-link" href="">Lost Report</a></li>
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
                            <form method="post">
                                    <div class="form-group row" style="padding: 20px;">
                                        <label class="col-lg-0 col-form-label-report" for="from">Lost From</label>
                                        <div class="col-lg-3">
                                            <input type="date" class="form-control" id="from_date" name="from_date" placeholder="Select Date" >
                                        </div>
                                        <label class="col-lg-0 col-form-label" for="from">Lost Till</label>
                                        <div class="col-lg-3">
                                            <input type="date" class="form-control" id="to_date" name="to_date" placeholder="Select Date" >
                                        </div>
                                        <div class="col-lg-2">
                                            <button type="submit" name="srh-btn" class="btn btn-lg btn-primary search-button">Search</button>
                                        </div>
                                    </div>
                                </form>
                              <div class="row justify-content-end">
                                <h4 class="card-title">Items losts reports</h4>
                                <input type="button" id="export" value="Export" class="btn btn-info col col-lg-2 "/>
                              </div>
                              <br>
                                <div class="table-responsive">
                                    <?php if ($result->num_rows > 0) { ?>
                                        <table class="table table-hover" id="pdf">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Username</th>
                                                    <th>Lost item</th>
                                                    <th>Description</th>
                                                    <th>Lost at</th>
                                                    <th>Lost time</th>
                                                    <th>Image</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $count = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<tr>';
                                                    echo '<td>' . $count++ . '</td>';
                                                    echo '<td>' . htmlspecialchars($row['fname'] . " " . $row['lname']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($row['Item']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($row['Description']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($row['Location']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($row['Date']) . '</td>';
                                                    $img = htmlspecialchars($row['Image']);
                                                    $uploadDir = "../user/lost_images/";
                                                    $targetPath = $uploadDir . basename($img);
                                                    echo '<td><img style="width:100px; height:100px; border-radius:0;" src="' . $targetPath . '" alt="No image uploaded"></td>';
                                                    echo '<td><button class="btn btn-inverse-danger btn-fw" onclick="delete_item(' . $row['Lost_ID'] . ')">Delete</button></td>'; 
                                                    echo '</tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php } else {
                                        echo  "No Data Found";
                                    } ?>
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
    <!-- container-scroller -->
    <!-- base:js -->
    <!-- base:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../js/template.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../../js/file-upload.js"></script>
    <!-- End custom js for this page-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#export').click(function () {
                const { jsPDF } = window.jspdf;

                var doc = new jsPDF('1', 'pt', 'a4');
                
                // Adding title to the PDF
                doc.text('Lost items report', 20, 25);

                var columns = [
                    { header: 'SN', dataKey: 'header1' },
                    { header: 'Username', dataKey: 'header2' },
                    { header: 'Lost item', dataKey: 'header3' },
                    { header: 'Description', dataKey: 'header4' },
                    { header: 'Lost at(possible)', dataKey: 'header5' },
                    { header: 'Lost time(possible)', dataKey: 'header6' },
                ];

                var rows = [];
                $('#pdf tbody tr').each(function () {
                    var row = {};
                    row['header1'] = $(this).find('td').eq(0).text();
                    row['header2'] = $(this).find('td').eq(1).text();
                    row['header3'] = $(this).find('td').eq(2).text();
                    row['header4'] = $(this).find('td').eq(3).text();
                    row['header5'] = $(this).find('td').eq(4).text();
                    row['header6'] = $(this).find('td').eq(5).text();
                    

                    rows.push(row);
                });

                doc.autoTable({
                    columns: columns,
                    body: rows,
                    startY: 50,
                    theme: 'grid',
                    headStyles: { fillColor: [99,102,106] }, // Customize header style
                    bodyStyles: { fillColor: [255, 255, 255] }, // Customize body style
                    alternateRowStyles: { fillColor: [245, 245, 245] } // Alternate row styles
                });

                doc.save('LostReportTable.pdf');
            });
        });
    </script>
    
</body>

</html>

<?php
$stmt->close();  // Close the prepared statement
mysqli_close($conn);  // Close the database connection
  }else{
    header("location:../user/login.php");
  }
?>