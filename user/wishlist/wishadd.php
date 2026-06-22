<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
    echo json_encode(['status' => 'error', 'message' => 'Please login first']);
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['bookTitle']) ? trim($_POST['bookTitle']) : '';
    $maxPrice = isset($_POST['maxPrice']) ? floatval($_POST['maxPrice']) : 0;
    $userId = $_SESSION['id'];

    if (empty($title) || $maxPrice <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input data']);
        exit();
    }

    try {
        $query = "INSERT INTO tbl_wishlist (userid, title, maxprice, status) VALUES (?, ?, ?, 0)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("isd", $userId, $title, $maxPrice);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Book added to wishlist']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add book to wishlist']);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$connection->close();
?>