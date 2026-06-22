<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msgid = $_POST['msgid'] ?? '';
    $reported_by = $_POST['reported_by'] ?? '';
    $reason = $_POST['reason'] ?? 'general';
    if (empty($msgid) || empty($reported_by)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
        exit();
    }

   
    $checkQuery = "SELECT * FROM tbl_reports WHERE message_id = ? AND reported_by = ?";
    $stmt = $connection->prepare($checkQuery);
    $stmt->bind_param("ii", $msgid, $reported_by);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'You have already reported this message']);
        $stmt->close();
        exit();
    }

   
    $insertQuery = "INSERT INTO tbl_reports (message_id, reported_by, reason, report_date) VALUES (?, ?, ?, NOW())";
    $stmt = $connection->prepare($insertQuery);
    $stmt->bind_param("iis", $msgid, $reported_by,$reason);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Message reported successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to report message']);
    }

    $stmt->close();
    $connection->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>