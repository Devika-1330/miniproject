
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
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Interface</title>
  <link rel="stylesheet" href="/miniproject/user/userchat/userchat.css">
  <style>
    </style>
</head>
<body>
<div class="chat-opt">
  <button class="<?php echo (isset($_GET['buyer']) && $_GET['buyer'] == 1) ? 'active' : ''; ?>" 
          onclick="window.location.href = '/miniproject/user/userchat/userchat.php?buyer=1'">
    <i class="bi bi-cart4" style="margin-right:10px;"></i>Buying
  </button>
  <button class="<?php echo (isset($_GET['seller']) && $_GET['seller'] == 1) ? 'active' : ''; ?>" 
          onclick="window.location.href = '/miniproject/user/userchat/userchat.php?seller=1'">
    <i class="bi bi-check-square-fill" style="margin-right:10px;"></i>Selling
  </button>
</div>
<div class="container">
  
<div class="chatbar">
  <h2>Titles</h2>

  <?php   
  include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
    $ptint=[];
    $ptintsell=[];
    $flag=2;
    $flag2=0;
    $query="SELECT * FROM tbl_userchat";
    $result = $connection->query($query);
    if(isset($_GET['seller'])||isset($_GET['buyer'])){
    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if($_SESSION['id']==$row['userid']||$row['sellerid']==$_SESSION['id']){
          $stmt = $connection->prepare("SELECT title FROM tbl_products WHERE productid = ?");
          $stmt->bind_param("i", $row['productid']); 
          $stmt->execute();
          $result2 = $stmt->get_result();
          $stmt2 = $connection->prepare("SELECT userid FROM tbl_products WHERE productid = ?");
          $stmt2->bind_param("i", $row['productid']); 
          $stmt2->execute();
          $result3 = $stmt2->get_result();
          $uid=$result3->fetch_assoc()['userid']; 

          if(isset($_GET['seller'])){
            $flag=0;
            if($uid==$_SESSION['id'])
            {

              $title = $result2->fetch_assoc()['title']; 

              $flag=1;
              $flag2=1;
            }
            if($flag==1){
              $validsale=false;
              $validbuy=false;
              foreach($ptintsell as $book)
              {
                if ($book["pid"] === $row['productid']) {
                  if($book['userid']==$row['userid']||$book['userid']==$row['sellerid']){ 
                 $validsale=true;
                 break;
                 }
                }
              }
              
             
              if((!$validsale)&&(!$validbuy))
              { ?><ul>
                <li onclick="window.location.href = '/miniproject/user/userchat/userchat.php?seller-id=<?php if($row['sellerid']==$_SESSION['id']) {echo $row['userid'];} else {echo $row['sellerid'];} ?>&pid=<?php echo $row['productid']; ?>&seller=1'"><?php
                 echo "<span style='font-weight:bold;'>$title</span>"; $ptintsell[]=["pid"=>$row['productid'],"userid"=>$row['userid']]; 
                 ?><br><?php $stmt = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
                 $stmt->bind_param("i", $row['userid']); 
                 $stmt->execute();
                 $result2 = $stmt->get_result();
                 $namefind = $result2->fetch_assoc()['username']; 
                 echo $namefind;
                 }?>
                </li>
        </ul><?php 
            }
            
          } 
          else if(isset($_GET['buyer']))
          {
            $flag=1;
            if($uid!='' && $uid!=$_SESSION['id'])
            {

                $title = $result2->fetch_assoc()['title']; 

              $flag=0;
              $flag2=1;
            }
            if($flag==0){
              $validsale=false;
              $validbuy=false;
                foreach($ptint as $book)
                {
                  if ($book["pid"] === $row['productid']) {
                    if($book['userid']==$row['userid']||$book['userid']==$row['sellerid']){ 
                   $validbuy=true;
                   break;
                   }
                  }
                }
                
                if((!$validsale)&&(!$validbuy))
                { ?>
                   <ul>
              <li onclick="window.location.href = '/miniproject/user/userchat/userchat.php?seller-id=<?php if($row['sellerid']==$_SESSION['id']) {echo $row['userid'];} else {echo $row['sellerid'];} ?>&pid=<?php echo $row['productid']; ?>&buyer=1'"><?php
               echo $title; $ptint[]=["pid"=>$row['productid'],"userid"=>$row['userid']]; 
               ?><br><?php $stmt = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
               $stmt->bind_param("i", $row['sellerid']); 
               $stmt->execute();
               $result2 = $stmt->get_result();
               $namefind = $result2->fetch_assoc()['username']; 
               echo $namefind;
               }?>
                </li>
      </ul>
                <?php
                 
                }
              ?> 
              <?php
             
          } ?>
      <?php } ?><?php }}
      if ($flag2 == 0) { $flag=2; ?> </div>
        <div class="chat-container" style="background:none;">
          <div class="chat-header" style="background:none; border:none;">
            <div class="chat-messages" id="chat-messages">
              <div  class="nomsg">
                <div>
                <span class="center-text"><img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy" style="width: 200px; height: auto; border:none;">
      </div></span><span class="center-text"><div>Ooppss.. There Are no Messages</div></div></span>
      </div></div>
      <?php } ?> <?php }
      else { 
          ?> <script>window.location.href = '/miniproject/user/userchat/userchat.php?buyer=1'</script><?php
      }?>
      </div>
      <?php if($flag==0||$flag==1) {?>
      <div class="chat-container" style="background:none;" id="beforeSelection">
          <div class="chat-header" style="background:none; border:none;" >
            <div class="chat-messages" id="chat-messages1" style="border:none;">
              <div  class="nomsg"  style="border:none;">
          <div class="animation">   
<div class="message-animation">
<div class="person person-1"></div>
<div class="person-body person-1-body"></div>
<div class="bubble bubble-1"><span class="center-text">.....</span></div>
<div class="person person-2"></div>
<div class="person-body person-2-body"></div>
<div class="bubble bubble-2"><span class="center-text">.....</span></div>
</div></div>
                <div><span class="center-text">Chat and Make the Deal</span></div></div></div>
      </div></div>
    <?php } ?>
      <?php
      if ((isset($_GET['seller-id']))&&isset($_GET['pid'])) {  
        $sellerid=$_GET['seller-id'];
        ?><script>
        document.getElementById("beforeSelection").style.display="none";
        document.getElementById("afterselection").style.display="block"; 
        </script>
          <div class="chat-container" id="afterselection">
        
    <div class="chat-header">
      <div class="chathead-details" onclick="window.location.href ='/miniproject/user/viewprofile/viewprofile.php?request-profile=<?php echo $sellerid; ?>'">
      <div class="prof-pic">
      <?php
      
      $stmt = $connection->prepare("SELECT image FROM tbl_users WHERE id = ?");
               $stmt->bind_param("i", $sellerid); 
               $stmt->execute();
               $result2 = $stmt->get_result();
               $image = $result2->fetch_assoc()['image']; 
               ?>  
           <div style="display:flex; text-align:left;"> 
            <div style="margin-right:10px;">  
      <img src=" <?php if($image!=''){ 
         $stmt = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
         $stmt->bind_param("i", $sellerid); 
         $stmt->execute();
         $result2 = $stmt->get_result();
         $image = $result2->fetch_assoc()['username']; 
        ?>/miniproject/user/login/loginimg/<?php echo htmlspecialchars($image); ?>.<?php echo pathinfo($image, PATHINFO_EXTENSION); ?> <?php } else { echo "/miniproject/user/login/loginimg/default-profile-pic.png"; }?>" alt="Profile Picture">
        </div>
   <?php
        $sellerid=$_GET['seller-id'];
        $pid=$_GET['pid'];
        ?>  <div style="display:flex; flex-direction:column; margin-left:2px;"><h4><?php  
        $stmt = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
        $stmt->bind_param("i", $sellerid); 
        $stmt->execute();
        $result2 = $stmt->get_result();
        $usr = $result2->fetch_assoc()['username']; 
        echo $usr;
        ?>
       </h4>
       <span style="font-size:14px; color:blue; font-weight:bold;">view profile</span>
      </div>
      </div>
      
    </div>
        <script>
