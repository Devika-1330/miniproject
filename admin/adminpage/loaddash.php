<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';


$queries = [
    'total_books' => "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1",
    'total_users' => "SELECT COUNT(*) AS total FROM tbl_users",
    'community_requests' => "SELECT COUNT(*) AS total FROM tbl_reports",
    'available_books' => "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND avstatus=1 AND archive=0",
    'reserved_books' => "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND avstatus=2 AND archive=0",
    'sold_out_books' => "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND avstatus=3 AND (archive=0 OR archive=1)",
    'archived_books' => "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND archive=1"
];

$counts = [];
foreach ($queries as $key => $query) {
    $stmt = $connection->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $counts[$key] = $row['total'];
    $stmt->close();
}


header('Content-Type: application/json');
echo json_encode($counts);
?>