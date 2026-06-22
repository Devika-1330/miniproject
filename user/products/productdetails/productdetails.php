<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<html lang="en">
<head>
<link rel="stylesheet" href="/miniproject/user/products/productdetails/productdetails.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<!-- Add SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showimage(img){
        if(document.getElementById('modal').style.display=="none")
  {
    document.getElementById('modal-img').src = img.src;
    document.getElementById('modal').style.display = 'block';
  }
        else
        document.getElementById('modal').style.display = 'none';
    }

    // Add function for cart addition with SweetAlert
    function addToCart(productId, sellerId) {
        Swal.fire({
            title: 'Added to CArt',
            text: 'Item successfuly added to cart',
            icon: 'success',
            showConfirmButton: true,
            
        }).then(() => {
          
            window.location.href = `/miniproject/user/cart/cart.php?productid=${productId}&sellerid=${sellerId}`;
        });
    }
</script>
</head>
<body>

<?php
  include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

$flag=1;
if(isset($_GET['statuscart']))
{
    $flag=0;
}
if(isset($_GET['product_id']))
{
    $productid=$_GET['product_id'];
    $userid=$_GET['user-id'];
    
    $query = "select * from tbl_products where productid='$productid'";
    $result = $connection->query($query);
    $query2="SELECT * FROM tbl_productimage";
    $result2 = $connection->query($query2);
    $query3="SELECT * FROM tbl_usercart";
    $result3=$connection->query($query3);
    while($row3 = $result3->fetch_assoc()) {
        if($row3['productid']==$productid&&$_SESSION['id']==$row3['userid'])
        {
            $flag=0;
            break;
        }
    }
    ?>
    <div class="container">
        <div class="product">
            <div class="image-section">
                <div class="image-gallery" id="image-gallery">
                <?php
                if ($result->num_rows > 0) {
    if ($result2->num_rows > 0) {
        $i=0;
        while($row2 = $result2->fetch_assoc()) {
            if($productid==$row2['productid'])
                        {
                            $i++;
                            ?>                  
                             <img  id="img" src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>"  onclick="showimage(this)"/>
                             <div id="modal" style="display: none;">
                                <div class="modal-right">
<button id="show-modal" onclick="showimage()">x</button></div>
<img id="modal-img" src="">
</div>
<?php
        }
    }
}
?>
                </div>
            </div>
            <div class="details-section">
                <div class="highlights">
                <?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if($productid==$row['productid'])
     {?>
      <p><strong>Title: </strong> <?php echo $row['title']; $prodid=$row['productid']; $tit=$row['title']; ?></p>
      <p class="price"><strong>Price: </strong> <?php echo $row['price']; ?>₹</p>
            <p><strong>Genre: </strong> <?php echo $row['genre']; $loc=$row['genre']; ?></p>
            <p><strong>seller: </strong> <?php 
             $stmt = $connection->prepare("SELECT name FROM tbl_users WHERE id = ?");
             $stmt->bind_param("i", $row['userid']); 
             $stmt->execute();
             $result2 = $stmt->get_result();
             $name = $result2->fetch_assoc()['name']; 
             echo $name;
            ?></p>
            <p><strong>Listed for sale: </strong> <?php 
            $currentDateTime = strtotime(date("Y-m-d H:i:s"));
            $soldDateTime = strtotime($row['date']);
            $diff = abs($currentDateTime - $soldDateTime);
            $days = floor($diff / (60 * 60 * 24));
            if($days==0)
            {
                echo "Today";
            }else{
            echo $days . " days ago";}
            ?></p> 
            <p><strong>Location: </strong> <?php  
            $usersid=$row['userid'];
            $stmt2 = $connection->prepare("SELECT location FROM tbl_users WHERE id = ?");
            $stmt2->bind_param("i", $userid); 
            $stmt2->execute();
            $result3 = $stmt2->get_result();
            $location=$result3->fetch_assoc()['location'];
            echo $location;
            ?></p>
             <p><strong>Status: </strong> <?php 
            if($row['avstatus']==1)
            {
                echo "<span style='color:green; font-weight:bold; font-size:18px; '>Available</span>";
            }
            else if($row['avstatus']==2){
                echo "<span style='color:orangered; font-weight:bold; font-size:18px; '>Reserved</span>";
                 echo "<script> window.onload = function() { document.getElementById('valid').style.display='none';
                }; </script>";
            } 
            else{
                echo "<span style='color:orangered; font-weight:bold; font-size:18px; '>Sold Out</span>";
                echo "<script> window.onload = function() { document.getElementById('valid').style.display='none';
                document.getElementById('valid2').style.display='none';
                }; </script>";
            }
            ?></p>
            <p><strong>Condition: </strong></p>
            <div class="qlty">
            <p><?php echo $row['bkcondition']; ?></p>
            </div>
                </div>
                <div class="quality-info">
                <p><strong>Quality Assurance:</strong> This product has been carefully evaluated and is listed by a trusted user of our platform.</p>
<p>We ensure that you receive a genuine, high-quality book every time.</p>
                </div>
                <button id="valid" class="bttn" onclick="window.location.href='/miniproject/admin/addchat/addchat.php?product-id=<?php echo $row['productid']; ?>&seller-id=<?php echo $row['userid']; ?>'">Chat With Seller</button>
                <!-- Modified Add To Cart button to use SweetAlert -->
                <button id="valid2" class="bttn" onclick="addToCart('<?php echo $row['productid']; ?>', '<?php echo $row['userid']; ?>')">Add To Cart</button>
                <?php 
    if($flag==0) {
        echo "<p style='font-weight:bold; margin-top:10px; font-size:18px;'>Added To Cart</p>";
    }?>
            </div>
        </div><br>
        <div class="avbooks">ReRead Assures</div>
        <div class="assurance-section">
            <div class="assurance-item">
            <i class="bi-people-fill"></i>
                <p>Trusted Users</p>
            </div>
            <div class="assurance-item">
            <i class="bi bi-check-circle"></i>
                <p>Quality-Checked Books</p>
            </div>
            <div class="assurance-item">
            <i class="bi bi-book"></i>
                <p>Get what you see</p>
            </div>
            <div class="assurance-item">
            <i class="bi bi-emoji-laughing"></i>
                <p>No Extra Charges</p>
            </div>
        </div>
        <div class="description">
        <h2> Description</h2><p> <?php 
            echo '<html>' . str_replace("\n", "<br>", htmlspecialchars($row['description'])) . '</html>';?>
            </div>
            <div class="mt-5 p-4 bg-white text-dark rounded border mx-auto" style="width: 100%;">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold">Buyer Guidelines</h3>
                <a href="#" class="text-primary fw-bold">Know More</a>
            </div>
            <ul class="list-unstyled mt-3">
                <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Be careful when paying offline</li>
                <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Beware of ads with unrealistic prices, lookalikes or clone products</li>
                <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Chat and ask questions to be clear on product details</li>
                <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Do not deposit/transfer money to bank or any third-party payment gateways without verifying the credentials</li>
            </ul>
        </div>
        </div>
        <?php } }

} }
else{
    ?>
    <div class="center-text"><overlayScrollbarsimg src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy" style="width: 200px; height: auto;">
        <p style="font-weight:bold; font-size:20px;">You are not selling any books</p>
</div> <?php
}
}
$connection->close();
?>
    </div>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/products/productdetails/similarproducts.php';
?>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>