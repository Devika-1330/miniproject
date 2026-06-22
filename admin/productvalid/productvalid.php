
<?php
  include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/admin/sidebar.php';

?>
<html lang="en">
<head>
<link rel="stylesheet" href="/miniproject/admin/productvalid/productvalid.css">
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
</head>
<body>

<?php


$flag=1;

if(isset($_GET['product_id']))
{
    $productid=$_GET['product_id'];
    $userid=$_GET['user-id'];
    
    $query = "select * from tbl_products";
    $result = $connection->query($query);
    $query2="SELECT * FROM tbl_productimage";
    $result2 = $connection->query($query2);?>
    <div class="container">
        <div class="product">
            <div class="image-section">
                
                <div class="image-gallery" id="image-gallery">
                <?php
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
      <p class="price"><strong>Price: </strong> <?php echo $row['price']; $price=$row['price']; ?>₹</p>
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
                echo "Available";
            }
            else{
                echo "Reserved";
            } 
            ?></p>
              <p><strong>Condition: </strong></p>
            <div class="qlty">
            <p><?php echo $row['bkcondition']; ?></p>
            </div>
                </div>
                <div class="button-group">
    <button class="approve-btn" onclick="window.location.href='/miniproject/admin/productvalid/productvalid.php?productid=<?php echo $row['productid']; ?>&userid=<?php echo $row['userid']; ?>&title=<?php echo $tit; ?>'">✅ Approve</button>
    <button class="decline-btn" onclick="window.location.href='/miniproject/admin/productvalid/productvalid.php?delpid=<?php echo $row['productid']; ?>&userid=<?php echo $row['userid']; ?>&title=<?php echo $tit; ?>'">❌ Decline</button>
</div>
            </div>
            <div class="description">
        <h2> Description</h2><p> <?php 
            echo '<html>' . str_replace("\n", "<br>", htmlspecialchars($row['description'])) . '</html>';?>
            </div>
            <div class="mt-5 p-4 bg-white text-dark rounded shadow border mx-auto" style="width: 100%;">
            
            
        </div>
        
        </div>
        

        <?php } }

} }
 if(isset($_GET['productid'])&&isset($_GET['userid']))
 {
    $productid=$_GET['productid'];
    $userid=$_GET['userid'];
    $tit=$_GET['title'];
    $stmt = "UPDATE tbl_products set appstatus=1  WHERE productid = '$productid' and userid = '$userid'";
    $stmt = $connection->prepare($stmt);
    if($stmt->execute())
    {
        $currdate = date('Y-m-d'); 
        $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
        $msg = "Date: ".$currdate." We are pleased to inform you that your request for the title: " . $tit . " has been approved.  
Your listing is now live, and interested buyers can view it.  
Make sure to check your messages regularly for any inquiries from potential buyers.  
Please ensure that your listing remains updated and accurate to attract more buyers.  
If you have any questions, feel free to contact our support team. Happy Selling!";

        $stat=0;
            $stmt1->bind_param("isi", $userid, $msg,$stat);
            $stmt1->execute();
            $stmt1->close();
        header("location: /miniproject/admin/emailvalid/sendmail.php?wishlisttitle=$tit&price=$price");
        exit();
    }

   
 }
 if(isset($_GET['delpid'])&&isset($_GET['userid']))
 {
    $productid=$_GET['delpid'];
    $userid=$_GET['userid'];
    $tit=$_GET['title'];
    $stmt = "DELETE FROM tbl_products WHERE productid = '$productid' and userid = '$userid'";
    $stmt = $connection->prepare($stmt);
    if($stmt->execute())
    {
        $currdate = date('Y-m-d'); 
        $stmt1 = $connection->prepare("INSERT INTO tbl_notification (userid, message,status) VALUES (?, ?, ?)");
        $msg = "Date: ".$currdate." We regret to inform you that your request for the title: " . $tit . " has not been approved. 
This could be due to not meeting our listing guidelines or incomplete details. 
Please review our policies and ensure all required information is provided before resubmitting. 
If you have any questions, feel free to contact our support team. 
Thank you for your understanding.";

        $stat=0;
            $stmt1->bind_param("isi", $userid, $msg,$stat);
            $stmt1->execute();
            $stmt1->close();
        header("location: /miniproject/admin/adminpage/adminhome.php");
        exit();
    }
   
 }
$connection->close();
?>
    </div>
</body>
</html>
