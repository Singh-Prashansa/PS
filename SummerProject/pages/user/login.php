<?php
// Start the session
session_start();

// Check if the user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit();
}

require_once("../includes/classes/FormSanitizer.php");

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // $_SESSION['timeout'] = time();

    // Retrieve user input from the form
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
        
    require "connection.php";

    if($email=="admin@gmail.com" && $password=="admin"){
        $_SESSION['admin'] = "admin";
        header("Location: ../admin/index.php");
        
        
        
    }else{
        $error = "Invalid email or password";
    }

    // Validate user credentials against the database
    $sql = "SELECT * FROM register WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User authentication successful
        $user = $result->fetch_assoc();
        $verify = password_verify($password, $user['password']);

        if ($verify) {
            // Store user information in session
            $_SESSION['user_id'] = $user['UID'];
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];
            $_SESSION['email'] = $user['email'];

            // Redirect to home page or another protected area
            header("Location: home.php");
            exit();
        } else {
            // Password verification failed
            $error = "Invalid email or password";
        }
    } else {
        // User not found
        $error = "Invalid email or password";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
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
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="main-panel">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                <div class="brand-logo"  style="width:200px ; height:100px; overflow:hidden; ">
                                
                                
                                
                                    <img src="../../images/Reunify.png" alt="logo" style="width:100%; height:100%; object-fit:cover">
                                </div>
                                <h4>Hello! let's get started</h4>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                <form class="pt-3" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="prashansa@gmail.com" name="email">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" name="password">
                                    </div>
                                    <?php if (isset($error)) : ?>
                                        <p class="text-danger"><?php echo $error; ?></p>
                                    <?php endif; ?>
                                    <div class="mt-3">
                                        <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="submit" value="Sign In">
                                    </div>
                                    <div class="text-center mt-4 font-weight-light ">
                                        Don't have an account? <a href="signup.php" class="text-primary text-decoration-none">Create</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../js/template.js"></script>
    <!-- endinject -->
</body>

</html>
