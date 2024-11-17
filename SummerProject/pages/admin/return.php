<?php
session_start();
require "connection.php";

if (isset($_SESSION['admin'])) {
    if (isset($_GET['ItemID']) && isset($_GET['UID'])) {
        $ItemID = filter_var($_GET['ItemID'], FILTER_SANITIZE_NUMBER_INT);
        $UID = filter_var($_GET['UID'], FILTER_SANITIZE_NUMBER_INT);

        $date_returned = date('Y-m-d H:i:s');

        // Update collected table
        $sql2 = "UPDATE `collected` SET `date_returned`=?, `returned`=? WHERE `ItemID` = ? AND `UID`=?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }
        // Corrected binding of parameters
        $returned = 1; // Assuming `returned` column is of integer type
        $stmt2->bind_param("siii", $date_returned, $returned, $ItemID, $UID);
        $stmt2->execute();

        if ($stmt2->affected_rows > 0) {
            // Update was successful
            // Update all_items table
            $sql1 = "UPDATE `all_items` SET `collected`=? WHERE `ID` = ?";
            $stmt1 = $conn->prepare($sql1);
            if (!$stmt1) {
                echo "Error preparing statement: " . $conn->error;
                exit();
            }
            // Corrected binding of parameters
            $collected = 0;
            $stmt1->bind_param("ii", $collected, $ItemID);
            $stmt1->execute();
            if ($stmt1->affected_rows > 0) {
                // Update was successful
                // Remove claim of the item by the user after returning
                $sql = "DELETE FROM user_claim WHERE `UID` = ? AND `ItemID`=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $UID, $ItemID);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    // Redirect back to the report_collected.php page
                    header("Location: report_collected.php");
                    exit();
                } else {
                    echo "Error deleting record: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error updating record in 'all_items' table: " . $stmt1->error;
            }
        } else {
            echo "Error updating record in 'collected' table: " . $stmt2->error;
        }
        // Close the prepared statements
        $stmt1->close();
        $stmt2->close();
    } else {
        echo "ItemID or UID is missing.";
    }
} else {
    header("location:login.php");
}
?>
