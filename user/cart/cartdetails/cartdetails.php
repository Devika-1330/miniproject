<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['username'] == '') {
    header("location: /miniproject/user/login/login.php");
    exit();
}
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$user_id = $_SESSION['id'];
?>

<html>
<head>
    <link rel="stylesheet" href="/miniproject/user/cart/cartdetails/cartdetails.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function setActive(button, url) {
        document.querySelectorAll('.chat-opt button').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        setTimeout(() => {
            window.location.href = url;
        }, 200);
    }

    let openPaymentProductId = null; 

    function loadCartItems() {
        $.ajax({
            url: '/miniproject/user/cart/cartdetails/updatedata.php',
            method: 'POST',
            data: { user_id: '<?php echo $user_id; ?>' },
            success: function(response) {
                $('#cartContainer').html(response);
                attachEventListeners();
                
                if (openPaymentProductId) {
                    $(`#paymentgateway-${openPaymentProductId}`).slideDown(0);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading cart items:', error);
                $('#cartContainer').html('<p>Error loading cart items. Please try again.</p>');
            }
        });
    }

    function attachEventListeners() {
        $('.delete-btn').off('click').on('click', function(e) {
            e.preventDefault();
            const productId = $(this).closest('.cart-item').find('.pay-btn').data('product-id');
            const userId = '<?php echo $user_id; ?>';
            deleteCartItem(productId, userId);
        });

        $('.pay-btn[data-product-id]').off('click').on('click', function() {
            fnPayment(this);
        });

        $('.pay-btn[data-product-id]').each(function() {
            const productId = $(this).data('product-id');
            $(this).next('section').find('.pay-btn').off('click').on('click', function() {
                fnPayNow(this, productId, $(this).data('seller-id'), $(this).data('price'));
            });
        });

        $('.container5 .text-muted').off('click').on('click', function() {
            fnPayment(this);
        });
    }

    function deleteCartItem(productId, userId) {
        $.ajax({
            url: '/miniproject/user/cart/cart.php',
            method: 'GET',
            data: {
                'product-id': productId,
                'user-id': userId
            },
            success: function(response) {
                loadCartItems();
            },
            error: function(xhr, status, error) {
                console.error('Error deleting item:', error);
            }
        });
    }

    function fnPayment(element) {
        const $container = $(element).closest('.cart-item').find('.container5');
        const productId = $(element).closest('.cart-item').find('.pay-btn').data('product-id');
        
        if ($container.is(':visible')) {
            $container.slideUp(300);
            openPaymentProductId = null; 
        } else {
            $container.slideDown(300);
            openPaymentProductId = productId; 
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    }

    function fnPayNow(button, productId, sellerId, price) {
    if (button.disabled) return; // Exit if already disabled

    // Lock the button immediately
    button.disabled = true;
    button.style.backgroundColor = 'grey';
    button.style.cursor = 'not-allowed';
    button.innerHTML = 'Processing...';
    button.onclick = null; // Remove click handler

    // Stop any further interaction with the button
    button.setAttribute('disabled', 'disabled'); // Reinforce with attribute

    // Clear the cart refresh interval to prevent interference
    clearInterval(cartRefreshInterval);

    // Construct URL and redirect with a tiny delay
    const url = '/miniproject/admin/emailvalid/sendmail.php?payprod-id=' + productId + '&recseller-id=' + sellerId + '&price=' + price;
    console.log('Redirecting to:', url); // Debug
    setTimeout(() => {
        window.location.href = url;
    }, 100); // Small delay to ensure UI updates
}

$(document).ready(function() {
    loadCartItems();

    // Store the interval ID
    cartRefreshInterval = setInterval(function() {
        loadCartItems();
    }, 5000);
});
    </script>
</head>

<body>
<div class="chat-opt">
    <button class="cart-btn active" onclick="setActive(this, '/miniproject/user/cart/cartdetails/cartdetails.php')">
        <i class="bi bi-cart4" style="margin-right:10px;"></i>My Cart
    </button>
    <button class="sale-btn" onclick="setActive(this, '/miniproject/user/cart/saledetails/saledetails.php')">
        <i class="bi bi-check-square-fill" style="margin-right:10px;"></i>My Sale
    </button>
</div>

<div class="container">
    <h2 style="color:#4B0FBA;"><i class="bi bi-cart4" style="margin-right:10px;"></i>My Cart</h2>
    <a href="/miniproject/user/history/history.php?choice=purchase&opt=preserve" style="cursor:pointer; text-decoration:none;">
        Your Reserved Book's cancellation can be done from History
    </a>
    <div id="cartContainer">
        
    </div>
</div>
<br><br>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
$connection->close();
?>