<!-- connection -->
<?php
    // Create a connection
    $conn = new mysqli("localhost", "root", "", "LFSystem");

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>