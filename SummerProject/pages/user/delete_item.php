<?php
session_start();
require "connection.php";
if(isset($_SESSION['user_id'])){    


// claimed.php
if (isset($_GET['SN'])) {
        $SN = filter_var($_GET['SN'], FILTER_SANITIZE_NUMBER_INT);
       
            $sql = "DELETE FROM user_claim WHERE `sn` = ? ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $SN);
            $stmt->execute();
        
            if ($stmt->affected_rows > 0) {
                echo "<script>  
                    window.location.href = 'claimed.php';
                </script>";
                exit(); 
            } else {
                echo "Error deleting record: " . $conn->error;
            }
            $stmt->close();
            $conn->close();
        }

//item_lost_form.php
if (isset($_GET['Lost_ID'])) {
    $ItemID = filter_var($_GET['Lost_ID'], FILTER_SANITIZE_NUMBER_INT);

    $sql = "DELETE FROM item_lost WHERE `Lost_ID` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ItemID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>  
            window.location.href = 'item_lost_form.php';
        </script>";
        exit(); 
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}
} else {
    header("location:login.php");
}
?>