<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

if(isset($_POST['wishid'])) {
    $wid = $_POST['wishid'];
    $uid = $_SESSION['id'];
    
    $query = "DELETE FROM tbl_wishlist WHERE wishid = ? AND userid = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $wid, $uid);
    
    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Book removed from wishlist']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove book']);
    }
    
    $stmt->close();
    $connection->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>