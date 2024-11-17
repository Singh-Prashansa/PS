<?php
session_start(); // Start the session

// Database connection and other required includes
require "connection.php";



// Check if itemName is provided via POST request and user is logged in
if (isset($_POST['itemName']) && isset($_SESSION['user_id'])) {
    // Sanitize the input
    $itemName = filter_var($_POST['itemName'], FILTER_SANITIZE_STRING);

    // Prepare and execute the query to check if the form is filled for the given item name and user_id
    $stmt = $conn->prepare("SELECT * FROM item_lost WHERE Item = ? AND UID = ?");
    $stmt->bind_param("si", $itemName, $_SESSION['user_id']); // Assuming user_id is stored in session
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row exists for the given item name and user_id
    if ($result->num_rows > 0) {
        // The form is filled
        echo "filled";
    } else {
        // The form is not filled
        echo "not_filled";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // itemName is not provided or user is not logged in
    echo "Item name is not provided or user is not logged in.";
}
?>
