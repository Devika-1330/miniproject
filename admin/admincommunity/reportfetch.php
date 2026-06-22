<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
?>

<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmBan(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to ban this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ban user!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/miniproject/admin/admincommunity/admincommunityopr.php?banusr=' + userId;
            }
        })
    }

    function confirmRemove(messageId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to remove this message?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/miniproject/admin/admincommunity/admincommunityopr.php?remmsg=' + messageId;
            }
        })
    }

    function confirmDelete(reportId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this report?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/miniproject/admin/admincommunity/admincommunityopr.php?delrep=' + reportId;
            }
        })
    }
    </script>
</head>
<body>
<?php
$query = "SELECT * FROM tbl_reports";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) { 
    $cid = $row['message_id'];
    $query2 = "SELECT * FROM tbl_community_msgs WHERE msgid = ?";
    $stmt2 = $connection->prepare($query2);
    $stmt2->bind_param("i", $cid);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    while($row2 = $result2->fetch_assoc()) {
?>
    <div class="request-item">
        <div class="details">
            <p><strong>Reported By:</strong>
            <?php
            $uid = $row['reported_by'];
            $reporter = "SELECT username, name FROM tbl_users WHERE id = ?";
            $stmt3 = $connection->prepare($reporter);
            $stmt3->bind_param("i", $uid);
            $stmt3->execute();
            $resultreporter = $stmt3->get_result();

            if ($resultreporter->num_rows > 0) {
                while ($reportrow = $resultreporter->fetch_assoc()) {
                    echo htmlspecialchars($reportrow['name']) . " (" . htmlspecialchars($reportrow['username']) . ")";
                }
            }
            ?></p>
            
            <p><strong>Message:</strong> <?php echo htmlspecialchars($row2['message']); ?></p>

            <p><strong>Image/Sticker</strong></p>
            <?php if ($row2['image'] != '') { ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" 
                class="img-fluid rounded" 
                style="max-width: 200px; max-height: 200px; object-fit: fill;">
            <?php } ?>

            <p><strong>Message By:</strong>
            <?php
            $uid = $row2['userid'];
            $messager = "SELECT username, name FROM tbl_users WHERE id = ?";
            $stmt4 = $connection->prepare($messager);
            $stmt4->bind_param("i", $uid);
            $stmt4->execute();
            $resultmessager = $stmt4->get_result();

            if ($resultmessager->num_rows > 0) {
                while ($reportmsg = $resultmessager->fetch_assoc()) {
                    echo htmlspecialchars($reportmsg['name']) . " (" . htmlspecialchars($reportmsg['username']) . ")";
                }
            }
            ?></p>
             <p><strong>Reason: </strong> <span style="color: red;"><?php echo htmlspecialchars($row['reason']); ?></span>
             </p>
        </div>

        <!-- Actions Dropdown -->
        <div class="actions">
            <button class="btn" onclick="toggleActions(this)">Actions</button>
            <div class="dropdown-menu">
                <button onclick="confirmBan(<?php echo $row2['userid']; ?>)">Kick Messager</button>
                <button onclick="confirmRemove(<?php echo $row2['msgid']; ?>)">Remove Message</button>
                <button onclick="confirmDelete(<?php echo $row['repid']; ?>)">Delete Report</button>
            </div>
        </div>
    </div>
<?php 
    }
}
?>
</body>
</html>