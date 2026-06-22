
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/miniproject/user/viewprofile/viewprofile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
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

if(isset($_GET['request-profile'])){
$userid = $_GET['request-profile'];
$query = "SELECT * FROM tbl_users WHERE id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>



<div class="container mt-5 ">
    <div class="profile-card p-4">
        <div class="row">
            
            <div class="col-md-4 profile-left">
            <img src="<?php if($user['image']!='') { ?>/miniproject/user/login/loginimg/<?php echo htmlspecialchars($user['username']); ?>.<?php echo pathinfo($user['image'], PATHINFO_EXTENSION); ?> <?php } else { echo "/miniproject/user/login/loginimg/default-profile-pic.png";?> <?php }?>" alt="Profile Picture">
                
            </div>

            
            <div class="col-md-8">
                <h3 class="profile-color"><?php echo htmlspecialchars($user['name']); if($_SESSION['username']==$user['name']){
                    $_SESSION['id']=$row['userid'];
                    }?></h3>
                
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
                    
                    <ul class="nav nav-tabs mt-4" id="profileTabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#about">More Details</a>
                    </li>
                   
                </ul>
               
                    <div class="tab-pane fade show active mt-2" id="about">
                        <p style="font-weight:bold; color:4B0FBA;">Selling Books</p>
                        <div class="selling">
                    <?php
                    $query="SELECT * FROM tbl_products where userid= ? and avstatus=1 and archive=0";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("i", $userid); 
                    $stmt->execute();
                    $result = $stmt->get_result();
                   
                    ?>
                      <?php
                      $check=0;
                      $flag=1;
                      if ($result->num_rows > 0) {
                        $check=1;
                      while($row=$result->fetch_assoc()){
                        $query2="SELECT * FROM tbl_productimage";
                        $result2 = $connection->query($query2);
                        $flag=1;
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                if($row['productid']==$row2['productid']&&$row['appstatus']==1&&$flag!=0&&$row['archive']==0)
                { ?>
                     <div class="profile-container"  
                     onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" width="150" height="150"/>
                    <p class="title"><?php echo $row['title']; ?></p>
                                <p class="price"><?php echo $row['price']; ?>₹</p>
                                <p class="posted">Posted: <?php 
                                    $currentDateTime = strtotime(date("Y-m-d H:i:s"));
                                    $soldDateTime = strtotime($row['date']);
                                    $diff = abs($currentDateTime - $soldDateTime);
                                    $days = floor($diff / (60 * 60 * 24));
                                    echo $days == 0 ? "Today" : $days . " days ago";
                                ?></p>
                                 <a href="/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>" class="btn">View Details</a>
                            </div>
               <?php $flag=0;}
            }
        }} }
        if($check==0)
        {
            ?> <div class="no-data"><p>No Books For Sale</p></div><?php
        }
        ?>
        </div>
</div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php } $connection->close(); ?>
</body>

</html>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php'; ?>
