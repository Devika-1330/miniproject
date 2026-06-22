<?php
$err='';
$err2='';
if(isset($_GET['error']))
{
  $err=$_GET['error'];
}
if(isset($_GET['error2']))
{
  $err2=$_GET['error2'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="/miniproject/user/login/signup/signupemail.css">
  <script>
    function logincheck(event)
    {
      document.getElementById("errormsg1").style.display="none"; 
      document.getElementById("errormsg2").style.display="none"; 
      var password=document.getElementById("password").value;
      var username=document.getElementById("username").value;
      if(username.length<5)
    {
      document.getElementById("errormsg1").style.display="block";
            document.getElementById("errormsg1").innerHTML="username requires minimum 5 characters";
            return false;
    }
      if(password.length<8)
    {
      document.getElementById("errormsg2").style.display="block";
            document.getElementById("errormsg2").innerHTML="Error Password require atleast 8 characters";
            return false;
    }
    return true;
    }
    function isuser()
    {
      let inputField = document.getElementById("username");
      inputField.value = inputField.value.toLowerCase();
    }
    </script>
  
</head>
<body>
  <div class="signup-container">
    <h1>Sign Up</h1>
    <form onsubmit="return logincheck()" action="/miniproject/admin/loginvalid/signup.php" method="post">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div class="error" id="errormsg3"><?php if($err2!='') {echo '<html>',$err2,'</html>';}?></div>
      </div>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" oninput="isuser()" required>
        <div class="error" id="errormsg1"><?php if($err!='') {echo '<html>',$err,'</html>';}?></div>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <div class="error" id="errormsg2"></div>
      </div>
      <button type="submit" class="signup-button">Sign Up</button>
    </form>
    <div class="form-footer">
      <p>Already have an account? <a href="/miniproject/user/login/login.php">Log in</a></p>
    </div>
  </div>
</body>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>
</html>
