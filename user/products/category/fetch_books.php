<?php

ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();}

header('Content-Type: application/json');


include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

$response = [
    'count' => 0,
    'html' => '',
    'error' => null
];

try {
    if (!isset($_SESSION['id'])) {
        throw new Exception('User not logged in');
    }

    $minprice = isset($_POST['minprice']) ? floatval($_POST['minprice']) : 0;
    $maxprice = isset($_POST['maxprice']) ? floatval($_POST['maxprice']) : 100000;
    $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
    $uid = $_SESSION['id'];

    if (!$connection) {
        throw new Exception('Database connection failed');
    }

    // Get count
    $query = "SELECT COUNT(*) AS total FROM tbl_products WHERE archive=0 AND avstatus=1 AND appstatus=1 AND userid != ? AND price > ? AND price <= ? AND genre = ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $connection->error);
    }
    $stmt->bind_param("siis", $uid, $minprice, $maxprice, $genre);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $result = $stmt->get_result();
    $response['count'] = $result->fetch_assoc()['total'];
    $stmt->close();

    // Get books
    $html = '';
    $query = "SELECT * FROM tbl_products WHERE archive=0 AND avstatus=1 AND appstatus=1 AND userid != ? AND price > ? AND price <= ? AND genre = ?";
    $stmt = $connection->prepare($query);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $connection->error);
    }
    $stmt->bind_param("siis", $uid, $minprice, $maxprice, $genre);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }
    $result = $stmt->get_result();

    $check = 0;
    while ($row = $result->fetch_assoc()) {
        $query2 = "SELECT * FROM tbl_productimage WHERE productid = ? LIMIT 1";
        $stmt2 = $connection->prepare($query2);
        if (!$stmt2) {
            continue;
        }
        $stmt2->bind_param("s", $row['productid']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $check = 1;
            $days = floor((strtotime(date("Y-m-d H:i:s")) - strtotime($row['date'])) / (60 * 60 * 24));
            $posted = $days == 0 ? "Today" : "$days days ago";

            $html .= "
                <div class='profile-container' onclick=\"window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id={$row['productid']}&user-id={$row['userid']}'\">
                    <img src='data:image/jpeg;base64," . base64_encode($row2['image']) . "' alt='" . htmlspecialchars($row['title']) . "'/>
                    <p class='title'>" . htmlspecialchars($row['title']) . "</p>
                    <p class='price'>{$row['price']}₹</p>
                    <p class='posted'>Posted: {$posted}</p>
                    <a href='/miniproject/user/products/productdetails/productdetails.php?product_id={$row['productid']}&user-id={$row['userid']}' class='btn'>View Details</a>
                </div>";
        }
        $stmt2->close();
    }

    if ($check == 0) {
        $html = "<div class='center-text'>
            <img src='/miniproject/user/userchat/nomsg/text-phone.gif' alt='No Books' loading='lazy'>
            <p>No books available currently</p>
        </div>";
    }

    $stmt->close();
    $response['html'] = $html;

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['html'] = "<div class='center-text'><p>Error: {$e->getMessage()}</p></div>";
}


ob_end_clean();
echo json_encode($response);
exit; 
?>