<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include '../loginvalid/signup.php';

// Start output buffering
ob_start();

if(isset($_GET['email']))
{
    $emailid = $_GET['email'];
    $email = $emailid;
    $_SESSION['emaill'] = $email;

    $otp = rand(1000, 9999);
    $_SESSION['otp'] = $otp;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rereadbydmv@gmail.com';
        $mail->Password = 'fllt xssh zgpm zgxr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('rereadbydmv@gmail.com', 'ReRead');
        $mail->addAddress($email, 'User');
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'This is your OTP: <b>' . $otp . '</b>';
        $mail->send();
        ob_end_clean(); // Clear buffer before redirect
        header('Location: /miniproject/admin/emailvalid/verifyotp.php');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if(isset($_GET['payprod-id']) && isset($_GET['recseller-id']) && isset($_GET['price']))
{
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $productid = $_GET['payprod-id'];
    $sellerid = $_GET['recseller-id'];
    $price = $_GET['price'];
    $uid = $_SESSION['id'];

    $stmt2 = $connection->prepare("SELECT title FROM tbl_products WHERE productid = ?");
    $stmt2->bind_param("i", $productid); 
    $stmt2->execute();
    $result3 = $stmt2->get_result();
    $tit = $result3->fetch_assoc()['title']; 
    $query = "select email,username,name from tbl_users where id='$sellerid'";
    $result = $connection->query($query);
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $selleremail = $row['email'];
            $sellername = $row['name'];
            $sellerusername = $row['username'];
        }
    }
    $query = "select email,username,name from tbl_users where id='$uid'";
    $result = $connection->query($query);
    if($result->num_rows > 0)
    {
        while($row = $result->fetch_assoc())
        {
            $buyeremail = $row['email'];
            $buyername = $row['name'];
            $buyerusername = $row['username'];
        }
    }

    $msg = "<p>Dear Seller,</p>
    <p>The buyer, <strong>$buyername</strong>, has successfully paid the amount <strong>$price</strong>₹ for the product titled: <strong>$tit</strong>.</p>
    <p>Please contact the buyer for further instructions.</p>
    <p>Best regards,</p>
    <p>[ReRead™]</p>";
    
    $buyer_msg = "<p>Dear $buyername,</p>
    <p>Thank you for your purchase! Your payment of $price ₹ has been successfully processed.</p>
    <p>Your order details:</p>
    <p>Book Title: $tit</p>
    <p>Please contact the seller for further instructions.</p>
    <p>Best regards,</p>
    <p>[ReRead™]</p>";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rereadbydmv@gmail.com';
        $mail->Password = 'fllt xssh zgpm zgxr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('rereadbydmv@gmail.com', 'ReRead');
        $mail->addAddress($selleremail, 'User');
        $mail->isHTML(true);
        $mail->Subject = 'Payment Completion';
        $mail->Body = ': <b>' . $msg . '</b>';
        $mail->send();
        // Removed echo
    } catch (Exception $e) {
        $seller_error = "Seller email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rereadbydmv@gmail.com';
        $mail->Password = 'fllt xssh zgpm zgxr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('rereadbydmv@gmail.com', 'ReRead');
        $mail->addAddress($buyeremail, 'User');
        $mail->isHTML(true);
        $mail->Subject = 'Payment Completion';
        $mail->Body = ': <b>' . $buyer_msg . '</b>';
        $mail->send();
        // Removed echo
    } catch (Exception $e) {
        $buyer_error = "Buyer email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 

    $currdate = date('Y-m-d'); 
    $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message, status) VALUES (?, ?, ?)");
    $msg = "Date: ".$currdate." Dear Seller, The buyer, ".$buyername." has successfully completed the payment for the book titled: $tit. Please arrange to exchange the book with the buyer. If the buyer agrees, you may also cancel the transaction and refund the payment.";
    $stat = 0;
    $stmt1->bind_param("isi", $sellerid, $msg, $stat);
    $stmt1->execute();
    $stmt1->close();
    
    $opt1 = 2;
    $queryinsert = "update tbl_history set method='$opt1', trdate='$currdate', status='$opt1' where productid='$productid' and userid='$uid'";
    $resultinsert = $connection->query($queryinsert);
    $queryinsert = "update tbl_products set avstatus=3 where productid='$productid' and userid='$sellerid'";
    $resultinsert = $connection->query($queryinsert);

    if($resultinsert){
        ob_end_clean(); // Clear previous output
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Success</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Transaction completed successfully',
                    confirmButtonText: 'OK',
                    timerProgressBar: true,
                    willClose: () => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Redirecting...',
                            text: 'Taking you to your purchase history',
                            timer: 4000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                setTimeout(() => {
                                    window.location.href = '/miniproject/user/history/history.php?choice=purchase&opt=pbought';
                                }, 4000);
                            }
                        });
                    }
                });
            </script>
        </body>
        </html>
        <?php
        exit();
    } else {
        ob_end_clean();
        echo "Update failed";
    }
    $connection->close();
}

