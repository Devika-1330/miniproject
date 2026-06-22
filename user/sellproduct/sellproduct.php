<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if($_SESSION['username']== '') {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/miniproject/user/sellproduct/sellproduct.css">
  <title>Sell Your Book</title>
</head>
<body>
  <div class="form-container">
    <h2>Sell Your Book</h2>
    <form action="/miniproject/admin/addproducts/addproducts.php" method="post" onsubmit="return validateForm()">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Enter book title" required oninput="validateTitle()">
        <div id="titleLengthError" class="text-danger" style="display:none;">Title must be at least 2 characters long</div>
        <div id="titleLangWarning" class="text-warning" style="display:none;">Please try to include English keywords as well</div>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" name="price" id="price" class="form-control" placeholder="Enter price" required oninput="validatePrice()">
        <div id="priceError" class="text-danger" style="display:none;">Price must be a positive whole number</div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Write a brief description of the book" required></textarea>
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Genre</label>
        <select id="genre" name="genre" class="form-control" required> 
          <option value="">Select a genre</option> 
          <option value="Fiction">Fiction</option> 
          <option value="Non-Fiction">Non-Fiction</option> 
          <option value="Mystery">Mystery</option> 
          <option value="Thriller">Thriller</option> 
          <option value="Romance">Romance</option> 
          <option value="Sci-Fi">Sci-Fi</option> 
          <option value="Fantasy">Fantasy</option> 
          <option value="Horror">Horror</option>
          <option value="Others">Others</option> 
          <option value="Education">Education</option> 
        </select> 
      </div>
      <div class="mb-3">
        <label for="condition" class="form-label">Book Condition</label>
        <select id="condition" name="condition" class="form-control" required>
          <option value="" disabled selected>Select condition</option>
          <option value="Brand New">Brand New</option>
          <option value="Lightly Used">Lightly Used</option>
          <option value="Well Used">Well Used</option>
          <option value="Old but Good">Old but Good</option>
          <option value="Marked & Highlighted">Marked & Highlighted</option>
          <option value="Worn Out">Worn Out</option>
          <option value="Rare or Special Edition">Rare or Special Edition</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
      </div>
      <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="agree" required>
        <label for="agree" class="form-check-label"><a href="/miniproject/user/welcomepage/footer/t&c.php">I agree to the terms and conditions</a>.</label>
      </div>
      <div class="d-grid">
        <button type="submit" class="button-sell">Submit</button>
      </div>
    </form>
  </div>

  <script>
    // Real-time validation for title
    function validateTitle() {
      const title = document.getElementById('title').value;
      const titleLengthError = document.getElementById('titleLengthError');
      const titleLangWarning = document.getElementById('titleLangWarning');
      let isValid = true;
      titleLengthError.style.display = 'none';
      titleLangWarning.style.display = 'none';
      // Check title length
      if (title.length < 2) {
        titleLengthError.style.display = 'block';
        isValid = false;
      } else {
        titleLengthError.style.display = 'none';
        const englishRegex = /[a-zA-Z0-9]/;
      if (!englishRegex.test(title)) {
        titleLangWarning.style.display = 'block';
      } else {
        titleLangWarning.style.display = 'none';
      }
      }

      // Check if title contains any English letters
      

      return isValid;
    }

    // Real-time validation for price
    function validatePrice() {
      const price = document.getElementById('price').value;
      const priceError = document.getElementById('priceError');
      let isValid = true;

      // Check if price is a positive integer
      if (!Number.isInteger(Number(price)) || Number(price) <= 0) {
        priceError.style.display = 'block';
        isValid = false;
      } else {
        priceError.style.display = 'none';
      }

      return isValid;
    }

    // Final validation before submission
    function validateForm() {
      const isTitleValid = validateTitle();
      const isPriceValid = validatePrice();
      return isTitleValid && isPriceValid;
    }
  </script>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>