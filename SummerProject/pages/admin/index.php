<?php 
session_start();
include "connection.php"; // Ensure this sets up $conn and does not close it

if(isset($_SESSION['admin'])){  
  include 'stat.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
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
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <!-- For number of users -->
            <div class="col-lg-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary font-weight-bold"><?php echo $userCount; ?></h2>
                    <i class="mdi mdi-account-outline mdi-18px text-dark"></i>
                  </div>
                </div>
                <canvas id="newClient"></canvas>
                <div class="line-chart-row-title">Number of users</div>
              </div>
            </div>
            <!-- For number of lost items -->
            <div class="col-lg-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-danger font-weight-bold"><?php echo $itemCount; ?></h2>
                    <i class="mdi mdi-account-outline mdi-18px text-dark"></i>
                  </div>
                </div>
                <canvas id="newClient"></canvas>
                <div class="line-chart-row-title">Number of lost items</div>
              </div>
            </div>
            <!-- For number of claimed items -->
            <div class="col-lg-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-warning font-weight-bold"><?php echo $claimCount; ?></h2>
                    <i class="mdi mdi-account-outline mdi-18px text-dark"></i>
                  </div>
                </div>
                <canvas id="newClient"></canvas>
                <div class="line-chart-row-title">Number of claimed items</div>
              </div>
            </div>
            <!-- For number of collected items -->
            <div class="col-lg-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-success font-weight-bold"><?php echo $collectedCount; ?></h2>
                    <i class="mdi mdi-account-outline mdi-18px text-dark"></i>
                  </div>
                </div>
                <canvas id="newClient"></canvas>
                <div class="line-chart-row-title">Number of collected items</div>
              </div>
            </div>
            <!-- For number of found items -->
            <div class="col-lg-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-primary font-weight-bold"><?php echo $foundCount; ?></h2>
                    <i class="mdi mdi-account-outline mdi-18px text-dark"></i>
                  </div>
                </div>
                <canvas id="newClient"></canvas>
                <div class="line-chart-row-title">Number of found items</div>
              </div>
            </div>
            <!-- For bar graph -->
            <div class="col-lg-6 grid-margin stretch-card">
              <?php
                // Define an array mapping month numbers to month names
                $monthNames = array(
                  1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 
                  7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"
                );

                // SQL query to get the count of items lost per month
                $sql_ItemLost = "SELECT MONTH(Date) AS month_lost, COUNT(Lost_ID) AS count_of_ids
                FROM item_lost 
                WHERE YEAR(Date) = YEAR(CURRENT_DATE())
                GROUP BY MONTH(Date)
                ORDER BY month_lost ASC;";

                if ($stmt_ItemLost = $conn->prepare($sql_ItemLost)) {
                  $stmt_ItemLost->execute();
                  $result_ItemLost = $stmt_ItemLost->get_result();

                  // Initialize the data array
                  $dataLostItem = array();

                  // Loop through the query result and populate the data array
                  while ($row = $result_ItemLost->fetch_assoc()) {
                      $monthNumber = (int)$row['month_lost'];
                      $itemCount = (int)$row['count_of_ids'];
                      $dataLostItem[] = array("y" => $itemCount, "label" => $monthNames[$monthNumber]);
                  }
                  
                              } else {
                  echo "Error preparing statement: " . $conn->error;
                }

                // SQL query to get the count of items found per month
                $sql_itemFound = "SELECT MONTH(Date) AS month_found, COUNT(ID) AS count_of_ids
                                FROM all_items 
                                WHERE YEAR(Date) = YEAR(CURRENT_DATE())
                                AND collected = 0
                                GROUP BY MONTH(Date)
                                ORDER BY month_found ASC;";

                if ($stmt_itemFound = $conn->prepare($sql_itemFound)) {
                  $stmt_itemFound->execute();
                  $result_itemFound = $stmt_itemFound->get_result();

                  // Initialize the data array
                  $dateFoundItem = array();

                  // Loop through the query result and populate the data array
                  while ($row = $result_itemFound->fetch_assoc()) {
                      $monthNumber = (int)$row['month_found'];
                      $itemCount = (int)$row['count_of_ids'];
                      $dateFoundItem[] = array("y" => $itemCount, "label" => $monthNames[$monthNumber]);
                  }
                  
                } else {
                  echo "Error preparing statement: " . $conn->error;
                }

                // Assign the data array to the dataPoints variable
                $dataPointsLostItem = $dataLostItem;
                $dataPointsFoundItem = $dateFoundItem;
               ?>

<script>
window.onload = function () {
 var chart1 = new CanvasJS.Chart("chartContainer1", {
     animationEnabled: true,
     title: {
         text: "Items Lost "
     },
     dataPointWidth: 15,
     axisY: {
         title: "No. of Items",
         titleFontColor: "#4F81BC",
         lineColor: "#4F81BC",
         labelFontColor: "#4F81BC",
         tickColor: "#4F81BC"
     },

     toolTip: {
         shared: true
     },
     legend: {
         cursor: "pointer",
         itemclick: toggleDataSeries
     },
     data: [{
         type: "column",
         name: "Lost Items",
        //  legendText: "No. of Lost Items",
        //  showInLegend: true,
         dataPoints: <?php echo json_encode($dataPointsLostItem, JSON_NUMERIC_CHECK); ?>
     }]
 });
 chart1.render();

 function toggleDataSeries(e) {
     if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
         e.dataSeries.visible = false;
     } else {
         e.dataSeries.visible = true;
     }
     chart1.render();
 }

 var chart2 = new CanvasJS.Chart("chartContainer2", {
     animationEnabled: true,
     title: {
         text: "Found Items "
     },
     dataPointWidth: 15,
     axisY: {
         title: "No. of Items",
         titleFontColor: "#4F81BC",
         lineColor: "#4F81BC",
         labelFontColor: "#4F81BC",
         tickColor: "#4F81BC"
     },

     toolTip: {
         shared: true
     },
     legend: {
         cursor: "pointer",
         itemclick: toggleDataSeries
     },
     data: [
     {
         type: "column",  
         name: "Found Items",
        //  legendText: "No. of Found Items",
        //  showInLegend: true,
         dataPoints: <?php echo json_encode($dataPointsFoundItem, JSON_NUMERIC_CHECK); ?>
     }
    ]
 });
 chart2.render();

 function toggleDataSeries(e) {
     if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
         e.dataSeries.visible = false;
     } else {
         e.dataSeries.visible = true;
     }
     chart2.render();
 }
}
</script>

            </div>
            <!-- End of bar graph section -->

            <!--  chart1 section -->
            <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                  <div id="chartContainer1"></div>
              </div>
            </div>
            <!-- End of  chart1 section -->

            <!--  chart2 section -->
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                  <div id="chartContainer2"></div>
              </div>
            </div>
            <!-- End of  chart2 section -->
            </div>
          </div>
        </div>
        <!-- Content-wrapper ends -->
      </div>
      <!-- Main-panel ends -->
    </div>
    <!-- Page-body-wrapper ends -->
  </div>
  <!-- Container-scroller -->
  <!-- base:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- Endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- Inject:js -->
  <script src="../../js/template.js"></script>
  <!-- Endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/chart.js"></script>
  <!-- End custom js for this page-->
  <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>

<?php
} else {
  header("location:../user/login.php");
}
?>
