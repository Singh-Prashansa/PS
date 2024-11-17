<?php
session_start();

require "connection.php";
if(isset($_SESSION['admin'])){    

$sql = "SELECT * from register";
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
  <title>List of users</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <script>
    function delete_user(id) {
        var confirmDelete = confirm('Are you sure you want to delete user?\nThis action cannot be undone!');

        if (confirmDelete) {
                // User confirmed deletion
                window.location.href = 'delete.php?UID=' + id;
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
                  <input type="search" class="form-control text-dark  " placeholder="Search" aria-label="search"
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
                <div class="row justify-content-end">
                  <h4 class="card-title">All users</h4>
                  <input type="button" id="export" value="Export" class="btn btn-info col col-lg-2 "/>
                </div>
                <br>

                <div class="table-responsive">
                    <?php
if (mysqli_num_rows($result) > 0) {
    ?>
                  <table class="table table-hover" id="pdf">
                    <thead class="bg-dark text-white">
                      <tr>
                      <th>SN</th>
            <th>UID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Student Code</th>
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
                                echo '<td>' . $row['UID'] . '</td>';
                                echo '<td>' . $row['fname'] . '</td>';
                                echo '<td>' . $row['lname']  . '</td>';                    
                                echo '<td>' . $row['email'] . '</td>'; 
                                echo '<td>' . $row['scode'] . '</td>';                    

                                echo '<td><button class="btn btn-inverse-danger btn-fw" onclick="delete_user(' . $row['UID'] . ')">Delete</button></td>';        
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#export').click(function () {
                const { jsPDF } = window.jspdf;

                var doc = new jsPDF('1', 'pt', 'a4');
                
                // Adding title to the PDF
                doc.text('User details', 20, 25);

                var columns = [
                    { header: 'SN', dataKey: 'header1' },
                    { header: 'UID', dataKey: 'header2' },
                    { header: 'First name', dataKey: 'header3' },
                    { header: 'Last name', dataKey: 'header4' },
                    { header: 'Email', dataKey: 'header5' },
                    { header: 'Student code', dataKey: 'header6' },
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

                doc.save('UserTable.pdf');
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