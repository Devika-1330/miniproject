<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    
    $search = trim($_POST["search"]);
    
    if (!empty($search)) {
        $uid=$_SESSION['id'];
        $query = "SELECT DISTINCT u.username, u.name 
        FROM tbl_users u
        INNER JOIN tbl_community c ON u.id = c.userid
        WHERE (u.username LIKE ? OR u.name LIKE ?) and u.id != '$uid' and c.status=0
        LIMIT 5";
        $stmt = $connection->prepare($query);
        $searchTerm = "%" . $search . "%";
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $displayName = htmlspecialchars($row['name'] . ' (@' . $row['username'] . ')');
                echo "<div class='keyitem1' style='padding: 8px; cursor: pointer; border-bottom: 1px solid #eee;'>" 
                    . $displayName 
                    . "</div>";
            }
        } else {
            echo "<div class='keyitem' style='padding: 8px;'>No users found</div>";
        }
        
        $stmt->close();
    }
    
    $connection->close();
}
?>