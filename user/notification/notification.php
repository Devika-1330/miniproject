<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if($_SESSION['username']== '')
{
  header("location: /miniproject/user/login/login.php");
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$check=0;
$userid=$_SESSION['id'];
?>

<html>
<head>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f5f7fa;
    margin: 0;
    padding: 0;
    line-height: 1.5;
}

.container {
    width: 85%;
    max-width: 900px;
    margin: 40px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.container:hover {
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

h2 {
    color: #4B0FBA;
    text-align: center;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.notifymsg {
    background: linear-gradient(135deg, #fdfdfd, #f9f9ff);
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    border-left: 6px solid #4B0FBA;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.notifymsg:hover {
    background: #f0f2ff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}

.notifymsg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(to right, #4B0FBA, transparent);
    opacity: 0.2;
}

.notifymsg span {
    font-size: 20px;
    font-weight: 600;
    display: block;
    margin-bottom: 12px;
    letter-spacing: 0.3px;
}

.cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
    border-top: 1px solid #eee;
    gap: 20px;
}

.logoabt img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    margin-right: 20px;
    border-radius: 50%;
    border: 2px solid #eee;
    transition: transform 0.3s ease;
}

.logoabt img:hover {
    transform: scale(1.1);
}

.notify {
    font-size: 16px;
    color: #333;
    line-height: 1.7;
    flex-grow: 1;
}

.notify a {
    color: #4B0FBA;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.notify a:hover {
    color: #360b8a;
    text-decoration: underline;
}

.cart-actions {
    display: flex;
    gap: 15px;
    padding: 0;
}

.delete-btn, .details-btn {
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.delete-btn {
    background: #ff4d4d;
    color: white;
}

.delete-btn:hover {
    background: #e63939;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 77, 77, 0.3);
}

.details-btn {
    background: #4B0FBA;
    color: white;
}

.details-btn:hover {
    background: #3a0c9a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(75, 15, 186, 0.3);
}

.nomsg {
    text-align: center;
    font-size: 24px;
    font-weight: 600;
    color: #777;
    margin-top: 40px;
    padding: 20px;
}

.nomsg img {
    width: 220px;
    margin-bottom: 20px;
    opacity: 0.9;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-15px);
    }
    60% {
        transform: translateY(-8px);
    }
}

@media screen and (max-width: 768px) {
    .container {
        width: 90%;
        padding: 20px;
    }
    h2 {
        font-size: 26px;
    }
    .cart-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    .cart-actions {
        width: 100%;
        justify-content: flex-end;
    }
    .notifymsg span {
        font-size: 18px;
    }
    .notify {
        font-size: 15px;
    }
}
</style>
</head>
<body>
<div class="container">
    <h2 style="color:#4B0FBA;"><i class="bi bi-bell" style="margin-right:10px;"></i>Notifications</h2>
   
    <?php
   
    $stmt = "UPDATE tbl_notification set status=1  WHERE userid = '$userid'";
    $stmt = $connection->prepare($stmt);
    $stmt->execute();

    $query="select * from tbl_notification where userid='$userid' order by noid desc";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    $check=1;
    while ($row = $result->fetch_assoc()) {
      ?>
        <div class="notifymsg"> <?php
        if(stripos($row['message'],'not been approved') !== false) { 
           
            ?>
            <span style="color:red;">
                Request Not Approved
            </span>
            <?php      
        }
        if(stripos($row['message'],'has been approved') !== false) { 
          
            ?>
            <span style="color:green;">
                Request Approved
            </span>
            <?php      
        }
        ?> <?php
         if(stripos($row['message'],'no longer') !== false) {
             ?>
            <span style="color:red;">
                Book Removed
            </span>
            <?php   
              
        }
        ?><?php
         if(stripos($row['message'],'has canceled their reservation') !== false) {
            ?>
            <span style="color:red;">
                Canceled Reservaion
            </span>
            <?php   
              
        }
        ?>
        <?php
         if(stripos($row['message'],'confirming that the exchange has been successfully completed') !== false) {
           
            ?>
            <span style="color:green;">
                Exchange Completed
            </span>
            <?php   
              
        }
        ?>
         <?php
         if(stripos($row['message'],'Please coordinate with the seller to arrange the exchange.') !== false) {
         
            ?>
            <span style="color:green;">
                Transaction Completed
            </span>
            <?php   
              
        }
        ?>
        <?php
         if(stripos($row['message'],'has been reserved for you by the seller.') !== false) {
              ?>
            <span style="color:green;">
                Book Reserved
            </span>
            <?php   
              
        }
        ?>
         <?php
         if(stripos($row['message'],' Please contact the seller directly for a refund or further assistance') !== false) {
            ?>
            <span style="color:red;">
                Exchange Canceled
            </span>
            <?php   
              
        } ?>
         <?php
         if(stripos($row['message'],' has successfully completed the payment') !== false) {
            ?>
            <span style="color:green;">
                Payment Completed
            </span>
            <?php   
              
        } ?>
      
      <?php
         if(stripos($row['message'],'Since your purchase and exchange are complete') !== false) {
           
          ?>
            <span style="color:green;">
                Book Removed
            </span>
            <?php   
              
        } ?>
        <?php
         if(stripos($row['message'],'A user has sent you a message regarding the purchase of your book') !== false) {
           
            ?>
              <span style="color:green;">
                  New Message
              </span>
              <?php   
         } 

        ?>
        <div class="cart-item">
        <div class="logoabt"><img src="/miniproject/user/welcomepage/header/logorr.png"></div>  
         <div class="notify"><?php
        $pattern = '/\b\d{4}-\d{2}-\d{2}\b/';
        if (preg_match($pattern, $row['message'], $matches, PREG_OFFSET_CAPTURE)) {
            $date = $matches[0][0]; 
            $pos = $matches[0][1] + strlen($date); 
        
            
            $first_part = substr($row['message'], 0, $pos);
            $second_part = trim(substr($row['message'], $pos));
            
            echo "<p style='font-weight:bold; color:grey;'>"  . $first_part,"</p><p>$second_part</p>"; 
        } else {
            echo $row['message'],"<br>";
            
        }
       
       
        ?><br>Also Check The 
        <a href="/miniproject/user/welcomepage/footer/t&c.php">Terms & Conditions</a>
        <br>
        </div>
        <div class="cart-actions">
                        <button class="delete-btn" onclick="window.location.href = '/miniproject/user/notification/deletenotifi.php?noid=<?php echo $row['noid']; ?>';"><i class="bi bi-trash3"></i></button>
                    
                    </div>
    </div>
    </div><?php
    }
}
if($check==0)
{ ?><div class="notifymsg"> <div class="cart-item">
     <div class="center-text" style="width:100%; display:flex; flex-direction:column; align-items:center;"><img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy" style="width: 200px; height: auto;">
        <p style="font-weight:bold; font-size:20px;">You don't have any notifications</p>

</div>
</div>
</div><?php
}
?>

</div>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>


