<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$flag = 1;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$query = "SELECT * FROM tbl_products WHERE archive = 0 AND avstatus = 1";
$result = $connection->query($query);

$output = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $query2 = "SELECT * FROM tbl_productimage";
        $result2 = $connection->query($query2);
        $flag = 1;

        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                if ($row['productid'] == $row2['productid'] && $row['userid'] != $_SESSION['id'] && $flag != 0 && $row['appstatus'] == 1) {
                    $productUrl = "/miniproject/user/products/productdetails/productdetails.php?product_id=" . $row['productid'] . "&user-id=" . $row['userid'];
                    $imageSrc = "data:image/jpeg;base64," . base64_encode($row2['image']);
                    $title = htmlspecialchars($row['title']);
                    $price = htmlspecialchars($row['price']) . "₹";
                    $currentDateTime = strtotime(date("Y-m-d H:i:s"));
                    $soldDateTime = strtotime($row['date']);
                    $diff = abs($currentDateTime - $soldDateTime);
                    $days = floor($diff / (60 * 60 * 24));
                    $postedTime = ($days == 0) ? "Today" : $days . " days ago";

                    $output .= '<div class="profile-container" onclick="window.location.href=\'' . $productUrl . '\'">';
                    $output .= '<img src="' . $imageSrc . '" alt="' . $title . '"/>';
                    $output .= '<p class="title">' . $title . '</p>';
                    $output .= '<p class="price">' . $price . '</p>';
                    $output .= '<p class="posted">Posted: ' . $postedTime . '</p>';
                    $output.=  '<a class="btn">View Details</a>';
                    $output .= '</div>';

                    $flag = 0;
                }
            }
        }
    }
} else {
    $output .= '<p class="no-profile">No Profile Found</p>';
}

echo $output;
?>