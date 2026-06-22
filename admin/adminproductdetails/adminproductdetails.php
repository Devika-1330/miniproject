<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['adminid'])) {
    header("location: /miniproject/user/login/login.php");
exit();
}
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/admin/sidebar.php';
?>
<html lang="en">
<head>
<link rel="stylesheet" href="/miniproject/user/products/productdetails/productdetails.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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

    </script>
    <style>
        .main-content {
    margin-left: 270px;
    padding: 20px;
}
        </style>
</head>
<body>

<?php
  include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';



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
        if($row3['productid']==$productid)
        {
            $flag=0;
            break;
        }
    }
    ?>
    <div class="main-content">
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
               
               
                
            </div>
        </div><br>
        
        
        </div>
        <?php } }

} }

}
$connection->close();
?>
</div>
    </div>
</body>
</html>

