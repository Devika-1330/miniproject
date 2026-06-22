<?php 
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['username'])) {
  $_SESSION['username'] = '';
  $_SESSION['id'] = '';
}
?>
<?php if ($_SESSION['username'] != '') { ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById("beforesign").style.display = "none";
      document.getElementById("aftersign").style.display = "block";
      document.getElementById("aftersign").innerHTML = "<?php echo $_SESSION['username']; ?>";
    });
  </script>
<?php } ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/miniproject/user/welcomepage/header/header.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <title>ReRead</title>
  <style>
    #aftersign {
      display: none;
    }
  </style>
  <script>
    function sidebar(x) {
      const sidebar = document.getElementById('sidebar');
      if (x == 1) {
        sidebar.classList.toggle('show');
      } else if (x == 2) {
        sidebar.classList.remove('show');
      }
    }

    function logout() {
      var x = document.getElementById("logout-container");
      if (x.style.display == "block") {
        x.style.display = "none";
      } else {
        x.style.display = "block";
      }
    }

    function isSearch() {
      var x = document.getElementById("keysearch");
      var y = document.getElementById("searchbar"); 
      var str = y.value;
      if (str == '') {
        x.style.display = "none";
        return;
      }
      if (x.style.display == "block") {
        x.style.display = "none";
      } else {
        x.style.display = "block";
      }
      fetch("/miniproject/user/welcomepage/header/search.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "search=" + encodeURIComponent(str)
      })
      .then(response => response.text())
      .then(data => {
        x.innerHTML = data;
        x.style.display = data.trim() ? "block" : "none";
      });
    }

    function isSearchBtn() {
      var y = document.getElementById("searchbar"); 
      var str = y.value;
      if (str == '') {
        return;
      }
      window.location.href = '/miniproject/user/products/search/search.php?status=' + str;
    }

    function closeLogoutPopup() {
      document.getElementById("logout-container").style.display = "none";
    }

    function showCat() {
      document.getElementById("categories").style.display = "block";
    }

    function hideCat() {
      document.getElementById("categories").style.display = "none";
    }

    function isNotify() {
      document.getElementById("warning").style.display = "none";
      window.location.href = '/miniproject/user/notification/notification.php';
    }

    function showNotifyPreview() {
      const preview = document.getElementById("notify-preview");
      fetch("/miniproject/user/welcomepage/header/notify_preview.php")
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            preview.innerHTML = data.map(item => 
              `<div class="notify-item" onclick="window.location.href='/miniproject/user/notification/notification.php'">
                ${item.message}
              </div>`
            ).join('');
            preview.style.display = "block";
          } else {
            preview.innerHTML = '<div class="notify-item">No new notifications</div>';
            preview.style.display = "block";
          }
        })
        .catch(error => {
          console.error("Error fetching notifications:", error);
          preview.innerHTML = '<div class="notify-item">Error loading preview</div>';
          preview.style.display = "block";
        });
    }

    function hideNotifyPreview() {
      document.getElementById("notify-preview").style.display = "none";
    }
  </script>
</head>
<body>
  <header class="static-header">
    <div class="top-bar" onmouseover="hideCat()">
      <div class="logo">
        <div class="logoandtext"> 
          <button class="menu-button" type="button" onclick="sidebar(1)">☰</button> 
          <div class="logorr"><img src="/miniproject/user/welcomepage/header/logorr.png"></div>
          <div class="logo-name"> 
            ReRead
            <div class="logo-quote">Escape. Explore. ReRead</div>
          </div> 
        </div>  
      </div>
      <div class="search-bar">
        <input type="text" id="searchbar" placeholder="Search Books" oninput="isSearch()">
        <button class="search-button" onclick="isSearchBtn()">Search</button>
        <div class="keysearch" id="keysearch"></div>
      </div>
      <div class="user-actions">
        <a href="#notify" class="notification" onmouseover="showNotifyPreview()" onmouseout="hideNotifyPreview()" onclick="isNotify()">
          <i class="bi bi-bell"></i>
          <div class="warning" id="warning"></div>
          <div class="notify-preview" id="notify-preview"></div>
        </a>
        <a href="/miniproject/user/cart/cartdetails/cartdetails.php" class="cart"><i class="bi bi-cart"></i>My Deals</a>
        <a href="/miniproject/user/wishlist/wishlist.php" class="wishlist">Wishlist</a>
        <a href="/miniproject/user/login/login.php" class="signin" id="beforesign">Sign In</a>
        <a style="cursor:pointer;" onclick="logout()" class="signin" id="aftersign"></a>
      </div>
    </div>
    <nav>
      <a onmouseover="hideCat()" href="/miniproject/user/welcomepage/homepage.php">Home</a>
      <a onmouseover="showCat()" style="cursor:pointer;">Categories 
        <div class="categories" id="categories" onmouseout="hideCat()">
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Fiction'">Fiction</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Non-Fiction'">Non-Fiction</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Romance'">Romance</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Sci-Fi'">Sci-Fi</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Mystery'">Mystery</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Fantasy'">Fantasy</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Horror'">Horror</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Thriller'">Thriller</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Others'">Others</div>
          <div class="category" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Education'">Education</div>
        </div>
      </a>
      <a href="/miniproject/user/products/nearby/nearby.php" onmouseover="hideCat()">Books Nearby</a>
      <a href="/miniproject/user/sellproduct/sellproduct.php" class="sell" onmouseover="hideCat()">Sell</a>
    </nav>
  </header>

  <div class="sidebar" id="sidebar">
    <div class="goback"><button class="go" onclick="sidebar(2)">☰</button></div>
    <ul class="sidelist">
      <li><a href="/miniproject/admin/panel/test.php"><i class="bi bi-person-fill" style="margin-right:10px;"></i>Profile</a></li>
      <li><a href="/miniproject/user/userchat/userchat.php"><i class="bi bi-chat-dots-fill" style="margin-right:10px;"></i>Chats</a></li>
      <li><a href="/miniproject/user/community/community.php"><i class="bi bi-people-fill" style="margin-right:10px;"></i>Communities</a></li>
      <li><a href="/miniproject/user/history/history.php?choice=purchase&opt=preserve"><i class="bi bi-cart4" style="margin-right:10px;"></i>History</a></li>
    </ul>
  </div>

  <div class="logout-container" id="logout-container">
    <div class="logout-popup">
      <div class="profilesec">
        <div class="profihead">
          <h4>Confirm logout</h4>
        </div>
        Do You Want To Logout?
      </div>
      <div class="modal-buttons">
        <button class="cancel-button" onclick="closeLogoutPopup()">Cancel</button>
        <button class="logout-button" onclick="window.location.href='/miniproject/user/logout/logout.php?status=1'">Logout →</button>
      </div>
    </div>
  </div>

  <script>
    setInterval(function() {
      jQuery.ajax({
        type: 'GET',
        url: '/miniproject/user/welcomepage/header/notofy.php',
        dataType: 'json',
        success: function(response) {
          if (response.display) {
            document.getElementById("warning").style.display = "block";
          } else {
            document.getElementById("warning").style.display = "none";
          }
        }
      });
    }, 1000);
  </script>
</body>
</html>