<?php
require_once("../includes/classes/FormSanitizer.php");

if (isset($_POST['submit'])) {
    $fname = FormSanitizer::sanitizeFormName($_POST["fname"]);
    $lname = FormSanitizer::sanitizeFormName($_POST["lname"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $scode = FormSanitizer::sanitizeFormForTags($_POST["scode"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $conn = new mysqli("localhost", "root", "", "LFSystem");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        echo "<script> alert('User already exist. Please use another email.');
        window.location.href = 'signup.php'
         </script>";
         
    } else {
        $stmt = $conn->prepare("INSERT INTO `register`(`fname`, `lname`, `email`, `password`, `scode`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fname, $lname, $email, $password, $scode);

        if ($stmt->execute()) {
            header("location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>