if (isset($_GET['wishlisttitle']) && isset($_GET['price'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

    $wishtitle = $_GET['wishlisttitle'];
    $wishprice = $_GET['price'];
    
    $stmt = $connection->prepare("SELECT userid FROM tbl_wishlist WHERE LOWER(title) = LOWER(?) AND maxprice >= ?");
    $stmt->bind_param("ss", $wishtitle, $wishprice);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $uid = $row['userid'];
        $stmt1 = $connection->prepare("SELECT email, name FROM tbl_users WHERE id = ?");
        $stmt1->bind_param("i", $uid);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        if ($row1 = $result1->fetch_assoc()) {
            $users[] = ['email' => $row1['email'], 'name' => $row1['name']];
        }
        $stmt1->close();
    }
    $stmt->close();

    if (!empty($users)) {
        $mail = new PHPMailer(true);
        try {
            // Configure PHPMailer once
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rereadbydmv@gmail.com';
            $mail->Password = 'fllt xssh zgpm zgxr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('rereadbydmv@gmail.com', 'ReRead');
            $mail->isHTML(true);
            $mail->Subject = 'Book Added';

            $errors = [];
            foreach ($users as $user) {
                $buyer_msg = "<p>Dear {$user['name']},</p>
                    <p>We are excited to inform you that your dream book is now available!</p>
                    <p><strong>Book Title:</strong> $wishtitle</p>
                    <p>At your affordable price</p>
                    <p>Quickly grab it before someone else does.</p>
                    <p>Best regards,</p>
                    <p>[ReRead™]</p>";

                $mail->clearAddresses(); 
                $mail->addAddress($user['email'], $user['name']);
                $mail->Body = $buyer_msg;

                if (!$mail->send()) {
                    $errors[] = "Failed to send email to {$user['email']}: {$mail->ErrorInfo}";
                }
            }

            
            $stmt2 = $connection->prepare("UPDATE tbl_wishlist SET status = 1 WHERE title = ?");
            $stmt2->bind_param("s", $wishtitle);
            $stmt2->execute();
            $stmt2->close();

            if (!empty($errors)) {
                echo implode("<br>", $errors); // Display any email sending errors
            } else {
                header("Location: /miniproject/admin/adminpage/adminhome.php");
                exit();
            }
        } catch (Exception $e) {
            echo "Email setup failed: {$mail->ErrorInfo}";
        }
    } else {
        echo "No users found for this wishlist item.";
        header("Location: /miniproject/admin/adminpage/adminhome.php");
        exit();
    }

    $connection->close();
}
if(isset($_GET['forgotemail']))
{
    $fmail=$_GET['forgotemail'];
  $_SESSION['emailforgot']=$fmail;
   
    
    $otp = rand(1000, 9999);
    $_SESSION['otp'] = $otp;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rereadbydmv@gmail.com';
        $mail->Password = 'fllt xssh zgpm zgxr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('rereadbydmv@gmail.com', 'ReRead');
        $mail->addAddress($fmail, 'User');
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';
        $mail->Body = 'This is your OTP: <b>' . $otp . '</b>';
        $mail->send();
        ob_end_clean(); // Clear buffer before redirect
        header('Location: /miniproject/user/login/forgetotp.php');
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    } 
}
ob_end_flush(); // Flush any remaining output if we didn't exit
?>