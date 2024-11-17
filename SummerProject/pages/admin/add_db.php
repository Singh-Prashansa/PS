<?php
session_start();

require "connection.php";
require_once("../includes/classes/FormSanitizer.php");

if(isset($_SESSION['admin'])){
    if (isset($_POST["submit"])) {
        // Sanitize form inputs
        $item = FormSanitizer::sanitizeFormName($_POST["item"]);
        $description = FormSanitizer::sanitizeFormDescription($_POST["description"]);
        $date = $_POST['date'];
        $location = $_POST['location'];
        $image = $_FILES['image']['name'];

        // Move uploaded image to destination directory
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");

        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO `all_items`(`item`, `description`, `date`, `location`, `image`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $item, $description, $date, $location, $image);

        // Check if the item was successfully inserted
        if ($stmt->execute()) {
            // Notification logic
            date_default_timezone_set('Asia/Kathmandu');
            $current_date = date('Y-m-d h:i:s A');

            // Prepare and execute the query to check for matching rows
            $item = '%' . $item . '%';
            $description = '%' . $description . '%';

            // $sql1 = "SELECT l.UID, l.Lost_ID, a.ID FROM item_lost l, all_items a WHERE a.item LIKE ? OR a.description LIKE ? order by a.ID desc";
            // $sql1="SELECT l.UID,l.Lost_ID, a.ID FROM item_lost l JOIN all_items a ON l.item LIKE ? OR l.description LIKE ? order by a.ID desc;";
            $sql1 = "SELECT l.UID, l.Lost_ID, a.ID FROM item_lost l JOIN all_items a ON (l.item LIKE ? OR l.description LIKE ?) 
                        WHERE a.ID = (SELECT MAX(a2.ID) FROM all_items a2 WHERE l.item LIKE ? OR l.description LIKE ?)
                        GROUP BY l.Lost_ID;";

            $stmt1 = $conn->prepare($sql1);
            $stmt1->bind_param("ssss", $item, $description,$item, $description);
            $stmt1->execute();
            $result1 = $stmt1->get_result();

            // Check if there are matching rows
            if ($result1->num_rows > 0) {
                // Check if the item has already been notified
                // $already_notified = false;
                while ($row = $result1->fetch_assoc()) {
                    // if (!$already_notified) {
                        // Prepare the insert statement for the notification table
                        $stmt_notification = $conn->prepare("INSERT INTO `notification`(`UID`, `Lost_ID`, `ID`, `date`) VALUES (?, ?, ?, ?)");
                        // Bind parameters for the notification insert statement
                        $stmt_notification->bind_param("ssss", $row['UID'], $row['Lost_ID'], $row['ID'], $current_date);

                        // Execute the insert statement for notification
                        if (!$stmt_notification->execute()) {
                            echo "Error: " . $stmt_notification->error;
                        }

                        // $already_notified = true; // Set flag to true after notification
                    // }
                }

                // Close the notification statement after the loop
                $stmt_notification->close();
            } 
            // else {
            //     echo "No matching rows found!";
            // }

            // Close the result set and the main statement
            $result1->close();
            $stmt1->close();

            // Close the connection
            $conn->close();

            echo "<script> 
                window.location.href = 'display_items.php';
                </script>";
            exit(); // Exit after redirection
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
} else {
    header("location:../user/login.php");
}
?>
