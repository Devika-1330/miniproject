
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
    header("Location: /miniproject/user/login/login.php");
    exit();
  }
  include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Request a Book - ReRead</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
    
            background-color: #f7f9fc;
            
        }

        .container3 {
            max-width: 1200px; /* Increased from 900px to 1200px */
            margin: 40px auto;
            background: var(--white);
            padding: 50px;
            border-radius: 25px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(75, 15, 186, 0.1);
        }
        .container3::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--primary-color));
            border-radius: 25px 25px 0 0;
        }
        h2 {
            color: #1a73e8;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2em;
            font-weight: 600;
        }
        h1{
          
            text-align: center;
            margin-bottom: 30px;
          
        }
        .intro-text {
            color: #555;
            margin-bottom: 40px;
            line-height: 1.7;
            text-align: center;
            font-size: 1.1em;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-group {
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.1em;
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #1a73e8;
            outline: none;
        }

        .price-input {
            width: 250px;
        }

        .form-group button {
            background: linear-gradient(45deg, #1a73e8, #4285f4);
            color: white;
            padding: 16px 40px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2em;
            display: block;
            margin: 30px auto 0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .form-group  button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(26, 115, 232, 0.3);
        }

        .info-text {
            color: #666;
            font-size: 0.95em;
            margin-top: 12px;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .error-message {
            color: #d93025;
            display: none;
            margin-top: 8px;
            text-align: center;
            font-size: 0.9em;
        }

        .requested-books {
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eee;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .requested-books ul {
            list-style: none;
            padding: 0;
            text-align: center;
        }

        .requested-books li {
            margin: 15px 0;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            font-size: 1em;
            transition: background 0.2s;
        }

        .requested-books li:hover {
            background: #eef2f7;
        }
    </style>
</head>
<body>
    <div class="container3">
    <h1 style="  color: var(--primary-color);"><i class="bi bi-bag-heart-fill" style="margin-right:10px;"></i>ReRead Wishlist</h1>
    <br>
    <br>
        <h2>Request a Book</h2>
        <br>
       
        
        <form id="bookRequestForm">
            <div class="form-group">
                <label for="bookTitle">Book Title *</label>
                <input type="text" id="bookTitle" name="bookTitle" required placeholder="Enter the book title">
                <span class="info-text">Use the exact title for the best results</span>
                <span class="error-message" id="titleError">Please enter a book title</span>
            </div>
            
           
            
            <div class="form-group">
                <label for="maxPrice">Maximum Price *</label>
                <input type="number" id="maxPrice" name="maxPrice" class="price-input" required min="0" step="0.01" placeholder="0.00">
                <span class="info-text">We’ll alert you when it’s listed at or below this price (USD)</span>
                <span class="error-message" id="priceError">Please enter a valid price</span>
            </div>
            <div class="form-group mb-3" style="display:flex; gap:10px;">
        <input type="checkbox" class="form-check-input" id="agree" required>
        <label for="agree" class="form-check-label" ><a href="/miniproject/user/welcomepage/footer/t&c.php">I agree to the terms and conditions</a>.</label>
      </div>
            <div class="form-group">
            <button type="submit">Add to list</button>
    </div>
        </form>
        
        <div class="info-text" style="margin-top: 40px; max-width: 80%; margin-left: auto; margin-right: auto; background:var(--primary-color); color:white; padding: 30px; border-radius: 10px;">
    <h4 style="text-align: center; margin-bottom: 20px;">How It Works:</h4>
    <ol style="align-items: center; display: flex; flex-direction: column; margin: 20px auto; font-size: 18px; padding: 0; list-style: none;">
        <li style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="bi bi-pencil-square" style="font-size: 24px; margin-right: 10px;"></i>
            Submit your book request
        </li>
        <li style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="bi bi-search" style="font-size: 24px; margin-right: 10px;"></i>
            We track new listings for you
        </li>
        <li style="display: flex; align-items: center; margin-bottom: 15px;">
            <i class="bi bi-envelope" style="font-size: 24px; margin-right: 10px;"></i>
            Get an email when it’s available
        </li>
        <li style="display: flex; align-items: center;">
            <i class="bi bi-cart-check" style="font-size: 24px; margin-right: 10px;"></i>
            Buy it before someone else does!
        </li>
    </ol>
</div>

        
<div class="requested-books">
            <h2>Your Requested Books</h2>
            <ul id="bookList">
                <?php
                $uid = $_SESSION['id'];
                $query = "SELECT * FROM tbl_wishlist WHERE userid='$uid'";
                $result = $connection->query($query);
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                ?>
                    <li data-wishid="<?php echo $row['wishid']; ?>">
                        <?php echo $row['title']; ?> (Max: <?php echo $row['maxprice']; ?>₹)
                        <?php if($row['status'] == 0) { ?>
                            <span style="margin-left:10px; color:red;">(Not Listed)</span>
                        <?php } else { ?>
                            <span style="margin-left:10px; color:green;">(Listed)</span>
                        <?php } ?>
                        <i class="bi bi-trash3 delete-wish" 
                           style="margin-left:20px; cursor:pointer; font-weight:bold; color:black;"></i>
                    </li>
                <?php } } else { ?>
                    <li>No Books Added</li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission handling
    document.getElementById('bookRequestForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        document.getElementById('titleError').style.display = 'none';
        document.getElementById('priceError').style.display = 'none';
        
        const title = document.getElementById('bookTitle').value.trim();
        const price = document.getElementById('maxPrice').value;
        
        let isValid = true;
        
        if (!title) {
            document.getElementById('titleError').style.display = 'block';
            isValid = false;
        }
        
        if (!price || price <= 0) {
            document.getElementById('priceError').style.display = 'block';
            isValid = false;
        }
        
        if (isValid) {
            
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/miniproject/user/wishlist/wishadd.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Request Submitted!',
                                text: `We'll email you when "${title}" is available.`,
                                confirmButtonColor: '#1a73e8'
                            }).then(() => {
                               
                                location.reload();
                            });
                            document.getElementById('bookRequestForm').reset();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to add book to wishlist',
                                confirmButtonColor: '#1a73e8'
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Invalid response from server',
                            confirmButtonColor: '#1a73e8'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Request failed. Please try again.',
                        confirmButtonColor: '#1a73e8'
                    });
                }
            };
            
            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Network error occurred',
                    confirmButtonColor: '#1a73e8'
                });
            };
            
           
            const data = `bookTitle=${encodeURIComponent(title)}&maxPrice=${encodeURIComponent(price)}`;
            xhr.send(data);
        }
    });

   
    document.querySelectorAll('.delete-wish').forEach(button => {
        button.addEventListener('click', function() {
            const listItem = this.parentElement;
            const wishId = listItem.getAttribute('data-wishid');
            
            Swal.fire({
                title: 'Are you sure?',
                text: 'This book will be removed from your wishlist!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteWishlistItem(wishId, listItem);
                }
            });
        });
    });

    function deleteWishlistItem(wishId, listItem) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/miniproject/user/wishlist/wishdelete.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        listItem.remove();
                        const bookList = document.getElementById('bookList');
                        if (bookList.children.length === 0) {
                            bookList.innerHTML = '<li>No Books Added</li>';
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            confirmButtonColor: '#1a73e8'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonColor: '#1a73e8'
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error processing response',
                        confirmButtonColor: '#1a73e8'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Request failed. Please try again.',
                    confirmButtonColor: '#1a73e8'
                });
            }
        };
        
        xhr.onerror = function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Network error occurred',
                confirmButtonColor: '#1a73e8'
            });
        };
        
        xhr.send('wishid=' + encodeURIComponent(wishId));
    }
});
</script>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>