<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php'; 
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="/miniproject/user/cart/saledetails/saledetails.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function setActive(button, url) {
        document.querySelectorAll('.chat-opt button').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        setTimeout(() => {
            window.location.href = url;
        }, 200);
    }

    // Automatically set active state based on current page
    window.onload = function() {
        const currentPage = window.location.pathname;
        document.querySelectorAll('.chat-opt button').forEach(btn => {
            const btnUrl = btn.getAttribute('onclick').match(/'([^']+)'/)[1];
            if (currentPage === btnUrl) {
                btn.classList.add('active');
            }
        });
    }
    </script>
</head>

<body>
<div class="chat-opt">
    <button class="cart-btn" onclick="setActive(this, '/miniproject/user/cart/cartdetails/cartdetails.php')">
        <i class="bi bi-cart4" style="margin-right:10px;"></i>My Cart
    </button>
    <button class="sale-btn" onclick="setActive(this, '/miniproject/user/cart/saledetails/saledetails.php')">
        <i class="bi bi-check-square-fill" style="margin-right:10px;"></i>My Sale
    </button>
</div>

<div class="container">
<h2 style="color:#4B0FBA;"><i class="bi bi-check-square-fill" style="margin-right:10px;"></i>My Sale</h2>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['username'] == '') {
    header("location: /miniproject/user/login/login.php");
    exit();
}
else{
    $uid=$_SESSION['id'];
   include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $query="SELECT * FROM tbl_products where userid='$uid' and archive=0";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            if($row['userid']==$_SESSION['id']&&$row['appstatus']==1)
            {
                isData($row['userid'],$row['productid']);
            }
        }
    }
    else {
        ?> 
        <div class="center-text"><img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy" style="width: 200px; height: auto;">
        <p style="font-weight:bold; font-size:20px;">You are not selling any books</p>

</div>
        <?php
    }
}
function isImage($pid)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $query3="SELECT * FROM tbl_productimage";
    $result3 = $connection->query($query3);
    if ($result3->num_rows > 0) {
        while($row3 = $result3->fetch_assoc()) {
            if($pid==$row3['productid'])
            {
                ?><div class="profile-container">
                <div class="profile-container-image">
                <img  src="data:image/jpeg;base64,<?php echo base64_encode($row3['image']); ?>"/>
            </div>
                
                <?php
                break;
            }
        }
    }
}
function isData($userid,$pid)
{
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
    $query2="SELECT * FROM tbl_products";
    $result2 = $connection->query($query2);
    if ($result2->num_rows > 0) {

        while($row2 = $result2->fetch_assoc()) {
            if($pid==$row2['productid']){
                isImage($row2['productid']);
                ?>
                <div class="sale-details">
               <p><strong>Title: </strong> <?php echo $row2['title']; ?></p>
            <p><strong>Price: </strong> <?php echo $row2['price']; ?>₹</p>
           
            <p><strong>Status: </strong> <?php 
            if($row2['avstatus']==1)
            {
                echo "<span style='color:green; font-weight:bold;'>Available</span>";
            }
            else if($row2['avstatus']==2){
                echo "<span style='color:orangered; font-weight:bold;'>Reserved</span>";
            } 
            else if($row2['avstatus']==3){
                echo "<span style='color:red; font-weight:bold;'>Sold Out</span>";
            }
            ?></p><?php
             if($row2['avstatus']==2)
       {
        ?>
        <div class="soldOrReserve">
            Reserved
       </div>
        <?php
       }
       if($row2['avstatus']==3)
       {
        ?>
        <div class="soldOrReserve">
           Sold Out
       </div>
        <?php
       }
       ?>
            </div>
            <div class="button-container">
            
    <button onclick="window.location.href='/miniproject/user/cart/saledetails/saleitem.php?product_id=<?php echo $row2['productid']; ?>&user-id=<?php echo $row2['userid']; ?>'">Details</button>
    
</div>
           </div>
        <?php
    }
}}}

?>

</div>
<br>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>