<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<html lang="en">
<head>
<link rel="stylesheet" href="/miniproject/user/cart/saledetails/saleitem.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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

    </script>
</head>
<body>

<?php

if(isset($_GET['product_id']))
{
    $productid=$_GET['product_id'];
    $userid=$_GET['user-id'];
    include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

    $query = "select * from tbl_products";
    $result = $connection->query($query);
    $query2="SELECT * FROM tbl_productimage";
    $result2 = $connection->query($query2);
    ?>
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
                             <img  src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" onclick="showimage(this)"/>
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
                $flag=0;
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $valid=0;
        if($productid==$row['productid'])
     {
        $query4="select userid,method from tbl_history where productid='$productid'";
        $result4 = $connection->query($query4);
        if($result4->num_rows>0)
        {
            $valid=1;
            while ($rowfetch = $result4->fetch_assoc()) {
                $buyerid = $rowfetch['userid'];
                $how=$rowfetch['method'];
                $queryfetch="select username from tbl_users where id='$buyerid'";
                $resultfetch=$connection->query($queryfetch);
                while ($rowuser = $resultfetch->fetch_assoc()) {
                    $buyername = $rowuser['username'];
                    
    }
            }
         }
        ?>
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
            <p><strong>Interested By: </strong> <?php  
            $userid=array();
            $pid=$row['productid'];
            $query3="SELECT * FROM tbl_userchat";
            $result3=$connection->query($query3);
            while($row3 = $result3->fetch_assoc()) {
                if(count($userid)>1)
                {
                    $uid=$userid[count($userid)-1];
                }
                else{
                    $uid=0;
                }
                if($row3['productid']==$pid&&$row3['userid']!=$_SESSION['id']&&$row3['userid']!=$uid)
                {
                    $check=0;
                    $uid=$row3['userid']; 
                      foreach($userid as $value)
                      {
                        if($uid==$value)
                        {
                            $check=1;
                            break;
                        }
                      }
                      if($check==0)
                      {
                        $userid[]=$row3['userid']; 
                        $flag++;
                      }
                    
                    
                }
            }
            echo $flag," Peoples";
            ?></p>
             <p><strong>Status: </strong> <?php 
            if($row['avstatus']==1)
            {
                echo "<span style='color:green; font-weight:bold; font-size:18px; '>Available</span>";
            }
            else if($row['avstatus']==2){
                echo "<span style='color:orangered; font-weight:bold; font-size:18px; '>Reserved</span>";
                echo "<script> window.onload = function() { document.getElementById('reserechoice').style.display='none';
                }; </script>";
            } 
            else if($row['avstatus']==3){
                echo "<span style='color:red; font-weight:bold; font-size:18px; '>Sold Out</span>";
                echo "<script> window.onload = function() { document.getElementById('changeSec').style.display='none';
                }; </script>";

                $querycheck="select * from tbl_history where  productid='$productid' and status=2 and method=2";
                        $resultquery = $connection->query($querycheck);
                        if($resultquery->num_rows>0)
                        {
                            
                            echo "<script> window.onload = function() {
                            document.getElementById('changeSec').style.display='none';
                            document.getElementById('saleCancel').style.display='block';
                            }; </script>";
                        }
            }
            ?></p>
            <?php
            if($valid==1)
            {
                ?>
                <p><strong>To: </strong><span style="color:#4B0FBA; font-weight:bold;"> <?php echo $buyername; ?></span></p>
                <p><strong>Method: </strong> <?php 
                if($how==1)
                {
                    echo "<span style='font-weight:bold;'>offline</span>";
                }
                else
                {
                    echo "<span style='color:blue; font-weight:bold;'>online</span>";
                }
                ?></p>
                <?php
            }
            ?>
            <p><strong>Condition: </strong></p>
            <div class="qlty">
            <p><?php echo $row['bkcondition']; ?></p>
            </div>
                </div>
                <div style="display:flex;">
                <button class="bttn" onclick="salesConfirm()">Remove Book</button>
                <button id="changeSec" class="bttn" onclick="changeStatus()">Update Status</button>
                <button id="saleCancel" class="bttn" onclick="cancelConfirm()">Cancel Sale</button>
        </div>
            </div>
        </div>
        <div class="assurance-section">
        <div class="assurance-item">
    <i class="bi bi-hand-thumbs-up"></i>
    <p>We have verified your listing</p>
