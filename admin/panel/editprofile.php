<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uid = $_SESSION['id'];
$query = "select * from tbl_users where id='$uid'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Sign Up</title>
  <link rel="stylesheet" href="/miniproject/user/login/signup/signup.css">
  <!-- Add SweetAlert2 CSS and JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <style>
    .error {
      color: red;
      font-size: 0.8em;
      display: none;
    }
    .invalid {
      border: 1px solid red;
    }
    #prev-image {
        display: block;
    }
    .upload-circle img {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 160px;
        height: 160px;
        margin-right: 0px;
        border-radius: 50%;
        background-color: white;
        color: var(--primary-color);
        font-size: 14px;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        border: 3px dashed var(--primary-color);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
  </style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile picture preview code (unchanged)
    const profilePicInput = document.getElementById('profilePic');
    if (profilePicInput) {
        profilePicInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadCircle = document.getElementById('uploadCircle');
                    uploadCircle.style.backgroundImage = `url(${e.target.result})`;
                    uploadCircle.style.backgroundSize = 'cover';
                    uploadCircle.style.backgroundPosition = 'center';
                    uploadCircle.querySelector('span').style.display = 'none';
                };
                reader.readAsDataURL(file);
                document.getElementById("prev-image").style.display = "none";
            }
        });
    }

    // Form submission handler
    const form = document.querySelector('.signup-form form');
    form.addEventListener('submit', async function(e) { // Added async for await
        e.preventDefault(); // Prevent default submission
        let isValid = true;

        // Name validation
        const name = document.getElementById('name');
        const nameError = document.getElementById('nameError');
        const nameRegex = /^[a-zA-Z\s]{2,}$/;
        if (!nameRegex.test(name.value.trim())) {
            nameError.style.display = 'block';
            nameError.textContent = 'Name must be at least 2 characters and contain only letters';
            name.classList.add('invalid');
            isValid = false;
        } else {
            nameError.style.display = 'none';
            name.classList.remove('invalid');
        }

        // Phone validation
        const phone = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        const phoneRegex = /^\d{10}$/;
        if (!phoneRegex.test(phone.value)) {
            phoneError.style.display = 'block';
            phoneError.textContent = 'Phone number must be exactly 10 digits';
            phone.classList.add('invalid');
            isValid = false;
        } else {
            phoneError.style.display = 'none';
            phone.classList.remove('invalid');
        }

        // Location validation
        const location = document.getElementById('location');
        const locError = document.getElementById('locError');
        if (location.value.trim().length < 5) {
            locError.style.display = 'block';
            locError.textContent = 'Please enter a valid location (minimum 5 characters)';
            location.classList.add('invalid');
            isValid = false;
        } else {
            locError.style.display = 'none';
            location.classList.remove('invalid');
        }

        // Address validation
        const address = document.getElementById('address');
        const addressError = document.getElementById('addressError');
        if (address.value.trim().length < 5) {
            addressError.style.display = 'block';
            addressError.textContent = 'Address must be at least 5 characters';
            address.classList.add('invalid');
            isValid = false;
        } else {
            addressError.style.display = 'none';
            address.classList.remove('invalid');
        }

        // Pin validation
        const pin = document.getElementById('pin');
        const pinError = document.getElementById('pinError');
        const pinRegex = /^\d{6}$/;
        if (!pinRegex.test(pin.value)) {
            pinError.style.display = 'block';
            pinError.textContent = 'Pin code must be exactly 6 digits';
            pin.classList.add('invalid');
            isValid = false;
        } else {
            pinError.style.display = 'none';
            pin.classList.remove('invalid');
        }

        // Date of Birth validation
        const dob = document.getElementById('dob');
        const dobError = document.getElementById('dobError');
        const today = new Date();
        const birthDate = new Date(dob.value);
        const age = today.getFullYear() - birthDate.getFullYear();
        if (!dob.value || birthDate >= today || age < 13) {
            dobError.style.display = 'block';
            dobError.textContent = 'You must be at least 18 years old';
            dob.classList.add('invalid');
            isValid = false;
        } else {
            dobError.style.display = 'none';
            dob.classList.remove('invalid');
        }

        // Email validation with PHP (inline, no function)
        const emailValue = document.getElementById('email').value.trim(); // Get value, not element
        const emailError = document.getElementById('emailError');
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (emailRegex.test(emailValue)) {
            emailError.textContent = ''; // Clear error initially
            try {
                const response = await fetch('/miniproject/admin/panel/check_email.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: emailValue })
                });
                const data = await response.json();
                if (data.result) {
                    emailError.style.display = 'none'; // Hide error
                    email.classList.remove('invalid'); // Remove invalid class
                } else {
                    emailError.style.display = 'block'; // Show error
                    emailError.textContent = 'Email already taken';
                    email.classList.add('invalid');
                    isValid = false;
                }
            } catch (error) {
                console.error('Error:', error);
                emailError.style.display = 'block';
                emailError.textContent = 'Server error occurred';
                email.classList.add('invalid');
                isValid = false;
            }
        } else {
            emailError.style.display = 'block';
            emailError.textContent = 'Invalid email format';
            email.classList.add('invalid');
            isValid = false;
        }

        // If all validations pass, show confirmation
        if (isValid) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update your profile?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form
                }
            });
        }
    });
});
</script>
</head>
<body>
  <div class="signup-form">
    <div style="display:flex; width:100%; justify-content:left; font-size:30px; cursor:pointer; margin:20px; color:var(--primary-color);"
    onclick="window.location.href='/miniproject/admin/panel/test.php'">
    <i class="bi bi-arrow-left-circle-fill"></i>
    </div>
    <h2>Sign Up</h2>
    <form action="/miniproject/admin/panel/updateprof.php" method="post" enctype="multipart/form-data">
      <div class="upload-circle" id="uploadCircle">
        <img id="prev-image" src="<?php echo !empty($row['image']) 
    ? "/miniproject/user/login/loginimg/" . htmlspecialchars($row['username']) . "." . pathinfo($row['image'], PATHINFO_EXTENSION)
    : "/miniproject/user/login/loginimg/default-profile-pic.png"; ?>" 
    alt="Profile Picture" width="100" height="100">
        <input type="file" name="profile-pic" id="profilePic" accept="image/*">
      </div>
      
      <div class="mb-3">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required value="<?php echo $row['name']; ?>">
        <div id="nameError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="phone">Phone:</label>
        <input type="number" id="phone" name="phone" placeholder="Enter your phone number" required value="<?php echo $row['phone']; ?>">
        <div id="phoneError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="address">Address:</label>
        <textarea type="text area" id="address" name="address" placeholder="Enter your address" rows="3" required><?php echo $row['address']; ?></textarea>
        <div id="addressError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="name">Email:</label>
        <input type="text" id="email" name="email" placeholder="Enter your email" required value="<?php echo $row['email']; ?>">
        <div id="emailError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" placeholder="Enter your location" required value="<?php echo $row['location']; ?>">
        <div id="locError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="pin">Pin:</label>
        <input type="text" id="pin" name="pin" placeholder="Enter your pin code" required value="<?php echo $row['pin']; ?>">
        <div id="pinError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required value="<?php echo $row['dob']; ?>">
        <div id="dobError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" placeholder="Tell us something about yourself" rows="5"><?php echo $row['bio']; ?></textarea>
      </div>

      <button type="submit">Update Profile</button>
    </form>
  </div>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>