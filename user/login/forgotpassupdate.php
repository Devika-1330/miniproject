<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_GET['npass'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php'; 
    $newpass = $_GET['npass'];
    $email = $_SESSION['emailforgot'];
    
    $query = "SELECT id,username FROM tbl_users WHERE email='$email'";
    $result = $connection->query($query);
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uid = $row['id'];
        $uname=$row['username'];
        $query = "UPDATE tbl_logininfo SET password='$newpass' WHERE userid='$uid' and username='$uname'";
        $result = $connection->query($query);
        
        if($result) {
            // Output SweetAlert JavaScript
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Password updated successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '/miniproject/user/login/login.php';
                        }
                    });
                });
            </script>";
        }
    }
}
?>