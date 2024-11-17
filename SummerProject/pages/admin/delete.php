<?php

session_start();
require "connection.php";
if(isset($_SESSION['admin'])){    

// report_lost.php
if (isset($_GET['Lost_ID'])) {
    $ItemID =filter_var($_GET['Lost_ID'], FILTER_SANITIZE_NUMBER_INT);

    // $ItemID = $_GET['Lost_ID'];
   
        $sql = "DELETE FROM item_lost WHERE `Lost_ID` = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ItemID);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "<script>  
                window.location.href = 'report_lost.php';
            </script>";
            exit(); 
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        $stmt->close();
        $conn->close();
    }

// report_claimed.php
if (isset($_GET['ItemID'])) {
    $ItemID =filter_var($_GET['ItemID'], FILTER_SANITIZE_NUMBER_INT);

        // $ItemID = $_GET['ItemID'];
       
            $sql = "DELETE FROM user_claim WHERE `ItemID` = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $ItemID);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                echo "<script>  
                    window.location.href = 'report_claimed.php';
                </script>";
                exit(); 
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            $stmt->close();
            $conn->close();
        }

        // report_collected.php
if (isset($_GET['CID'])) {
    // $ItemID = $_GET['CID'];
    $ItemID =filter_var($_GET['CID'], FILTER_SANITIZE_NUMBER_INT);
    
        $sql = "DELETE FROM collected WHERE `CID` = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ItemID);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "<script>  
                window.location.href = 'report_collected.php';
            </script>";
            exit(); 
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        $stmt->close();
        $conn->close();
    }


// display_items.php
if(isset($_GET['ID'])) {
    // $ID = $_GET['ID'];
    $ID =filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);

$sql = "DELETE FROM `all_items` WHERE ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ID);
$stmt->execute();

$rowsAffected = mysqli_affected_rows($conn);
if ($rowsAffected > 0) {
    // echo '<script>alert("Deletion successful!");</script>';
    // header("location:all_items.php?del=true");
    // header("location:all_items.html");
    echo "<script> 
            window.location.href = 'display_items.php';
        </script>";
        exit(); // Make sure to exit after redirection
} else {
    echo '<script>alert("No record found for deletion!");</script>';
    // Handle accordingly, maybe redirect to an error page or display a message
}
}

// report_user.php
if (isset($_GET['UID'])) {
    $ID =filter_var($_GET['UID'], FILTER_SANITIZE_NUMBER_INT);

    // $ID = $_GET['UID'];
   
        $sql = "DELETE FROM register WHERE `UID` = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ID);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "<script>  
                window.location.href = 'report_users.php';
            </script>";
            exit(); 
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        $stmt->close();
        $conn->close();
    }
}
?>