</script>
        </div>
      </div>
        <div class="chat-messages" id="chat-messages">
          <?php $query="SELECT * FROM tbl_userchat";
    $result = $connection->query($query);
    if ($result->num_rows > 0) {
      $counter=0;
      while($row = $result->fetch_assoc()) {
        $counter++;
     ?>
     <?php  if($row['userid']==$_SESSION['id']&&$row['message']!=' '&&$row['productid']==$pid&&$sellerid==$row['sellerid']) { ?>  
          <div class="message user">
            <?php echo $row['message']; 
           
            ?></div>
             <?php echo "<p style='font-size:10px;  margin-top:-8px;'>", $row['timest']," </p>"; ?> <?php } ?>
          <?php if($row['userid']==$sellerid&&$row['sellerid']==$_SESSION['id']&&$row['productid']==$pid&&$row['message']!=' '){?>
          <div class="message seller" id="message seller">
           <?php echo $row['message']; 
          
           ?>
           </div>
            <?php echo "<p style='font-size:10px; text-align:right; margin-top:-8px;'>", $row['timest']," </p>"; ?>
           <?php
          } ?>
          <?php } } ?>
        </div>
        <div class="chat-input" id="chat-input">
        <form id="chatForm">
  <input type="text" placeholder="Type your message here..." name="message-input" id="message-input">
  <button type="submit" id="send-button" name="messages">Send</button>
</form>
        </div><?php
      }
      ?>
      <script>
        document.getElementById("chatForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    let message = document.getElementById("message-input").value.trim();
    if (message === "") return; 

    let sellerid = <?php echo $sellerid; ?>;
    let productid = <?php echo $pid; ?>;
    
    let formData = new FormData();
    formData.append("message-input", message);
    
    fetch(`/miniproject/admin/addchat/addchat.php?sellerid=${sellerid}&productid=${productid}`, {
        method: "POST",
        body: formData
    })
    .then(response => response.text()) 
    .then(data => {
        document.getElementById("message-input").value = ""; 
        loadMessages(); 
    })
    .catch(error => console.error("Error:", error));
});

function loadMessages() {
    var sellerid = <?php echo $sellerid; ?>;
    var pid = <?php echo $pid; ?>;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("chat-messages").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/miniproject/user/userchat/loadmessage.php?seller-id=" + sellerid + "&pid=" + pid, true);
    xhttp.send();
}

setInterval(loadMessages, 5000);
</script>
     </div>
  </div>
</div>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>