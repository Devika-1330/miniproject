<?php

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$query = "SELECT * FROM tbl_products WHERE appstatus=0";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) { 
    echo '<div class="request-item" onclick="window.location.href=\'/miniproject/admin/productvalid/productvalid.php?product_id=' . 
         htmlspecialchars($row['productid']) . '&user-id=' . 
         htmlspecialchars($row['userid']) . '\'">';

    echo '<div class="details">';
    echo '<p><strong>Title:</strong> ' . htmlspecialchars($row['title']) . '</p>';
    echo '<p><strong>Price:</strong> ' . htmlspecialchars($row['price']) . ' ₹</p>';
    echo '</div>';
    
    echo '<button class="btn">Details</button>';
    echo '</div>';
} 
?>