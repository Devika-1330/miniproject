<?php

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['adminid'])) {
    header("location: /miniproject/user/login/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
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

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ReRead</title>
    <style>
        
.main-content h1{
    margin: 15px;
}
.main-content {
    margin-left: 270px;
    padding: 20px;
}
.dashboard {
    display: flex;
    justify-content: space-around;
    text-align: center;
}
.card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 30%;
    margin: 10px;
}
.card h3 {
    color: #6a0dad;
}
.table-container {
    margin-top: 20px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
th, td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: left;
}
th {
    background-color: #6a0dad;
    color: white;
}
/* Main container for the request list */
.request-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 800px;
    margin: auto;
}

/* Each request item (book request) */
.request-item {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Ensures horizontal alignment */
    padding: 15px;
    border-radius: 10px;
    background: white;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
    cursor: pointer;
}

.request-item:hover {
    transform: scale(1.02); /* Slight zoom effect on hover */
}

/* Styling for the book details */
.details {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

/* Title styling */
.details p {
    margin: 5px 0;
    font-size: 14px;
    color: #444;
}

.details strong {
    color: #6a0dad;
}

/* Accept Button */
.btn {
    background: #6a0dad;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s ease-in-out;
    white-space: nowrap; /* Prevents button text from wrapping */
}

.btn:hover {
    background: #8136c5;
}
#totalbooks{
    cursor: pointer;
}
#totalbooks:hover{
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: translateY(-4px);
}
.actions {
    position: relative;
    display: inline-block;
}

.dropdown-menu {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 150px;
    z-index: 10;
}

.dropdown-menu button {
    display: block;
    width: 100%;
    background: none;
    border: none;
    padding: 8px 12px;
    text-align: left;
    cursor: pointer;
    color: #6a0dad;
}

.dropdown-menu button:hover {
    background-color: #f3f3f3;
}

/* Responsive Design */
@media (max-width: 600px) {
    .request-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn {
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }
}

        </style>

</head>
<body>
<script>
    function toggleActions(btn) {
        const menu = btn.nextElementSibling;
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    function kickMessager(userId) {
        if (confirm('Are you sure you want to kick this user?')) {
            fetch(`/miniproject/admin/actions/kick_user.php?userid=${userId}`)
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error('Error:', error));
        }
    }

    function blockMessager(userId) {
        if (confirm('Are you sure you want to block this user?')) {
            fetch(`/miniproject/admin/actions/block_user.php?userid=${userId}`)
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error('Error:', error));
        }
    }

    function removeMessage(msgId) {
        if (confirm('Are you sure you want to remove this message?')) {
            fetch(`/miniproject/admin/actions/remove_message.php?msgid=${msgId}`)
                .then(response => response.text())
                .then(data => alert(data))
                .catch(error => console.error('Error:', error));
        }
    }
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/admin/sidebar.php'; ?>

<div class="main-content">


    <div class="request-container">
        <h2>📥 Community Message Reports</h2>

        <div class="request-box">
        <div class="request-list" id="request-list">
                <?php 
                $query = "SELECT * FROM tbl_reports";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                while($row = $result->fetch_assoc()) { 
                    $cid=$row['message_id'];
                    $query2="select * from tbl_community_msgs where msgid= '$cid'";
                    $stmt2 = $connection->prepare($query2);
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    while($row2=$result2->fetch_assoc())
                    {
                    ?>
                    <div class="request-item">

                        <div class="details">
                            <p><strong>Reported By: </strong>
                            <?php
                            $uid=$row['reported_by'];
                            $reporter="select username,name from tbl_users where id = '$uid'";
                            $resultreporter=$connection->query($reporter);
                            if($resultreporter->num_rows>0)
                            {
                                while($reportrow=$resultreporter->fetch_assoc())
                                {
                                    echo $reportrow['name'],"(",$reportrow['username'],")";
                                }
                            }
                            ?></p>
                            <p><strong>Message:</strong> <?php echo htmlspecialchars($row2['message']); ?></p>
                            <p><strong>Image/Sticker</strong></p>
                            <p> <?php if($row2['image']!='') { ?> <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" class="img-fluid rounded" style="max-height: 400px; object-fit: cover;">
                                <?php } ?>
                            <p><strong>Message By: </strong>
                            <?php
                            $uid=$row2['userid'];
                            $messager="select username,name from tbl_users where id = '$uid'";
                            $resultmessager=$connection->query($messager);
                            if($resultmessager->num_rows>0)
                            {
                                while($reportmsg=$resultmessager->fetch_assoc())
                                {
                                    echo $reportmsg['name'],"(",$reportmsg['username'],")";
                                }
                            }
                            ?></p>
                        </div>
                        <button class="btn" > Actions</button>
                    </div>
                <?php } } ?>
    </div>

        </div>

        
    </div>

</div>

   <script>
    function loadRequests() {
        fetch("/miniproject/admin/admincommunity/reportfetch.php")
        .then(response => response.text())
        .then(data => {
            let chatDiv = document.getElementById("request-list");
            if (chatDiv.innerHTML !== data) {
                chatDiv.innerHTML = data;
            }
        })
        .catch(error => console.error("Error:", error));
    }

 
    setInterval(loadRequests, 5000);

    
    window.onload = loadRequests;


    </script>
</body>

</html>
