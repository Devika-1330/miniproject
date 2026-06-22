<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Sign Up</title>
  <link rel="stylesheet" href="/miniproject/user/login/signup/signup.css">
  <style>
    .error {
      color: red;
      font-size: 0.8em;
      display: none;
    }
    .invalid {
      border: 1px solid red;
    }
  </style>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    // Existing profile picture code
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
            }
        });
    }

    // Form validation
    const form = document.querySelector('.signup-form form');
    form.addEventListener('submit', function(e) {
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

        //loc validation
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
            dobError.textContent = 'You must be atleast 18 years old';
            dob.classList.add('invalid');
            isValid = false;
        } else {
            dobError.style.display = 'none';
            dob.classList.remove('invalid');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
</head>
<body>
  <div class="signup-form">
    <h2>Sign Up</h2>
    <form action="/miniproject/admin/loginvalid/signuppersonnal.php" method="post" enctype="multipart/form-data">
      <div class="upload-circle" id="uploadCircle">
        <span>Upload</span>
        <input type="file" name="profile-pic" id="profilePic" accept="image/*">
      </div>
      
      <div class="mb-3">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your name" required>
        <div id="nameError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="phone">Phone:</label>
        <input type="number" id="phone" name="phone" placeholder="Enter your phone number" required>
        <div id="phoneError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="address">Address:</label>
        <textarea id="address" name="address" placeholder="Enter your address" rows="3" required></textarea>
        <div id="addressError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" placeholder="Enter your location" required>
        <div id="locError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="pin">Pin:</label>
        <input type="text" id="pin" name="pin" placeholder="Enter your pin code" required>
        <div id="pinError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
        <div id="dobError" class="error"></div>
      </div>

      <div class="mb-3">
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" placeholder="Tell us something about yourself" rows="5"></textarea>
      </div>

      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>