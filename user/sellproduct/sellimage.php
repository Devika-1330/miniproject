<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Upload Images</title>
  <link rel="stylesheet" href="/miniproject/user/sellproduct/sellimage.css">
  <style>
    .image-upload-container {
      background: #f8f9fa;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
      max-width: 700px; /* Increased width */
      margin: 0 auto; /* Centered */
    }
    .image-input-group {
      margin-bottom: 20px;
    }
    .custom-file-input {
      display: none;
    }
    .custom-file-label {
      background-color: #4B0FBA; /* Green color for a fresh look */
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s;
      display: inline-block;
      font-weight: 500;
    }
    .custom-file-label:hover {
      background-color:  #007bff;
      transform: scale(1.05); /* Slight scale on hover */
    }
    .preview-container {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 20px;
      justify-content: center;
    }
    .preview-image {
      width: 120px; /* Slightly larger previews */
      height: 120px;
      object-fit: cover;
      border-radius: 8px;
      border: 2px solid #ced4da;
      transition: transform 0.2s;
    }
    .preview-image:hover {
      transform: scale(1.1); /* Zoom on hover */
    }
    #counter {
      font-weight: bold;
      padding: 8px 15px;
      border-radius: 5px;
      background: #e9ecef;
      text-align: center;
    }
    .upload-limit {
      color: #dc3545;
      font-weight: bold;
    }
    .error-message {
      color: #dc3545;
      font-size: 0.9em;
      margin-top: 5px;
      display: none;
    }
    .form-header {
      color: #343a40;
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <br><br>
  <div class="containersell">
    <div class="form-container image-upload-container">
      <h2 class="form-header">Upload Book Images</h2>
      <form action="/miniproject/admin/addproducts/addimage.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="mb-3 image-input-group">
          <label for="book-images1" class="form-label">Select Images</label>
          <div>
            <strong>Main Image (Required)</strong>
            <div>
              <input type="file" id="book-images1" name="book_images1" class="custom-file-input" accept=".jpg,.jpeg,.png" onchange="hasChange(1, this)">
              <label for="book-images1" class="custom-file-label">Choose Main Image</label>
              <div id="mainImageError" class="error-message">Main image is required!</div>
            </div>
          </div>
          <br>
          <div>
            <strong>Add Up to 3 More (Optional)</strong>
            <div>
              <input type="file" id="book-images2" name="book_images2" class="custom-file-input" accept=".jpg,.jpeg,.png" onchange="hasChange(1, this)">
              <label for="book-images2" class="custom-file-label">Choose Image 2</label>
            </div>
            <br>
            <div>
              <input type="file" id="book-images3" name="book_images3" class="custom-file-input" accept=".jpg,.jpeg,.png" onchange="hasChange(1, this)">
              <label for="book-images3" class="custom-file-label">Choose Image 3</label>
            </div>
            <br>
            <div>
              <input type="file" id="book-images4" name="book_images4" class="custom-file-input" accept=".jpg,.jpeg,.png" onchange="hasChange(1, this)">
              <label for="book-images4" class="custom-file-label">Choose Image 4</label>
            </div>
          </div>
          <br>
          <small class="text-muted">You can upload up to 4 images. Only JPG, JPEG, and PNG files are allowed.</small>
        </div>
        <div class="mb-3" id="counter" style="display:none;"></div>
        <div class="preview-container" id="preview-container"></div>
        <div class="d-grid">
          <button type="submit" class="button-sell btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    let i = 0;
    const previews = {};

    function hasChange(x, input) {
      document.getElementById("counter").style.display = "block";
      i = i + x;
      
      if (i >= 4) {
        i = 4; // Cap at 4
        document.getElementById("counter").innerHTML = "<span class='upload-limit'>Upload limit reached!</span>";
        document.querySelectorAll(".custom-file-input").forEach(input => {
          if (!input.files.length) input.disabled = true; // Disable unused inputs
        });
      } else {
        document.getElementById("counter").innerHTML = `${i} image(s) uploaded.`;
      }

      // Handle image preview
      const file = input.files[0];
      const inputId = input.id;
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          if (previews[inputId]) {
            previews[inputId].src = e.target.result; // Update existing preview
          } else {
            const img = document.createElement("img");
            img.src = e.target.result;
            img.className = "preview-image";
            img.id = `preview-${inputId}`;
            document.getElementById("preview-container").appendChild(img);
            previews[inputId] = img;
          }
        };
        reader.readAsDataURL(file);
      }
    }

    // Reset counter and preview if file is removed
    document.querySelectorAll(".custom-file-input").forEach(input => {
      input.addEventListener("change", function() {
        if (!this.files.length && i > 0) {
          i--;
          hasChange(0, this); // Update counter
          const preview = previews[this.id];
          if (preview) {
            preview.remove();
            delete previews[this.id];
          }
        }
      });
    });

    // Validate form before submission
    function validateForm() {
      const mainImage = document.getElementById("book-images1").files.length;
      const mainImageError = document.getElementById("mainImageError");
      
      if (mainImage === 0) {
        mainImageError.style.display = "block";
        return false; // Prevent form submission
      } else {
        mainImageError.style.display = "none";
        return true; // Allow submission
      }
    }
  </script>
   <br><br>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>