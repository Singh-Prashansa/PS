<?php 
include 'connection.php';

// Count items lost
$sql_itemlost = "SELECT COUNT(Lost_ID) AS itemCount FROM item_lost";
$stmt_itemlost = $conn->prepare($sql_itemlost);
$stmt_itemlost->execute();
$result_itemlost = $stmt_itemlost->get_result();
$itemCount = $result_itemlost->fetch_assoc()['itemCount'];
// echo "Item Count: " . $itemCount . "<br>";

// Count users
$sql_user = "SELECT COUNT(UID) AS userCount FROM register";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$userCount = $result_user->fetch_assoc()['userCount'];
// echo "User Count: " . $userCount . "<br>";

// Count claims
$sql_claim = "SELECT COUNT(sn) AS claimCount FROM user_claim as uc WHERE NOT EXISTS (SELECT 1 FROM collected c2 WHERE c2.sn = uc.sn);";
$stmt_claim = $conn->prepare($sql_claim);
$stmt_claim->execute();
$result_claim = $stmt_claim->get_result();
$claimCount = $result_claim->fetch_assoc()['claimCount'];

// Count collected items
$sql_collected = "SELECT COUNT(CID) AS collectedCount FROM collected where returned=0";
$stmt_collected = $conn->prepare($sql_collected);
$stmt_collected->execute();
$result_collected = $stmt_collected->get_result();
$collectedCount = $result_collected->fetch_assoc()['collectedCount'];

// Count found items
$sql_found = "SELECT COUNT(ID) AS foundCount FROM all_items where collected=0";
$stmt_found = $conn->prepare($sql_found);
$stmt_found->execute();
$result_found = $stmt_found->get_result();
$foundCount = $result_found->fetch_assoc()['foundCount'];

// Close the statements
$stmt_itemlost->close();
$stmt_user->close();
$stmt_claim->close();
$stmt_collected->close();
$stmt_found->close();




// Close the database connection
// $conn->close();
?>