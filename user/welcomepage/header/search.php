<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION['id'];
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

    $search = $_POST["search"];
    $query = "SELECT distinct title FROM tbl_products WHERE appstatus=1 and userid!='$uid' and archive=0 and avstatus=1";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (stripos($row['title'], $search) !== false) {
                echo "<div class='keyitem' onclick=\"window.location.href='/miniproject/user/products/search/search.php?status=" . urlencode($row['title']) . "'\">" . htmlspecialchars($row['title']) . "</div>";
            }
        }
    } else {
        echo "<div class='keyitem'>No results found</div>";
    }
}
?>