</div>
            <div class="assurance-item">
    <i class="bi bi-box-seam"></i>
    <p>Prepare for a smooth exchange</p>
</div>
<div class="assurance-item">
<i class="bi-check-circle"></i>
    <p style="text-align:center;">Successfully completed an exchange? Mark it sold!</p>
</div>
        </div>
        <div class="description">
        <h2> Description</h2><p> <?php 
            echo '<html>' . str_replace("\n", "<br>", htmlspecialchars($row['description'])) . '</html>';?>
            </div>
            <div class="mt-5 p-4 bg-white text-dark rounded shadow border mx-auto" style="width: 100%;">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="fw-bold">Seller Guidelines</h3>
        <a href="#" class="text-primary fw-bold">Know More</a>
    </div>
    <ul class="list-unstyled mt-3">
        <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Upload real images of the book to gain buyer trust</li>
        <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Respond to buyer inquiries promptly</li>
        <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Avoid sharing personal or financial details with unverified buyers</li>
        <li class="d-flex align-items-center"><span class="text-success fw-bold me-2">✔</span> Meet in a safe location for offline transactions</li>
    </ul>
</div>

        </div>
        <?php } }

} }
$connection->close();
?>
    </div>
    <div class="status-sec" id="status-sec">
        <div class="close-change">
    <button onclick="changeStatus()">X</button>
</div>
<h3>Choose Status</h3>
    <div class="status-opt">
      
        <select id="statusDropdown" onchange="isChange()">
            <option value="available">Available</option>
            <option value="reserved" id="reserechoice">Reserved</option>
            <option value="soldout" id="soldchoice">Sold Out</option>
        </select>
        </div>
        <div id="reserveopt">
        <div class="status-opt">
    <label>Username</label>
    <select id="statusDropdownUser" onchange="isChange()">
        <option value="">Select User</option>
    </select>
    <br>
    <label>Method</label>
    <select id="statusDropdownUserMethod" onchange="isChange()">
        <option value="1">Offline</option>
        <option value="2">Online</option>
    </select>
</div>
</div>
    <button class="status-btn" onclick="confirmStatus()">Confirm</button>
