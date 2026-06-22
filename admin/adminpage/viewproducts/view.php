
<?php
include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/admin/sidebar.php';

$flag=1;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['adminid'])) {
    header("location: /miniproject/user/login/login.php");
exit();
}

?>

<html>

    <head>
        <link rel="stylesheet" href="/miniproject/admin/adminpage/viewproducts/view.css">

    </head>

    <body>

   
        <?php
        $heading='';
      if(isset($_GET['status']))
      {
        $status=$_GET['status'];
        if($status=='avbooks'){
        $query = "select * from tbl_products where appstatus=1 and avstatus=1 and archive=0";

        $result = $connection->query($query);
        $heading="Available Books";
        }
        else if($status=='resbooks'){
            $query = "select * from tbl_products where appstatus=1 and avstatus=2 and archive=0";
    
            $result = $connection->query($query);
            $heading="Reserved Books";
            }
            else if($status=='soldbooks'){
                $query = "select * from tbl_products where appstatus=1 and avstatus=3 and (archive=0 or archive=1)";
        
                $result = $connection->query($query);
                $heading="Sold Books";
                }
                else if($status=='arcbooks'){
                    $query = "select * from tbl_products where appstatus=1 and archive=1";
            
                    $result = $connection->query($query);
                    $heading="Archived Books";
                    }
      }
      else{
        $query = "select * from tbl_products where appstatus=1";

        $result = $connection->query($query);
        $heading="Total Books";
      }
      ?>
      <div class="main-content">
      <div class="avbooks"><?php echo $heading; ?></div>
      <div class="container"> <?php
    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $query2="SELECT * FROM tbl_productimage";
        $result2 = $connection->query($query2);
        $flag=1;
        ?>
           
          <?php
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                if($row['productid']==$row2['productid']&&$flag!=0&&$row['appstatus']==1)
                { ?>
                     <div class="profile-container"  
                     onclick="window.location.href='/miniproject/admin/adminproductdetails/adminproductdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" width="150" height="150"/>
                    <p><?php echo $row['title']; ?></p>
            <p> <strong><?php echo $row['price']; ?>₹</strong></p>
            <p>Posted: <?php 
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
             <?php 
       if($row['avstatus']==2)
       {
        ?>
        <div class="soldOrReserve">
            Reserved
       </div>
        <?php
       }
       if($row['avstatus']==3)
       {
        ?>
        <div class="soldOrReserve">
           Sold Out
       </div>
        <?php
       }
       if($row['archive']==1)
       {
        ?>
        <div class="soldOrReserve" style="background:blue;">
           Archived
       </div>
        <?php
       }
       ?>
            </div>
               <?php $flag=0;}
            }
        }
        ?> 
        <?php
    }
} else {
    ?>
    <p class="no-profile">No Profile Found</p>
    <?php
}
$connection->close();
?>

</div>

</div>
</div>

</body>

    </html>
