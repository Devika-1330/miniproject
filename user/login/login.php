
<?php
$f=0;
$usr='';
$pass='';
if(isset($_GET['flag']))
{
    $f=$_GET['flag'];
    if(isset($_GET['username']))
    {
        $usr=$_GET['username'];
    }
    if(isset($_GET['password']))
    {
        $pass=$_GET['password'];
    }
}
?>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/miniproject/user/login/login.css">
    
  <script>
     function isError(x)
        {
            
            if(x==1){
                document.getElementById("errormsg").style.display="block";
            document.getElementById("errormsg").innerHTML="Error Invalid User Name";
            }
            if(x==2)
            {
                document.getElementById("errormsg2").style.display="block";
                document.getElementById("errormsg2").innerHTML="Error Invalid Password";
            }
        }        
             function logincheck(event){
                document.getElementById("errormsg").style.display="none"; 
                document.getElementById("errormsg2").style.display="none"; 
            var username=document.getElementById("username").value;
            var password=document.getElementById("password").value;
            if(password.length<8)
        {
            document.getElementById("errormsg2").style.display="block";
            document.getElementById("errormsg2").innerHTML="Error Password require atleast 8 characters";
            return false;
        }  
        return true;
    }
    </script>
</head>
<body>
  <div class="container login-container">
    <div class="card">
      <div class="row g-0">
       
        <div class="col-md-6 image-section">
      
     
     
<!-- Load FontAwesome for icons -->


<div class="container1">
    <div class="heading">Sign In To Your Account
    <div class="underline"></div>
    </div>
    

    <div class="feature">
        <div class="icon chat"><i class="fa-solid fa-comments"></i></div>
        <div class="feature-content">
            <div class="feature-title">Chat & Messaging</div>
            <div class="feature-description">
                Experience new inbuilt feature. Access your chats and account info from any device.
            </div>
        </div>
    </div>
<br>
    <div class="feature">
        <div class="icon dashboard"><i class="bi bi-bookmark-heart-fill feature-icon"></i></div>
        <div class="feature-content">
            <div class="feature-title">Wishlist & Favorites</div>
            <div class="feature-description">
            Save books you want to read later and get notified when they are available.
            </div>
        </div>
    </div>
<br>
    <div class="feature">
        <div class="icon location"><i class="fa-solid fa-location-dot"></i></div>
        <div class="feature-content">
            <div class="feature-title">Find Books Nearby</div>
            <div class="feature-description">
            Locate books available around you, making it easier to exchange and pick them up quickly
            </div>
        </div>
    </div>
</div>

   
        </div>
       
       <div class="col-md-6 p-5 form-section" style=" border-left: 1px solid #ccc;">
        <h2 class="text-center mb-4">Login</h2>
        <form onsubmit="return logincheck()" action="/miniproject/admin/loginvalid/login.php" method="post">
        <div class="m-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required value="<?php if ($usr != '') { echo htmlspecialchars($usr); } ?>">

                <div class="error" id="errormsg"><p><?php if($f==1) {echo '<html> <script>isError(1)</script></html>';}?></p></div>
                
            </div>
            <div class="m-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required value="<?php if ($pass != '') { echo htmlspecialchars($pass); } ?>">
                <div class="error" id="errormsg2"><p><?php if($f==2) {echo '<html> <script>isError(2)</script></html>';}?></p></div>
                
            </div>
            <p class="m-4" style="text-align:right; cursor:pointer" onclick="window.location.href='/miniproject/user/login/forgetpass.php'">Forgot Password?</p>
            <div class="d-grid m-4">
              <button style="background-color:#4B0FBA;" type="submit" class="btn btn-primary">Login</button>
            </div>
          </form>
          <div class="divider">or</div>
          <div class="text-center">
            <a href="/miniproject/user/login/signup/signup.php" class="signup-link">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>
</html>
