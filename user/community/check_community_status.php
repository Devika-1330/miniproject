<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

$uid = $_SESSION['id'];

$query = "
    SELECT 
        CASE 
            WHEN status = 0 THEN 'joined'
            WHEN status IS NOT NULL THEN 'banned'
            ELSE 'notjoined'
        END AS user_status
    FROM tbl_community 
    WHERE userid = '$uid'
    LIMIT 1
";

$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

$response = ['status' => $row ? $row['user_status'] : 'notjoined'];

echo json_encode($response);
?>