</div>
<script>
    var productid = "<?= $productid ?>"; 
    function confirmStatus(){
        var opt = document.getElementById("statusDropdown").value;
        
        if(opt == 'available') {
            Swal.fire({
                title: 'Confirm Status Change',
                text: 'Are you sure you want to set this item as Available?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, set as Available'
            }).then((result) => {
                if (result.isConfirmed) {
                    var option = 1;
                    window.location.href = '/miniproject/user/cart/saleupdate.php?product-id=<?php echo $productid; ?>&avstatus=' 
                        + encodeURIComponent(reserve) + '&optstatus=' + encodeURIComponent(option);
                }
            });
        }
        else if(opt == 'reserved') {
            var reserve = document.getElementById("statusDropdownUser").value;
            if(reserve == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please select an Interested Buyer!',
                });
                return;
            }
            Swal.fire({
                title: 'Confirm Reservation',
                text: 'Are you sure you want to reserve this item?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reserve it'
            }).then((result) => {
                if (result.isConfirmed) {
                    var method = document.getElementById("statusDropdownUserMethod").value;
                    var option = 2;
                    window.location.href = '/miniproject/user/cart/saleupdate.php?product-id=<?php echo $productid; ?>&avstatus=' 
                        + encodeURIComponent(reserve) + '&optstatus=' + encodeURIComponent(option) + '&method=' + encodeURIComponent(method);
                }
            });
        }
        else {
            Swal.fire({
                title: 'Confirm Sold Status',
                text: 'Are you sure you want to mark this item as Sold Out?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, mark as Sold'
            }).then((result) => {
                if (result.isConfirmed) {
                    var option = 3;
                    window.location.href = '/miniproject/user/cart/saleupdate.php?product-id=<?php echo $productid; ?>&avstatus=' 
                        + encodeURIComponent(reserve) + '&optstatus=' + encodeURIComponent(option);
                }
            });
        }
    }

    function changeStatus() {
        var x = document.getElementById("statusDropdown");
        x.value = "available";
        var x = document.getElementById("reserveopt");
        x.style.display = "none";
        var x = document.getElementById("status-sec");
        if(x.style.display == "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    }

    function isChange() {
        var x = document.getElementById("reserveopt");
        var opt = document.getElementById("statusDropdown").value;

        if (opt === "reserved") {
            x.style.display = "block";
            fetch("/miniproject/user/cart/saledetails/chatuserlist.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "productid=" + encodeURIComponent(productid)
            })
            .then(response => response.text())
            .then(data => {
                let dropdown = document.getElementById("statusDropdownUser");
                let previousSelection = dropdown.value;
                dropdown.innerHTML = "";
                let defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.textContent = "Select User";
                dropdown.appendChild(defaultOption);
                let parser = new DOMParser();
                let doc = parser.parseFromString(data, "text/html");
                let options = doc.querySelectorAll("option");
                options.forEach(option => {
                    dropdown.appendChild(option);
                });
                let exists = [...dropdown.options].some(opt => opt.value === previousSelection);
                if (exists) {
                    dropdown.value = previousSelection;
                }
            })
            .catch(error => console.error("Error:", error));
        } else {
            x.style.display = "none";
        }
    }

    function cancelConfirm() {
    Swal.fire({
        title: 'Cancel Reservation',
        html: 'Are you sure you want to cancel this reservation?<br>Please ensure the buyer has agreed to this cancellation.</br><br>Cancelling a reservation will make this book available to the public again.</br>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, cancel it'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/miniproject/user/cart/saleupdate.php?pidcancel=<?php echo $productid; ?>';
        }
    });
    var x = document.getElementById("cancelsaleopt");
    x.style.display = "none";
}

    function salesConfirm() {
    Swal.fire({
        title: 'Remove Book',
        html: 'Are you sure you want to remove this book?<br>Please note that removing this book may cause you to <span style="color:red">LOSE INTERESTED BUYERS</span>.<br>We Recommend removing this book once it has successfully been exchanged.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, remove it'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/miniproject/user/cart/saleupdate.php?pidarchieve=<?php echo $productid; ?>';
        }
    });
    var x = document.getElementById("saleremove");
    x.style.display = "none";
}
</script>

<div class="modal-dialog" role="document" style="width:60%; border:1px solid; padding:10px;" id="cancelsaleopt">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" style="color:orangered;">Cancel Reservation Warning !!</h5>
<button type="button" class="close" onclick="cancelConfirm()" style="border:none; background:none; font-size:30px;">
<span>&times;</span>
</button>
</div>
<div class="modal-body">
<p>Are you sure you want to cancel this reservation?</p>
<ul>
<li>Please ensure the buyer has agreed to this cancellation.</li>
<li>Cancelling a reservation will make this book available to the public again.</li>
</ul>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" style="margin-right:10px;" onclick="cancelConfirm()">Close</button>
<button type="button" class="btn btn-danger" onclick="window.location.href='/miniproject/user/cart/saleupdate.php?pidcancel=<?php echo $productid; ?>'">Confirm Cancellation</button>
</div>
</div>
</div>


<div class="modal-dialog" role="document" style="width:60%; border:1px solid; padding:10px;" id="saleremove">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" style="color:orangered;">Book Removal Warning !!</h5>
<button type="button" class="close" onclick="salesConfirm()" style="border:none; background:none; font-size:30px;">
<span>&times;</span>
</button>
</div>
<div class="modal-body">
<p>Are you sure you want to Remove this Book?</p>
<ul>
<li>Please note that removing this book may cause you to LOSE INTERESTED BUYERS.</li>
<li>We Recommend removing this book once it has successfully been exchanged.</li>
</ul>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" style="margin-right:10px;" onclick="salesConfirm()">Close</button>
<button type="button" class="btn btn-danger"  onclick="window.location.href='/miniproject/user/cart/saleupdate.php?pidarchieve=<?php echo $productid; ?>'">Confirm Removal</button>
</div>
</div>
</div>



</body>
</html>


<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>