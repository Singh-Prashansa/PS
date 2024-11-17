<?php
// Start the session
session_start();
ob_start();
require "connection.php";
require_once("../includes/classes/FormSanitizer.php");

if (isset($_SESSION['user_id']) && isset($_POST['oldpass'])) {
    $uid = $_SESSION['user_id'];
    $old_password = FormSanitizer::sanitizeFormPassword($_POST["oldpass"]);
    $new_password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

    $sql = 'SELECT `password` FROM register WHERE UID = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User authentication successful
        $user = $result->fetch_assoc();
        $verify = password_verify($old_password, $user['password']);
        
        // Initialize $update_stmt here
        $update_stmt = null;

        if ($verify) {
            // Update the password
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = 'UPDATE register SET `password` = ? WHERE UID = ?';
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $new_password, $uid);
            
            if ($update_stmt->execute()) {
                echo '<script>alert("Password updated successfully!"); window.location.href = "setting.php";</script>';
            } else {
                echo "Error: " . $update_stmt->error;
            }
        } else {
            echo '<script>alert("Old password does not match!"); window.location.href = "edit_account.php";</script>';
        }
        
        // Close the statements
        $stmt->close();
        if ($update_stmt !== null) {
            $update_stmt->close();
        }
    } else {
        echo "Error: User not found";
    }
} else {
    echo "Old password not set";
}
?>
