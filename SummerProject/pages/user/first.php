<?php
session_start();
if(isset($_SESSION['user_id'])){    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="first.css">
    <title>Welcome to ...</title>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0; 
            background-color: #DAE7EE; 

        }
        .sidebar {
            width: 240px;
            position: fixed;
            height: 100%;
            overflow: auto;
            padding-top: 20px;
        }
        /* .main-content {
            margin-right: 100px;
            padding: 20px;
        } */
    </style>
    

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Main Navigation -->
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white mt-3">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-5">
                    <div class="ms-3 mb-3 ">
                        <h5 class="mb-0"><?php echo $_SESSION['fname']." ". $_SESSION['lname'] ;?></h5>
                        <span>User</span>
                    </div>
                    <a href="first.php" class="list-group-item list-group-item-action py-2 ripple" aria-current="true"><span>HOME</span></a>
                    <a href="user_item_display.php" class="list-group-item list-group-item-action py-2 ripple "><span>ALL ITEMS</span></a>
                    <a href="item_lost_form.php" class="list-group-item list-group-item-action py-2 ripple"><span>REPORT LOST</span></a>
                    <a href="item_claimed.php" class="list-group-item list-group-item-action py-2 ripple"><span>CLAIMED ITEMS</span></a>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle list-group-item list-group-item-action py-2 ripple border-0" data-bs-toggle="dropdown">ACCOUNT</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="notification.php" class="dropdown-item">NOTIFICATION</a>
                            <a href="setting.php" class="dropdown-item">SETTINGS</a>
                            <a href="logout.php" class="dropdown-item">LOGOUT</a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
        <!-- Sidebar -->

        <!-- Navbar -->
  <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-secondary fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Toggle button -->
        <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#sidebarMenu"
            aria-controls="sidebarMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <!-- <i class="fas fa-bars"></i> -->
        </button>

        <!-- Brand -->
        <a class="navbar-brand text-white" href="#">
            <img
                src="../logo/R.jfif"
                height="25"
                alt="LOGO"
                loading="lazy"
            />
        </a>
        <!-- Search form -->
        <form class="d-none d-md-flex input-group w-auto my-auto" method="get">
            <input
                autocomplete="off"
                type="search"
                class="form-control "
                placeholder='Search item'
                style="min-width: 225px;"
                name="search"
            />
            <!-- <span class="input-group-text border-0"><i class="fas fa-search" onclick=""></i></span> -->
            <button class="input-group-text">Search</button>

        </form>
    </div>
</nav>

  <!-- Navbar -->
        
    </header>
    <!-- Main Navigation -->

    <!-- Main layout -->
    <main style="margin-top: 16px; margin-left:250px; ">
        <div class="container pt-3 ">
        <?php
            // if(isset($_GET['lt'])){
                // echo '<script>alert("Item reported.");</script>';
                // echo 'Values Updated';
            // }
            
           
            require "connection.php";

            if (isset($_GET['search'])) {
                $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
                $search = '%' . $_GET['search'] . '%';
                $sql = "SELECT * FROM all_items WHERE item LIKE ? OR description LIKE ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $search, $search);
                $stmt->execute();
                
                if ($stmt->errno) {
                    echo "SQL Error: " . $stmt->error;
                } else {
                    $result = $stmt->get_result();
                }
            } else {
                // If no search query, execute the default query
                $sql = "SELECT * FROM `all_items` ORDER BY ID DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
            }

            if ($result->num_rows > 0) {
                echo "<div class='row row-cols-1 row-cols-md-4 g-4 mt-4'>";
                
                while ($row = $result->fetch_assoc()) {
                    $img = $row['image'];
                    $uploadDir = "../images/";
                    $targetPath = $uploadDir . basename($img);
                    echo "<div class='col'>
                            <div class='card '>
                            <img src='$targetPath' class='card-img-top figure-img img-fluid rounded img-thumbnail' alt='No image found' style='width: 300px; height: 200px;'>
                                <div class='card-body'>
                                    <h5 class='card-title'> Item: " . $row['item'] . "</h5>
                                    <p class='card-text'>Description: " . $row['description'] . "</p>
                                    <p class='card-text'>Date found: " . $row['date'] . "</p>
                                    <p class='card-text'>Location found: " . $row['location'] . "</p>
                                    <a class='btn btn-primary' href='claim.php?ID=" . $row['ID'] . "'>Claim</a>
                                </div>
                            </div>
                        </div>";
                }
                echo "</div>"; // Close the row
            } else {
                echo "No Data Found";
            }

            $stmt->close(); // Close the prepared statement
            $conn->close(); // Close the database connection
        }else{
            header("location:login.php");
        }
            ?>

        </div>
    </main>
    <!-- Main layout -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

</body>
</html>
