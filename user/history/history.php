<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['username'] == '') {
    header("location: /miniproject/user/login/login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

// Handle AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    ob_end_clean();
    include 'history_content.php';
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php'; 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/miniproject/user/history/history.css">
    <script>
        let pollingInterval; // To store the interval ID

        function clicked(x) {
            let url;
            if (x == 1) {
                url = '/miniproject/user/history/history.php?choice=purchase&opt=preserve';
            } else {
                url = '/miniproject/user/history/history.php?choice=sales&opt=salereserve';
            }
            loadContent(url);
            updateSidebar(x === 1 ? 'purchase' : 'sales');
            window.history.pushState({}, document.title, url);
            startPolling(url); // Restart polling with the new URL
        }

        function loadContent(url) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.querySelector('.book-section').innerHTML = xhr.responseText;
                    attachEventListeners();
                    updateButtonStates();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load content. Status: ' + xhr.status,
                        confirmButtonColor: '#3085d6'
                    });
                }
            };
            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Network error occurred',
                    confirmButtonColor: '#3085d6'
                });
            };
            xhr.send();
        }

        function updateSidebar(choice) {
            const sidebar = document.querySelector('.sidebar1');
            if (choice === 'purchase') {
                sidebar.innerHTML = `
                    <button onclick="loadContent('/miniproject/user/history/history.php?choice=purchase&opt=preserve')">Reserved</button>
                    <button onclick="loadContent('/miniproject/user/history/history.php?choice=purchase&opt=pbought')">Purchased</button>
                `;
            } else if (choice === 'sales') {
                sidebar.innerHTML = `
                    <button onclick="loadContent('/miniproject/user/history/history.php?choice=sales&opt=salereserve')">Reserved</button>
                    <button onclick="loadContent('/miniproject/user/history/history.php?choice=sales&opt=salesold')">Sold</button>
                `;
            }
            attachEventListeners();
            updateButtonStates();
        }

        function updateButtonStates() {
            const urlParams = new URLSearchParams(window.location.search);
            const choice = urlParams.get('choice');
            const opt = urlParams.get('opt');

            const chatButtons = document.querySelectorAll(".chat-opt button");
            chatButtons.forEach(btn => {
                btn.classList.remove('active');
                if ((choice === 'purchase' && btn.textContent.includes('Purchases')) || 
                    (choice === 'sales' && btn.textContent.includes('Sales'))) {
                    btn.classList.add('active');
                }
            });

            const sidebarButtons = document.querySelectorAll(".sidebar1 button");
            sidebarButtons.forEach(btn => {
                btn.classList.remove('active');
                if ((opt === 'preserve' && btn.textContent.includes('Reserved')) || 
                    (opt === 'pbought' && btn.textContent.includes('Purchased')) ||
                    (opt === 'salereserve' && btn.textContent.includes('Reserved')) || 
                    (opt === 'salesold' && btn.textContent.includes('Sold'))) {
                    btn.classList.add('active');
                }
            });
        }

        function attachEventListeners() {
            document.querySelectorAll('.cancel-reserve').forEach(button => {
                button.removeEventListener('click', handleCancelClick);
                button.addEventListener('click', handleCancelClick);
            });

            document.querySelectorAll('.sidebar1 button').forEach(button => {
                button.removeEventListener('click', handleSidebarClick);
                button.addEventListener('click', handleSidebarClick);
            });
        }

        function handleCancelClick() {
            const sellerId = this.getAttribute('data-sellerid');
            const productId = this.getAttribute('data-productid');
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to cancel this reservation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    cancelReservation(sellerId, productId, this.closest('.cart-item'));
                }
            });
        }

        function handleSidebarClick(e) {
            e.preventDefault();
            const url = this.getAttribute('onclick').match(/'(.*?)'/)[1];
            loadContent(url);
            window.history.pushState({}, document.title, url);
            startPolling(url); // Restart polling with the new URL
        }

        function cancelReservation(sellerId, productId, cartItem) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/miniproject/user/history/cancelreserve.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            cartItem.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled!',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                            const cartItems = document.querySelectorAll('.cart-item');
                            if (cartItems.length === 0) {
                                const container = document.querySelector('.book-section');
                                container.innerHTML = `
                                    <div class="center-text">
                                        <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy">
                                        <p>No Books Reserved For You</p>
                                    </div>
                                `;
                                attachEventListeners();
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error processing response',
                            confirmButtonColor: '#3085d6'
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Request failed. Please try again.',
                        confirmButtonColor: '#3085d6'
                    });
                }
            };
            
            xhr.onerror = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Network error occurred',
                    confirmButtonColor: '#3085d6'
                });
            };
            
            xhr.send(`seller-id=${encodeURIComponent(sellerId)}&product-id=${encodeURIComponent(productId)}`);
        }

        // Start polling for updates
        function startPolling(url) {
            if (pollingInterval) {
                clearInterval(pollingInterval); // Clear existing interval
            }
            pollingInterval = setInterval(() => {
                loadContent(url); // Fetch latest content
            }, 10000); // Every 10 seconds (adjust as needed)
        }

        // Stop polling when leaving the page
        window.addEventListener('beforeunload', function() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const initialChoice = "<?php echo $_GET['choice']; ?>";
            const initialUrl = window.location.pathname + window.location.search;
            updateSidebar(initialChoice || 'purchase'); // Default to purchase if no choice
            loadContent(initialUrl);
            updateButtonStates();
            startPolling(initialUrl); // Start polling with initial URL
        });
    </script>
</head>
<body>
    <div class="mainsec">
        <div class="chat-opt">
            <button onclick="clicked(1)"><i class="bi bi-cart4" style="margin-right:10px;"></i>Purchases</button>
            <button onclick="clicked(2)"><i class="bi bi-check-square-fill" style="margin-right:10px;"></i>Sales</button>
        </div>
        <div class="sidebar1">
            <!-- Sidebar will be populated dynamically by JavaScript -->
        </div>
    </div>
    <div class="container">
        <main class="book-section">
            <?php include 'history_content.php'; ?>
        </main>
    </div>
</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>