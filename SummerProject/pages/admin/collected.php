<?php
session_start();

require "connection.php";
require_once("../includes/classes/FormSanitizer.php");

function show_error($message) {
    echo "<script>console.error('" . $message . "');</script>";
    exit();
}

if (isset($_SESSION['admin'])) {
    if (isset($_GET['ID']) && isset($_GET['collected_by']) && isset($_GET['UID'])) {
        $ID = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);
        $collected_by = FormSanitizer::sanitizeFormName($_GET["collected_by"]);
        $UID = filter_var($_GET['UID'], FILTER_SANITIZE_NUMBER_INT);

        

        // Prepare and execute SELECT query to get item information
        $sql = "SELECT a.item, r.fname, r.lname, a.date AS date_found, a.location, a.image, r.UID, uc.sn
                FROM all_items a
                JOIN user_claim uc ON a.ID = uc.ItemID
                JOIN register r ON uc.UID = r.UID
                WHERE uc.ItemID = ? and uc.UID=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            show_error("Error preparing statement: " . $conn->error);
        }
        
        $stmt->bind_param("ii", $ID,$UID);
        if (!$stmt->execute()) {
            show_error("Error executing query: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result === false) {
            show_error("Error getting result: " . $stmt->error);
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                date_default_timezone_set('Asia/Kathmandu');
                $current_date = date('Y-m-d h:i:s A');

                $item = $row['item'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $date_found = $row['date_found'];
                $location = $row['location'];
                $image = $row['image'];
                $UID = $row['UID'];
                $sn = $row['sn'];


                // Insert collected item into database
                $insert_sql = "INSERT INTO `collected`(`ItemID`, `UID`,`sn`, `item`, `collected_by`, `fname`, `lname`, `date_found`, `location`, `image`, `date_collected`) 
                               VALUES (?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_sql);
                if ($stmt_insert === false) {
                    show_error("Error preparing insert statement: " . $conn->error);
                }
                
                $stmt_insert->bind_param("iiissssssss", $ID, $UID,$sn, $item, $collected_by, $fname, $lname, $date_found, $location, $image, $current_date);

                if (!$stmt_insert->execute()) {
                    show_error("Error inserting into collected table: " . $stmt_insert->error);
                }

                // Update all_items table to mark the item as collected
                $update_sql = "UPDATE `all_items` SET collected = 1 WHERE ID = ?";
                $stmt_update = $conn->prepare($update_sql);
                if ($stmt_update === false) {
                    show_error("Error preparing update statement: " . $conn->error);
                }
                
                $stmt_update->bind_param("i", $ID);
                if (!$stmt_update->execute()) {
                    show_error("Error updating all_items table: " . $stmt_update->error);
                }

                echo "<script>window.location.href = 'report_collected.php';</script>";
                exit();
            }
        } else {
            show_error("No matching rows found!");
        }

        $stmt->close();
    } else {
        show_error("Form data not complete!");
    }
    $conn->close();
} else {
    header("Location: ../user/login.php");
    exit();
}
?>
