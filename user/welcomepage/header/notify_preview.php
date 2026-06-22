<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode([]);
    exit();
}

$userid = $_SESSION['id'];
$query = "SELECT noid, message FROM tbl_notification WHERE userid = ? ORDER BY noid DESC LIMIT 3";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    // Truncate message to 50 characters for preview
    $short_message = (strlen($row['message']) > 50) ? substr($row['message'], 0, 105) . "..." : $row['message'];
    $notifications[] = [
        'noid' => $row['noid'],
        'message' => $short_message
    ];
}

$stmt->close();
$connection->close();

echo json_encode($notifications);
?>