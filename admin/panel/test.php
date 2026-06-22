<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
    header("Location: /miniproject/user/login/login.php");
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

$username = $_SESSION['username'];
$query = "SELECT * FROM tbl_users WHERE username = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/miniproject/admin/panel/test.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="profile-card p-4">
        <div class="row">
            <div class="col-md-4 profile-left">
                <img src="<?php if($user['image']!='') { ?>/miniproject/user/login/loginimg/<?php echo htmlspecialchars($user['username']); ?>.<?php echo pathinfo($user['image'], PATHINFO_EXTENSION); ?> <?php } else { echo "/miniproject/user/login/loginimg/default-profile-pic.png";?> <?php }?>" alt="Profile Picture">
                <div class="change-photo" onclick="window.location.href='/miniproject/admin/panel/editprofile.php'">Edit Profile</div>
            </div>
            
            <div class="col-md-8">
                <h3 class="profile-color"><?php echo htmlspecialchars($user['name']);?></h3>
                <p><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                
                <ul class="nav nav-tabs mt-3" id="profileTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#about">About</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="about">
                        <p><strong>User Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlspecialchars($user['location']); ?></p>
                        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
                        <p><strong>Address:</strong> <?php echo nl2br(htmlspecialchars($user['address'])); ?></p>
                    </div>

                    <ul class="nav nav-tabs mt-3" id="profileTabs">
                        <li class="nav-item" style="margin-top:40px;">
                            <a class="nav-link active" data-bs-toggle="tab" href="#more">More Options</a>
                        </li>
                    </ul>
                    <div class="tab-pane fade show active" id="more">
                        <div class="action-buttons">
                            <a href="/miniproject/user/cart/cartdetails/cartdetails.php" class="action-btn"><i class="fas fa-shopping-cart"></i> My Cart</a>
                            <a href="/miniproject/user/cart/saledetails/saledetails.php" class="action-btn"><i class="fas fa-money-bill-wave"></i>My Sales</a>
                            <a href="/miniproject/user/history/history.php?choice=purchase&opt=preserve" class="action-btn"><i class="fas fa-history"></i> History</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check for success message from profile update
    <?php
    if (isset($_SESSION['success'])) {
        echo "Swal.fire({
            title: 'Success!',
            text: '" . $_SESSION['success'] . "',
            icon: 'success',
            confirmButtonText: 'OK'
        });";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "Swal.fire({
            title: 'Error!',
            text: '" . $_SESSION['error'] . "',
            icon: 'error',
            confirmButtonText: 'OK'
        });";
        unset($_SESSION['error']);
    }
    ?>
});
</script>

<?php $connection->close(); ?>
</body>
</html>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php'; ?>