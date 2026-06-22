<?php
header('Content-Type: application/json');
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php'; // Database connection

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get input and session data
$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? '';
$uid = $_SESSION['id'] ?? null;

if (!$uid) {
    echo json_encode(['result' => false, 'error' => 'User not logged in']);
    exit;
}

// Step 1: Check if this email belongs to the current user
$query = "SELECT COUNT(*) FROM tbl_users WHERE email = ? AND id = ?";
$stmt = $connection->prepare($query);
if (!$stmt) {
    echo json_encode(['result' => false, 'error' => 'Query preparation failed']);
    exit;
}
$stmt->bind_param('si', $email, $uid);
$stmt->execute();
$stmt->bind_result($ownCount);
$stmt->fetch();
$stmt->close();

$query = "SELECT COUNT(*) FROM tbl_users WHERE email = ?";
$stmt = $connection->prepare($query);
if (!$stmt) {
    echo json_encode(['result' => false, 'error' => 'Query preparation failed']);
    exit;
}
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->bind_result($totalCount);
$stmt->fetch();
$stmt->close();

$result = ($ownCount > 0 || $totalCount == 0) ? true : false;

echo json_encode(['result' => $result]);
?>