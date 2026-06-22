<?php
$flag = 0;
$err = '';




// If reset is successful, close the old tab
if (isset($_GET['success'])) {
   

    $flag = 1;
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/welcomepage/header/header.php'; ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link rel="stylesheet" href="/miniproject/user/login/signup/signupemail.css">
  <script>

async function forgotCheck(event) {
    event.preventDefault(); // Prevent form submission

    // Get elements safely
    let error1 = document.getElementById("errormsg1");
    let error2 = document.getElementById("errormsg2");
    let emailError = document.getElementById("errormsg3");
    let hide = document.getElementById("beforechange");

    // Hide errors if they exist
    if (error1) error1.style.display = "none";
    if (error2) error2.style.display = "none";
    if (emailError) emailError.style.display = "none";

    const emailValue = document.getElementById("email")?.value; // Use optional chaining
    if (!emailValue) {
        console.error("Email input not found!");
        return;
    }

    try {
        const response = await fetch('/miniproject/user/login/forgetemailvalid.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: emailValue })
        });
        const data = await response.json();

        if (data.result) {
            if (emailError) emailError.style.display = 'none'; // Hide error
            window.location.href = `/miniproject/admin/emailvalid/sendmail.php?forgotemail=${encodeURIComponent(emailValue)}`;
            if (hide) hide.style.display = 'none'; // Hide button safely
        } else {
            if (emailError) {
                emailError.style.display = 'block'; // Show error
                emailError.textContent = 'Email not found';
            }
        }
    } catch (error) {
        console.error('Error:', error);
        if (emailError) {
            emailError.style.display = 'block';
            emailError.textContent = 'Server error occurred';
        }
    }
}

function forgotCheckPass(event) {
    event.preventDefault();
    let error1 = document.getElementById("errormsg1");
    let error2 = document.getElementById("errormsg2");
    if (error1) error1.style.display = "none";
    if (error2) error2.style.display = "none";
    var npass = document.getElementById("npass").value;
    var repass = document.getElementById("repass").value;
    
    if (npass.length < 8) {
        error1.style.display = 'block'; // Show error
        error1.textContent = 'Password requires at least 8 characters';
        return;
    }
    
    if (npass !== repass) {
        error2.style.display = 'block'; // Show error
        error2.textContent = 'Passwords do not match';
        return;
    }

    // SweetAlert confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to change your password?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to xyz.php if user clicks Yes
            window.location.href = `/miniproject/user/login/forgotpassupdate.php?npass=${npass}`;
        }
    });
}
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <div class="signup-container">
    <h1>Reset Password</h1>
    <?php if ($flag == 0): ?>
    <form>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div class="error" id="errormsg3"></div>
        <div class="sended"><?php if ($err != '') echo $err; ?></div>
      </div>
      <button id="beforechange" onclick="forgotCheck(event)" type="submit" class="signup-button">Submit</button>
    </form>
    <?php else: ?>
    <form onsubmit="forgotCheckPass(event)">
      <div class="form-group">
        <label for="npass">New Password:</label>
        <input type="password" id="npass" name="npass" required>
        <div class="error" id="errormsg1"></div>
      </div>
      <div class="form-group">
        <label for="repass">Re-Enter New Password:</label>
        <input type="password" id="repass" name="repass" required>
        <div class="error" id="errormsg2"></div>
      </div>
      <button type="submit" class="signup-button">Submit</button>
    </form>
    <div class="form-footer">
      <p>Already have an account? <a href="/miniproject/user/login/login.php">Log in</a></p>
    </div>
    <?php endif; ?>
  </div>
</body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/welcomepage/footer/footer.php'; ?>
</html>
