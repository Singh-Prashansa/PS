<?php
session_start();
require "connection.php";

if (isset($_SESSION['user_id'])) {
    // Prepare and execute the DELETE query
    $sql = "DELETE FROM register WHERE UID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);

    if ($stmt->execute()) {
        // Destroy the session after account deletion
        session_destroy();
        // Redirect to the signup page
        echo "<script>
                alert('User deleted successfully.');
                window.location.href = 'signup.php';
              </script>";
    } else {
        // Provide feedback to the user in case of an error
        echo "Error deleting user: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
    
    // Close the connection
    $conn->close();
} else {
    // Redirect the user to the login page if not logged in
    header("location:login.php");
}
?>
