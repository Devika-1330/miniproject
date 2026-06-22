
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/welcomepage/header/header.php';
if (isset($_GET['status'])) {
    $genre = $_GET['status'];
} else {
    $genre = '';
}
$minprice = 0;
$maxprice = 100000;
if (isset($_GET['minprice']) && isset($_GET['maxprice'])) {
    $minprice = $_GET['minprice'];
    $maxprice = $_GET['maxprice'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(ucfirst($genre)); ?> Books</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #6F42C1;
            --secondary-color: #E9ECEF;
            --font-family: 'Poppins', sans-serif;
            --text-dark: #2D2D2D;
        }
        body {
            font-family: var(--font-family);
            margin: 0;
            padding: 0;
            background: #F8F9FA;
        }
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            gap: 20px;
        }
        .avbooks {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin: 40px 0 20px;
            color: var(--primary-color);
            position: relative;
        }
        .avbooks::before {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        .avbooks:hover::before {
            width: 70px;
        }
        .sidebar1 {
            width: 300px;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 20px;
            height: 500px;
        }
        .sidebar1 h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .sidebar1 p {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
        }
        .sidebar1 h3 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 15px 0 10px;
        }
        .sidebar1 label {
            display: block;
            margin: 8px 0;
            font-size: 16px;
            color: var(--text-dark);
            cursor: pointer;
        }
        .sidebar1 input[type="radio"] {
            margin-right: 8px;
            accent-color: var(--primary-color);
        }
        .book-section {
            flex: 1;
        }
        .top-bar {
            margin-bottom: 20px;
        }
        .top-bar p {
            font-size: 16px;
            color: #666;
        }
        .top-bar strong {
            color: var(--primary-color);
            font-weight: 600;
        }
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .profile-container {
            cursor: pointer;
            border: none;
            padding: 25px;
            background: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            transition: all 0.3s ease;
            text-align: center;
            height: 350px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin:15px 0px;
        }
        .profile-container:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-8px);
        }
        .profile-container img {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            object-fit: fill;
            transition: transform 0.3s ease;
            margin: 0 auto;
        }
        .profile-container:hover img {
            transform: scale(1.05);
        }
        .profile-container .title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin: 15px 0 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .profile-container .price {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 5px 0;
        }
        .profile-container .posted {
            font-size: 14px;
            color: #666;
            margin: 5px 0 15px;
        }
        .profile-container .btn {
            background: var(--primary-color);
            color: white;
            padding: 3px 20px;
            border: none;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .profile-container .btn:hover {
            background: #5A32A3;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .center-text {
            text-align: center;
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 500;
            margin: 30px 0;
        }
        .center-text img {
            width: 200px;
            height: auto;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 10px;
            }
            .sidebar1 {
                width: 100%;
                position: static;
            }
        }
    </style>
</head>


<body>
    <h2 class="avbooks"><?php echo htmlspecialchars(ucfirst($genre)); ?> Books <i class="bi bi-book" style="margin-left:10px;"></i></h2>
    <div class="container">
        <div class="sidebar1">
            <h2>Filters</h2>
            <p>Refine your search for better results</p>
            <h3>Price Range</h3>
            <?php
            $priceRanges = [
                [0, 100000, "All price"],
                [0, 100, "0-100"],
                [101, 200, "101-200"],
                [200, 400, "200-400"],
                [400, 1000, "400-1000"],
                [1000, 3000, "1000-3000"],
                [3000, 100000, "3000 above"]
            ];
            foreach ($priceRanges as [$min, $max, $label]) {
                $checked = ($minprice == $min && $maxprice == $max) ? 'checked' : '';
                echo "<label><input type='radio' name='price_range' data-min='$min' data-max='$max' $checked> $label</label>";
            }
            ?>
        </div>

        <main class="book-section">
            <div class="top-bar" id="results-count"></div>
            <div class="book-grid" id="book-grid"></div>
        </main>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/welcomepage/footer/footer.php'; ?>

    <script>
    function loadBooks(minPrice, maxPrice, genre) {
        console.log('Loading books with:', { minPrice, maxPrice, genre });
        
        $.ajax({
            url: '/miniproject/user/products/category/fetch_books.php',
            method: 'POST',
            data: {
                minprice: minPrice,
                maxprice: maxPrice,
                genre: genre
            },
            dataType: 'json',
            beforeSend: function() {
                $('#book-grid').html('<div class="center-text">Loading...</div>');
            },
            success: function(data) {
                console.log('Raw response:', data);
                if (data.error) {
                    $('#book-grid').html(`<div class="center-text"><p>Error: ${data.error}</p></div>`);
                    $('#results-count').html('');
                    return;
                }
                $('#results-count').html(`<p>Showing <strong>${data.count}</strong> results for <strong>${genre.charAt(0).toUpperCase() + genre.slice(1)}</strong></p>`);
                $('#book-grid').html(data.html);
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                console.error('Response text:', xhr.responseText);
                $('#book-grid').html(`<div class="center-text"><p>Failed to load books: ${status} - ${xhr.responseText}</p></div>`);
                $('#results-count').html('');
            }
        });
    }

    $(document).ready(function() {
        const initialMin = <?php echo json_encode($minprice); ?>;
        const initialMax = <?php echo json_encode($maxprice); ?>;
        const genre = <?php echo json_encode($genre); ?>;
        loadBooks(initialMin, initialMax, genre);

        $('input[name="price_range"]').on('change', function() {
            const minPrice = $(this).data('min');
            const maxPrice = $(this).data('max');
            loadBooks(minPrice, maxPrice, genre);
            const newUrl = `${window.location.pathname}?minprice=${minPrice}&maxprice=${maxPrice}&status=${encodeURIComponent(genre)}`;
            window.history.pushState({}, document.title, newUrl);
        });
    });
    </script>
</body>
</html>