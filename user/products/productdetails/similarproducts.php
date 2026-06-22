
<?php
$flag=1;
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
  $query = "select * from tbl_products where archive=0 and avstatus=1";

  $result = $connection->query($query);

?>
<html>
    <head>
        <link rel="stylesheet" href="/miniproject/user/products/productdetails/similarproducts.css">

    </head>

    <body>
    <div class="container" id="container">
        <h3>See Also</h3>
    <div class="container1">
        <?php
      
      if (isset($loc)) {
        $valid=false;
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $query2="SELECT * FROM tbl_productimage";
        $result2 = $connection->query($query2);
        $flag=1;
        ?>
           
          <?php
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                if(($row['genre']==$loc||$row['title']==$tit)&&$row['productid']!=$prodid){
                    
                if($row['productid']==$row2['productid']&&$row['userid']!=$_SESSION['id']&&$flag!=0&&$row['appstatus']==1)
                { $valid=true; ?>
                     <div class="profile-container"  
                     onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" width="150" height="150"/>
                    <p> <?php echo $row['title']; ?></p>
            <p><strong><?php echo $row['price']; ?>₹</strong></p>
            <p><?php 
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
            </div>
               <?php $flag=0;} }
            }
        }
        ?> 
        <?php
    }
    if(!$valid){
        ?><script> document.getElementById("container").style.display="none"; </script><?php
       }
} else {
    ?>
    <p class="no-profile">No Profile Found</p>
    <?php
}
      }
$connection->close();

?></div></div>


</body>

    </html>
