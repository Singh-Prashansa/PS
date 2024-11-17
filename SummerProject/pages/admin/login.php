<?php
// Start the session
session_start();

// Check if the user is already logged in, redirect to home page
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

require_once("../includes/classes/FormSanitizer.php");
// Check if the form is submitted
if (isset($_POST['submit'])) {
    
    // Retrieve user input from the form
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    
    if($email=="admin@gmail.com" && $password=="admin"){
        $_SESSION['admin'] = "admin";
        header("Location: index.php");
        
    }else{
        $error = "Invalid email or password";
    }
        
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
                                <div class="brand-logo">
                                    <img src="../../images/logo.svg" alt="logo">
                                </div>
                                <h4>Hello! let's get started</h4>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                
                                <form class="pt-3" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="admin@gmail.com" name="email">
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
                                        Don't have an account? <a href="../user/signup.php" class="text-primary text-decoration-none">Create</a>
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
