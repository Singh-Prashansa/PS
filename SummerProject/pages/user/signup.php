<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <!-- base:css -->
    <link rel="stylesheet" href="../../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
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
                                <div class="brand-logo" style="width:200px ; height:80px; overflow:hidden; ">
                                <img src="../../images/Reunify.png" alt="logo" style="width:100%; height:100%; object-fit:cover">

                                </div>
                                <h4>New here?</h4>
                                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                                <form class="pt-3 " method="post" action="register.php">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" name="fname" placeholder="First name" id="fname" required>
                                        <div id="fnameError"  class="text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" name="lname" placeholder="Last name" id="lname" required>
                                        <div id="lnameError"  class="text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" name="scode" placeholder="Student code [xx-xxxx-xx]" id="scode" required>
                                        <div id="scodeError"  class="text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" required id="email">
                                        <div id="emailError"  class="text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Password (must be at least 8 characters)" id="password" required>
                                        <div id="passwordError"  class="text-danger"></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-lg" name="cpassword" placeholder="Confirm Password" id="cpassword" required>
                                        <div id="cpasswordError"  class="text-danger"></div>
                                    </div>
                                    <div class="mt-3">
                                        <input type="submit" onclick="return validateForm()" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="SIGN UP" name="submit">
                                    </div>
                                    <div class="text-center mt-4 font-weight-light">
                                        Already have an account? <a href="login.php" class="text-primary text-decoration-none">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
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

    <script>
        function validateForm() {
            var isValid = true;

            var fname = document.getElementById("fname").value.trim();
            var letters = /^[A-Za-z]+$/;
            if (!fname.match(letters)) {
                document.getElementById("fnameError").innerHTML = "Name must contain only alphabetic characters";
                isValid = false;
            } else {
                document.getElementById("fnameError").textContent = "";
            }

            var lname = document.getElementById("lname").value.trim();
            if (!lname.match(letters)) {
                document.getElementById("lnameError").innerHTML = "Name must contain only alphabetic characters";
                isValid = false;
            } else {
                document.getElementById("lnameError").textContent = "";
            }

            var scode = document.getElementById("scode").value.trim();
            var pattern = /^\d{2}-\d{4}-\d{2}$/;
            if (!pattern.test(scode)) {
                document.getElementById("scodeError").innerHTML = "Student code must be in the format xx-xxxx-xx";
                isValid = false;
            } else {
                document.getElementById("scodeError").textContent = "";
            }

            var email = document.getElementById("email").value.trim();
            var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!emailRegex.test(email)) {
                document.getElementById("emailError").innerHTML = "Please enter a valid email address";
                isValid = false;
            } else {
                document.getElementById("emailError").textContent = "";
            }

            var password = document.getElementById("password").value;
            if (password.length < 8) {
                document.getElementById("passwordError").innerHTML = "Password must be at least 8 characters long";
                isValid = false;
            } else {
                document.getElementById("passwordError").textContent = "";
            }
            
            var cpassword = document.getElementById("cpassword").value;
            if (password !== cpassword) {
                document.getElementById("cpasswordError").innerHTML = "Passwords do not match";
                isValid = false;
            } else {
                document.getElementById("cpasswordError").textContent = "";
            }
            
            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault(); // Prevent default form submission behavior
            }
            return isValid;
        }
    </script>
</body>
</html>
