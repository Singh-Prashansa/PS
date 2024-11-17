<?php
session_start();

require "connection.php";
require_once("../includes/classes/FormSanitizer.php");

if(isset($_SESSION['admin'])){    
    $ID = FormSanitizer::sanitizeFormForTags($_GET["ID"]);
    $item = FormSanitizer::sanitizeFormName($_POST["item"]);
    $description = FormSanitizer::sanitizeFormDescription($_POST["item"]);
    $date = $_POST['date'];
    $location = FormSanitizer::sanitizeFormForTags($_POST['location']);

    // Check if a new file is uploaded
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        
        // Move the uploaded file to the desired location
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");

        // Prepare SQL statement to update the image column
        $stmt = $conn->prepare("UPDATE `all_items` SET `item`=?, `description`=?, `date`=?, `location`=?, `image`=? WHERE `ID`=?");
        $stmt->bind_param("sssssi", $item, $description, $date, $location, $image, $ID);
    } else {
        // If no new file is uploaded, update the other columns without changing the image column
        $stmt = $conn->prepare("UPDATE `all_items` SET `item`=?, `description`=?, `date`=?, `location`=? WHERE `ID`=?");
        $stmt->bind_param("ssssi", $item, $description, $date, $location, $ID);
    }

    if ($stmt->execute()) {
        echo "<script>
                window.location.href = 'display_items.php';
            </script>";
        exit(); // Make sure to exit after redirection
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("location:../user/login.php");
}
?>
