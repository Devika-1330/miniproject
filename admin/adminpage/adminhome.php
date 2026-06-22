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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ReRead</title>
    <link rel="stylesheet" href="/miniproject/admin/adminpage/adminhome.css">
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/admin/sidebar.php'; ?>

<div class="main-content">
    <h1>Admin Dashboard</h1>

    <div class="dashboard">
        <div class="card" id="totalbooks" style="cursor:pointer;" onclick="window.location.href='/miniproject/admin/adminpage/viewproducts/view.php'">
            <h3>📚 Total Books</h3>
            <p><span id="total-books-count"><?php
                $query = "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $count1 = $result->fetch_assoc();
                $stmt->close();
                echo $count1['total'];
            ?></span></p>
        </div>
        <div class="card">
            <h3>👤 Total Users</h3>
            <p><span id="total-users-count"><?php
                $query = "SELECT COUNT(*) AS total FROM tbl_users";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $count = $result->fetch_assoc();
                $stmt->close();
                echo $count['total'];
            ?></span></p>
        </div>
        <div class="card" id="totalbooks" style="cursor:pointer;" onclick="window.location.href='/miniproject/admin/admincommunity/admincommunity.php'">
            <h3>👥 Community Reports</h3>
            <p><span id="community-requests-count"><?php
                $query = "SELECT COUNT(*) AS total FROM tbl_reports";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                $count = $result->fetch_assoc();
                $stmt->close();
                echo $count['total'];
            ?></span></p>
        </div>
    </div>

    <div class="table-container">
        <h2>Book Exchange History</h2>
        <table>
            <tr><th colspan="4" style="text-align:center;">Status</th></tr>
            <tr>
                <td colspan="2">Available Books</td>
                <td style="text-align:right;"><span style="color: green;" id="available-books-count"><?php
                    $query = "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND avstatus=1 AND archive=0";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count1 = $result->fetch_assoc();
                    $stmt->close();
                    echo $count1['total'];
                ?></span></td>
                <td style="text-align:right;"><button class="btn" onclick="window.location.href='/miniproject/admin/adminpage/viewproducts/view.php?status=avbooks'">View</button></td>
            </tr>
            <tr>
                <td colspan="2">Reserved Books</td>
                <td style="text-align:right;"><span style="color: green;" id="reserved-books-count"><?php
                    $query = "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND avstatus=2 AND archive=0";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count1 = $result->fetch_assoc();
                    $stmt->close();
                    echo $count1['total'];
                ?></span></td>
                <td style="text-align:right;"><button class="btn" onclick="window.location.href='/miniproject/admin/adminpage/viewproducts/view.php?status=resbooks'">View</button></td>
            </tr>
            <tr>
                <td colspan="2">Sold Out Books</td>
                <td style="text-align:right;"><span style="color: green;" id="sold-out-books-count"><?php
                    $query = "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND avstatus=3 AND (archive=0 OR archive=1)";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count1 = $result->fetch_assoc();
                    $stmt->close();
                    echo $count1['total'];
                ?></span></td>
                <td style="text-align:right;"><button class="btn" onclick="window.location.href='/miniproject/admin/adminpage/viewproducts/view.php?status=soldbooks'">View</button></td>
            </tr>
            <tr>
                <td colspan="2">Archived Books</td>
                <td style="text-align:right;"><span style="color: green;" id="archived-books-count"><?php
                    $query = "SELECT COUNT(*) AS total FROM tbl_products WHERE appstatus=1 AND archive=1";
                    $stmt = $connection->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $count1 = $result->fetch_assoc();
                    $stmt->close();
                    echo $count1['total'];
                ?></span></td>
                <td style="text-align:right;"><button class="btn" onclick="window.location.href='/miniproject/admin/adminpage/viewproducts/view.php?status=arcbooks'">View</button></td>
            </tr>
        </table>
    </div>

    <div class="request-container">
        <h2>📥 User Book Requests</h2>
        <div class="request-box">
            <div class="request-list" id="request-list">
                <?php
                $query = "SELECT * FROM tbl_products WHERE appstatus=0";
                $stmt = $connection->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="request-item" onclick="window.location.href='/miniproject/admin/productvalid/productvalid.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                        <div class="details">
                            <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                            <p><strong>Price:</strong> <?php echo htmlspecialchars($row['price']); ?> ₹</p>
                        </div>
                        <button class="btn">Details</button>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script>
    
    setInterval(() => {
        fetch("/miniproject/admin/adminpage/loadrequest.php") 
            .then(response => response.text())
            .then(data => {
                let chatDiv = document.getElementById("request-list");
                if (chatDiv.innerHTML !== data) {
                    chatDiv.innerHTML = data;
                }
            })
            .catch(error => console.error("Error:", error));
    }, 5000);


    setInterval(() => {
        fetch("/miniproject/admin/adminpage/loaddash.php")
            .then(response => response.json())
            .then(data => {
            
                document.getElementById("total-books-count").textContent = data.total_books;
                document.getElementById("total-users-count").textContent = data.total_users;
                document.getElementById("community-requests-count").textContent = data.community_requests;
            
                document.getElementById("available-books-count").textContent = data.available_books;
                document.getElementById("reserved-books-count").textContent = data.reserved_books;
                document.getElementById("sold-out-books-count").textContent = data.sold_out_books;
                document.getElementById("archived-books-count").textContent = data.archived_books;
            })
            .catch(error => console.error("Error fetching dashboard counts:", error));
    }, 5000);
</script>
</body>
</html>