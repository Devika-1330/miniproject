<?php
include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';
$flag = 1;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$uid=$_SESSION['id'];

$q1 = "SELECT * FROM tbl_products WHERE userid != '$uid' ORDER BY RAND() LIMIT 3";
$r1=$connection->query($q1);
$product1 = $r1->fetch_assoc();
$product2 = $r1->fetch_assoc();
$product3 = $r1->fetch_assoc();
$query = "select * from tbl_products";
$result = $connection->query($query);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
   
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <style>
        :root {
            --primary-color: #6F42C1;
            --secondary-color: #E9ECEF;
            --accent-color: #6F42C1;
            --font-family: 'Poppins', sans-serif;
            --text-dark: #2D2D2D;
            --text-light: #666666;
            --light-bg: #F8F9FA;
            --white: #FFFFFF;
            --transition: all 0.3s ease;
        }
        body {
            font-family: var(--font-family);
            margin: 0;
            padding: 0;
            background: #F8F9FA;
        }
        .container {
            position: relative; /* For arrow positioning */
            padding: 40px 60px; /* Increased padding to accommodate arrows */
            max-width: 1300px;
            margin: auto;
          
        }
        .scroll-wrapper {
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            white-space: nowrap;
            gap: 10px;
            scroll-behavior: smooth;
        }
        .scroll-wrapper::-webkit-scrollbar {
            display: none; /* Hide scrollbar */
        }
        .profile-container {
            cursor: pointer;
            border: none;
            padding: 25px;
            background: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            
            transition: all 0.3s ease;
            text-align: center;
            height: 350px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 0 0 220px;
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
            color: var(--white);
            padding: 3px 20px;
            border-radius: 20px;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .profile-container .btn:hover {
            background: #5A32A3;
            color:white;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .profile-container .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: var(--accent-color);
            color: white;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 15px;
            z-index: 1;
        }
        .avbooks {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin: 40px 0 15px;
            color: var(--primary-color);
            position: relative;
        }
        .avbooks::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 5px;
            transition: width 0.3s ease;
        }
        .avbooks:hover::before {
            width: 80px;
        }
        .section-description {
            text-align: center;
            color: var(--text-light);
            font-size: 16px;
            margin: 25px auto 30px;
            max-width: 800px;
        }
        .scroll-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: white;
            color: var(--primary-color);
            border: none;
            border-radius: 50%;
            font-size: 24px;
            line-height: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            z-index: 10;
        }
        .scroll-arrow:hover {
            background: var(--primary-color);
            color: white;
        }
        .scroll-arrow.left {
            left: -5px;
        }
        .scroll-arrow.right {
            right: -5px;
        }
        .no-profile {
            text-align: center;
            color: var(--primary-color);
            font-size: 16px;
            font-weight: 500;
            margin-top: 30px;
            animation: pulse 2s infinite ease-in-out;
            flex: 0 0 300px;
        }
        @keyframes pulse {
            0%, 100% { opacity: 0.8; }
            50% { opacity: 1; }
        }
        .btn {
            background: var(--primary-color);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: #5A32A3;
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        /* Arrow Buttons */
        .scroll-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px; /* Keeping original size, but you can increase if needed */
            height: 40px;
            background: rgba(255, 255, 255, 0.8);
            color: var(--primary-color);
            border: none;
            padding-bottom:12px;
            border-radius: 50%;
            font-size: 50px; /* Increased from 18px to make the > sign larger */
            font-weight: bold; /* Added to make the > sign bolder */
            line-height: 25px; /* Centers the > vertically within the button */
            text-align: center; /* Centers the > horizontally */
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 10;
            display: none; /* Hidden by default, shown via JS */
        }

        .scroll-arrow:hover {
            background: var(--primary-color);
            color: white;
        }

        .scroll-arrow.left {
            left: -50px; /* Moved inside viewport */
        }

        .scroll-arrow.right {
            right: -50px; /* Moved inside viewport */
            
        }
              /* Slideshow Styles */
              .section-title {
    font-size: 2.5rem;
    margin-bottom: 40px;
    text-align: center;
    position: relative;
    color: var(--light-text);
}

.section-title::after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background-color: var(--secondary-color);
    margin: 15px auto 0;
}

 .btnn {
    display: inline-block;
    background-color: var(--primary-color);
    text-decoration:none;
    color: #fff;
    padding: 12px 24px;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btnn:hover {
    background-color: var(--accent-color);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}
.hero-slider {
    position: relative;
    height: 75vh;
    overflow: hidden;
    margin-bottom: 30px;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    padding: 0 10%;
    opacity: 0;
    transition: opacity 1s ease;
}

.slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, rgba(6, 58, 71, 0.9), rgba(6, 58, 71, 0.6));
}

.slide.active {
    opacity: 1;
}

.slide-content {
    position: relative;
    z-index: 10;
    max-width: 600px;
    color: #fff;
}

.slide-content h2 {
    font-size: 3.2rem;
    margin-bottom: 20px;
    font-weight: 700;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s ease;
    transition-delay: 0.3s;
    line-height: 1.2;
}

.slide-content p {
    font-size: 1.25rem;
    margin-bottom: 30px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s ease;
    transition-delay: 0.5s;
    line-height: 1.6;
}

.slide-buttons {
    display: flex;
    gap: 15px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease, transform 0.8s ease;
    transition-delay: 0.7s;
}

.slide.active .slide-content h2,
.slide.active .slide-content p,
.slide.active .slide-buttons {
    opacity: 1;
    transform: translateY(0);
}

.slider-navigation {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 100;
}

.slider-dot {
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.slider-dot.active {
    background-color: var(--accent-color);
    transform: scale(1.2);
}

        /* Category Section */
        .imageHome {
            display: flex;
            gap: 20px;
            padding: 0 20px;
            max-width: 1300px;
            margin: 40px auto;
        }
        .imageHome-sec {
            position: relative;
            width: 33.33%;
            height: 300px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .imageHome-sec img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .imageHome-sec:hover {
            transform: scale(1.03);
        }
        .imgHome-txt {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 22px;
            font-weight: 700;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 8px 20px;
            border-radius: 8px;
        }
        /* Assurance Section */
        .assurance-section {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 40px 20px;
            max-width: 1300px;
            margin: 0 auto;
            background: white;
        }
        .assurance-item {
            text-align: center;
            padding: 20px;
            width: 25%;
            transition: all 0.3s ease;
        }
        .assurance-item i {
            font-size: 40px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        .assurance-item h4 {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
        }
        .assurance-item p {
            font-size: 14px;
            color: #666;
        }
        .assurance-item:hover {
            transform: translateY(-5px);
        }
        /* Newsletter Section */
       
        /* How-to Section */
       
        /* Container for layout */
/* welcome sec */


.welcome-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
}

.welcome-content {
    flex: 1;
}

.welcome-content h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 20px;
    line-height: 1.2;
    display: flex;
    align-items: center;
    gap: 15px;
}

.welcome-content h1 i {
    font-size: 2rem;
    color: var(--accent-color);
}

.welcome-content .lead {
    font-size: 1.3rem;
    font-weight: 500;
    color: var(--text-dark);
    margin-bottom: 15px;
    line-height: 1.5;
}

.welcome-content .stats {
    display: flex;
    align-items: center;
    font-size: 1.1rem;
    color: var(--text-light);
    margin-bottom: 25px;
    gap: 10px;
}

.welcome-content .stats i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.welcome-content .stats strong {
    color: var(--accent-color);
    font-weight: 700;
    font-size: 1.2rem;
}

.welcome-actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.welcome-btn {
    display: inline-block;
    padding: 12px 28px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    transition: var(--transition);
    text-align: center;
}

.welcome-btn.primary {
    background-color: var(--primary-color);
    color: white;
}

.welcome-btn.primary:hover {
    background-color: var(--accent-color);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.welcome-btn.secondary {
    background-color: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.welcome-btn.secondary:hover {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.welcome-image {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.welcome-image img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.5s ease;
}

.welcome-image img:hover {
    transform: translateY(-10px);
}

@media (max-width: 992px) {
    .welcome-container {
        flex-direction: column-reverse;
        text-align: center;
    }
    
    .welcome-content h1 {
        justify-content: center;
    }
    
    .welcome-content .stats {
        justify-content: center;
    }
    
    .welcome-actions {
        justify-content: center;
    }
    
    .welcome-image img {
        max-height: 300px;
    }
}

@media (max-width: 576px) {
    .welcome-content h1 {
        font-size: 2rem;
    }
    
    .welcome-content .lead {
        font-size: 1.1rem;
    }
    
    .welcome-content .stats {
        font-size: 1rem;
    }
    
    .welcome-actions {
        flex-direction: column;
    }
}
        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                flex: 0 0 250px;
                height: 380px;
            }
            .imageHome {
                flex-direction: column;
            }
            .imageHome-sec {
                width: 100%;
                height: 250px;
            }
            .assurance-section {
                flex-direction: column;
            }
            .assurance-item {
                width: 100%;
            }
            .scroll-arrow.left {
                left: 5px;
            }
            .scroll-arrow.right {
                right: 5px;
            }
        }
        @media (max-width: 480px) {
            .profile-container {
                flex: 0 0 280px;
                height: 360px;
            }
            .profile-container img {
                width: 180px;
                height: 220px;
            }
            .profile-container .title {
                font-size: 16px;
            }
            .profile-container .price {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
  
     <!-- Swiper Slideshow -->
     <section class="hero-slider" id="home">
        <div class="slide" style="background-image: url('/miniproject/find books near you.webp');">
            <div class="slide-content">
                <h2>Your Next Book is Just a Tap Away</h2>
                <p>Buy, sell, borrow, and exchange books easily with ReRead - connecting book lovers worldwide</p>
                <div class="slide-buttons">
                    <a href="#available-books" class="btnn primary">Explore Now</a>
                    <a href="/miniproject/user/sellproduct/sellproduct.php" class="btnn secondary">List Your Book</a>
                </div>
            </div>
        </div>

        <div class="slide active" style="background-image:url('/miniproject/community.webp');">
            <div class="slide-content">
                <h2>Join the Book Lovers Community</h2>
                <p>Over 500,000+ readers have found their perfect books through our platform</p>
                <div class="slide-buttons">
                    <a href="/miniproject/user/login/login.php" class="btnn primary" id="jointoday">Join Today</a>
                    <a href="/miniproject/user/community/community.php" class="btnn secondary">Meet Community</a>
                </div>
            </div>
        </div>

        <div class="slide" style="background-image: url('/miniproject/trade and discover.webp');">
            <div class="slide-content">
                <h2>Sustainable Reading for Everyone</h2>
                <p>Donate, rent, exchange - make reading affordable and eco-friendly</p>
                <div class="slide-buttons">
                    <a href="#how-to" class="btnn primary">Our Services</a>
                    <a href="/miniproject/user/products/nearby/nearby.php" class="btnn secondary">Find Nearby</a>
                </div>
            </div>
        </div>

        <div class="slider-navigation">
            <div class="slider-dot"></div>
            <div class="slider-dot active"></div>
            <div class="slider-dot"></div>
        </div>
        </section>
        
        <style>
        /* Enhanced Hero Slider */
        .hero-slider {
            position: relative;
            height: 75vh;
            overflow: hidden;
            margin-bottom: 30px;
        }
        
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 0 10%;
            opacity: 0;
            transition: opacity 1s ease;
        }
        
        .slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(6, 58, 71, 0.9), rgba(6, 58, 71, 0.6));
        }
        
        .slide.active {
            opacity: 1;
        }
        
        .slide-content {
            position: relative;
            z-index: 10;
            max-width: 600px;
            color: #fff;
        }
        
        .slide-content h2 {
            font-size: 3.2rem;
            margin-bottom: 20px;
            font-weight: 700;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            transition-delay: 0.3s;
            line-height: 1.2;
        }
        
        .slide-content p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            transition-delay: 0.5s;
            line-height: 1.6;
        }
        
        .slide-buttons {
            display: flex;
            gap: 15px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            transition-delay: 0.7s;
        }
        
        .slide.active .slide-content h2,
        .slide.active .slide-content p,
        .slide.active .slide-buttons {
            opacity: 1;
            transform: translateY(0);
        }
        
        .slider-navigation {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 100;
        }
        
        .slider-dot {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .slider-dot.active {
            background-color: var(--accent-color);
            transform: scale(1.2);
        }
        
        .btnn {
            display: inline-block;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 16px;
            transition: var(--transition);
            text-align: center;
        }
        
        .btnn.primary {
            background-color: var(--accent-color);
            color: #fff;
        }
        
        .btnn.primary:hover {
            background-color: #FF6A3D;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .btnn.secondary {
            background-color: transparent;
            color: #fff;
            border: 2px solid #fff;
        }
        
        .btnn.secondary:hover {
            background-color: #fff;
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        @media (max-width: 992px) {
            .slide-content h2 {
                font-size: 2.5rem;
            }
            
            .slide-content p {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero-slider {
                height: 80vh;
            }
            
            .slide-content h2 {
                font-size: 2rem;
            }
            
            .slide-content p {
                font-size: 1rem;
            }
            
            .slide-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .btnn {
                padding: 10px 24px;
                font-size: 14px;
            }
        }
        </style>
  <script>
            // Wait for the DOM to fully load
document.addEventListener('DOMContentLoaded', function() {
    // Hero Slider
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    let currentSlide = 1; // Start with the second slide (index 1)
    let slideInterval;

    // Initialize the slider
    function startSlider() {
        slideInterval = setInterval(() => {
            nextSlide();
        }, 5000); // Change slide every 5 seconds
    }

    // Show the specified slide
    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });

        // Remove active class from all dots
        dots.forEach(dot => {
            dot.classList.remove('active');
        });

        // Show the current slide and activate corresponding dot
        slides[index].classList.add('active');
        dots[index].classList.add('active');

        // Update current slide index
        currentSlide = index;
    }

    // Go to next slide
    function nextSlide() {
        let nextIndex = currentSlide + 1;

        // If we've reached the end, go back to the first slide
        if (nextIndex >= slides.length) {
            nextIndex = 0;
        }

        showSlide(nextIndex);
    }

    // Add click events to slider dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            // Clear the interval when manually changing slides
            clearInterval(slideInterval);

            // Show the clicked slide
            showSlide(index);

            // Restart the interval
            startSlider();
        });
    });

    // Start the slider
    startSlider();

});

            </script>

        <!-- Welcome Section at the Top -->
<?php if($_SESSION['username'] == '') { ?>
    <div class="65">
        <div class="welcome-container">
            <div class="welcome-content">
                <h1><i class="bi bi-book-half"></i>Unlock a World of Books</h1>
                <p class="lead">Trade, explore, and rediscover stories with readers just like you.</p>
                <p class="stats"><i class="bi bi-people-fill"></i>Over <strong>1,500+</strong> book lovers are already exchanging their favorite reads.</p>
                <div class="welcome-actions">
                    <a href="/miniproject/user/login/login.php" class="welcome-btn primary">Start Your Journey</a>
                    <a href="#how-to" class="welcome-btn secondary">How It Works</a>
                </div>
            </div>
            <div class="welcome-image">
                <img src="/miniproject/user/products/prodimg/book-lover.png" alt="Book Lover" onerror="this.src='/miniproject/find books near you.webp'; this.style.opacity=0.7;">
            </div>
         </div>
            </div>
          <?php } else { ?>
            <script>
                document.getElementById("jointoday").style.display="none";
                </script>
             <div class="welcome-section">
         <div class="welcome-container">
            <div class="welcome-content">
                <h1>Hello <?php
                    $uid = $_SESSION['id'];
                    $query = "select name from tbl_users where id='$uid'";
                    $result = $connection->query($query);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo $row['name'];
                        }
                    }
                ?>!</h1>
                <p class="lead">Welcome back to your book community.</p>
                <p class="stats"><i class="bi bi-people-fill"></i>Over <strong>1,500+</strong> book lovers are exchanging books right now.</p>
                <div class="welcome-actions">
                    <a href="/miniproject/user/sellproduct/sellproduct.php" class="welcome-btn primary">List a Book</a>
                    
                    <a href="/miniproject/user/products/nearby/nearby.php" class="welcome-btn secondary">Find Nearby</a>
                </div>
            </div>
            <div class="welcome-image">
                <img src="/miniproject/user/products/prodimg/book-lover.png" alt="Book Lover" onerror="this.src='/miniproject/find books near you.webp'; this.style.opacity=0.7;">
            </div>
        </div>
    </div>
<?php } ?>
   

   

<!-- Welcome Section at the Top -->
<!-- Welcome Section at the Top -->

 

<div class="avbooks">Available Books</div>
<div class="container" id="available-books">
    <button class="scroll-arrow left" data-container="available-picks-scroll">‹</button>
    <div class="scroll-wrapper" id="available-picks-scroll">
        <?php
        if (empty($_SESSION['id'])) {
            $query = "select * from tbl_products";
            $result = $connection->query($query);
        } else {
            $uid = $_SESSION['id'];
            $query = "select * from tbl_products where userid!='$uid'";
            $result = $connection->query($query);
        }
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $query2 = "SELECT * FROM tbl_productimage";
                $result2 = $connection->query($query2);
                $flag = 1;
                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        if ($row['productid'] == $row2['productid'] && $row['userid'] != $_SESSION['id'] && $flag != 0 && $row['appstatus'] == 1 && $row['archive'] == 0 && $row['avstatus'] == 1) {
                            ?>
                            <div class="profile-container" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="<?php echo $row['title']; ?>"/>
                                <p class="title"><?php echo $row['title']; ?></p>
                                <p class="price"><?php echo $row['price']; ?>₹</p>
                                <p class="posted">Posted: <?php 
                                    $currentDateTime = strtotime(date("Y-m-d H:i:s"));
                                    $soldDateTime = strtotime($row['date']);
                                    $diff = abs($currentDateTime - $soldDateTime);
                                    $days = floor($diff / (60 * 60 * 24));
                                    echo $days == 0 ? "Today" : $days . " days ago";
                                ?></p>
                                 <a href="/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>" class="btn">View Details</a>
                            </div>
                            <?php $flag = 0;
                        }
                    }
                }
            }
        } else {
            ?>
            <p class="no-profile">No Profile Found</p>
            <?php
        }
        ?>
    </div>
    <button class="scroll-arrow right" data-container="available-picks-scroll">›</button>
</div>
    <!-- Our Picks -->
    <div class="avbooks">Our Picks</div>
    <div class="container" id="our-picks">
        <button class="scroll-arrow left" data-container="our-picks-scroll">‹</button>
        <div class="scroll-wrapper" id="our-picks-scroll">
            <?php
            if (empty($_SESSION['id'])) {
                $query = "select * from tbl_products";
                $result = $connection->query($query);
            } else {
                $uid = $_SESSION['id'];
                $query = "select * from tbl_products where userid!='$uid'";
                $result = $connection->query($query);
            }
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $query2 = "SELECT * FROM tbl_productimage";
                    $result2 = $connection->query($query2);
                    $flag = 1;
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            if ($row['productid'] == $row2['productid'] && $row['userid'] != $_SESSION['id'] && $flag != 0 && $row['appstatus'] == 1 && in_array($row['genre'], ['Fiction', 'Fantasy', 'Romance', 'Thriller']) && $row['archive'] == 0 && $row['avstatus'] == 1) {
                                ?>
                                <div class="profile-container" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="<?php echo $row['title']; ?>"/>
                                    <p class="title"><?php echo $row['title']; ?></p>
                                    <p class="price"><?php echo $row['price']; ?>₹</p>
                                    <p class="posted">Posted: <?php 
                                        $currentDateTime = strtotime(date("Y-m-d H:i:s"));
                                        $soldDateTime = strtotime($row['date']);
                                        $diff = abs($currentDateTime - $soldDateTime);
                                        $days = floor($diff / (60 * 60 * 24));
                                        echo $days == 0 ? "Today" : $days . " days ago";
                                    ?></p>
                                   <a href="/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>" class="btn">View Details</a>

                                </div>
                                <?php $flag = 0;
                            }
                        }
                    }
                }
            } else {
                ?>
                <p class="no-profile">No Profile Found</p>
                <?php
            }
            ?>
        </div>
        <button class="scroll-arrow right" data-container="our-picks-scroll">›</button>
    </div>
 

    <!-- Latest Releases -->
    <div class="avbooks">Latest Releases</div>
    <div class="container" id="latest-releases">
        <button class="scroll-arrow left" data-container="latest-releases-scroll">‹</button>
        <div class="scroll-wrapper" id="latest-releases-scroll">
            <?php
            if (empty($_SESSION['id'])) {
                $query = "select * from tbl_products order by date desc";
                $result = $connection->query($query);
            } else {
                $uid = $_SESSION['id'];
                $query = "select * from tbl_products where userid!='$uid' order by date desc";
                $result = $connection->query($query);
            }
            $five_days_ago = date('Y-m-d', strtotime('-20 days'));
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $query2 = "SELECT * FROM tbl_productimage";
                    $result2 = $connection->query($query2);
                    $flag = 1;
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            if ($row['productid'] == $row2['productid'] && $row['userid'] != $_SESSION['id'] && $flag != 0 && $row['appstatus'] == 1 && $row['avstatus'] == 1 && $row['date'] > $five_days_ago) {
                                ?>
                                <div class="profile-container" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="<?php echo $row['title']; ?>"/>
                                    <p class="title"><?php echo $row['title']; ?></p>
                                    <p class="price"><?php echo $row['price']; ?>₹</p>
                                    <p class="posted">Posted: <?php 
                                        $currentDateTime = strtotime(date("Y-m-d H:i:s"));
                                        $soldDateTime = strtotime($row['date']);
                                        $diff = abs($currentDateTime - $soldDateTime);
                                        $days = floor($diff / (60 * 60 * 24));
                                        echo $days == 0 ? "Today" : $days . " days ago";
                                    ?></p>
                                     <a href="/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>" class="btn">View Details</a>
                                </div>
                                <?php $flag = 0;
                            }
                        }
                    }
                }
            } else {
                ?>
                <p class="no-profile">No Profile Found</p>
                <?php
            }
            ?>
        </div>
        <button class="scroll-arrow right" data-container="latest-releases-scroll">›</button>
    </div>

    <!-- New Arrivals -->
    

<?php
 $currid=$_SESSION['id'];
 $query = "
   SELECT 
    userid,
    COUNT(productid) AS book_count
FROM 
    tbl_products
WHERE 
    appstatus = 1 
    AND avstatus = 1 
    AND archive = 0
    and userid !='$currid'
GROUP BY 
    userid
ORDER BY 
    book_count DESC
LIMIT 3";
$result = $connection->query($query);
?>
<section>
<!-- Best Sellers Section -->
<div class="avbooks">Best Sellers <i class="bi bi-star-fill" style="margin-left:10px;"></i></div>
<p style="text-align: center; color: #666; font-size: 14px; margin: 10px 0;">Discover our top book traders who bring passion and variety to every exchange!</p>
<div class="best-sellers">
    <div class="sellers-grid">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Fetch user profile image (assuming a separate table or default image)
                $user_id = $row['userid'];
                $queryofuser = "SELECT image,name,username, bio FROM tbl_users WHERE id = '$user_id' LIMIT 1";
                $profile = $connection->query($queryofuser);
                $profile_data = $profile->num_rows > 0 ? $profile->fetch_assoc() : null;
                $imageuser=$profile_data ? $profile_data['image'] : "";
                $urname= $profile_data ? $profile_data['username'] : "User #$user_id";
                $user_name = $profile_data ? $profile_data['name'] : "User #$user_id";
                $user_bio = $profile_data ? $profile_data['bio'] : "No bio available";
                ?>
                <div class="seller-card">
                    <img src="<?php if( $imageuser!='') { ?>/miniproject/user/login/loginimg/<?php echo htmlspecialchars($urname); ?>.<?php echo pathinfo($imageuser, PATHINFO_EXTENSION); ?> <?php } else { echo "/miniproject/user/login/loginimg/default-profile-pic.png";?> <?php }?>" alt="<?php echo $row['userid']; ?>" class="profile-pic"/>
                    <h3 class="seller-name"><?php echo $user_name; ?></h3>
                    <p class="seller-bio">Listed <?php echo $row['book_count']; ?> books for exchange!</p>
                    <a href="/miniproject/user/viewprofile/viewprofile.php?request-profile=<?php echo $user_id; ?>" class="btn">View Profile</a>
                </div>
                <?php
            }
        } else {
            echo '<p style="text-align: center; color: #666;">No top sellers found yet!</p>';
        }
        ?>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const sellerCards = document.querySelectorAll('.seller-card');
    
    // Animation parameters
    const amplitude = 20; // How far up and down (in pixels)
    const frequency = 0.002; // Speed of the animation
    
    // Animate each card with a slight phase offset for variety
    sellerCards.forEach((card, index) => {
        let time = index * 1000; // Offset each card's animation
        
        function animate() {
            time += 16; // Approximately 60fps
            // Calculate new position using sine wave
            const yOffset = Math.sin(time * frequency + index) * amplitude;
            // Apply transform
            card.style.transform = `translateY(${yOffset}px)`;
            // Request next frame
            requestAnimationFrame(animate);
        }
        
        // Start animation
        animate();
    });
});
</script>
<style>
    .best-sellers {
        max-width: 1300px;
        margin: 40px auto;
        padding: 0 20px;
        text-align: center;
        
    }
    
    .sellers-grid {
        display: flex;
        justify-content: center;
        gap: 40px;
        padding: 20px 0;
        flex-wrap: wrap;
    }

    .seller-card {
        position: relative;
        width: 250px;
        height: 250px;
        background: linear-gradient(135deg, var(--primary-color), #5A32A3);
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .seller-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        scale: 1.05;
    }

    .profile-pic {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: fill;
        border: 2px solid white;
        margin-bottom: 10px;
        transition: transform 0.3s ease;
    }

    .seller-card:hover .profile-pic {
        transform: scale(1.08);
    }

    .seller-name {
        font-size: 18px;
        font-weight: bold;
        margin: 5px 0;
    }

    .seller-bio {
        font-size: 14px;
        opacity: 0.9;
        max-width: 90%;
    }

    .seller-card .btn {
        background: white;
        color: #7b42f6;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .seller-card .btn:hover {
        background: #ffffffcc;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .sellers-grid {
            flex-direction: column;
            align-items: center;
        }
        .seller-card {
            width: 200px;
            height: 200px;
        }
        .profile-pic {
            width: 80px;
            height: 80px;
        }
        .seller-name {
            font-size: 16px;
        }
        .seller-bio {
            font-size: 13px;
        }
    }
</style>

    <!-- Category Highlights -->
    <div class="avbooks">Explore Categories</div>
    <div class="imageHome">
        <div class="imageHome-sec" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Education'">
            <img src="/miniproject/user/products/prodimg/f2kPO29U3UT96SxfCo4i--1--2txdx.png" alt="Education Books">
            <div class="imgHome-txt">Education Books</div>
        </div>
        <div class="imageHome-sec" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Fiction'">
            <img src="/miniproject/user/products/prodimg/depositphotos_84175848-stock-illustration-open-book-with-rocket.jpg" alt="Fiction Books">
            <div class="imgHome-txt">Fictional Books</div>
        </div>
        <div class="imageHome-sec" onclick="window.location.href='/miniproject/user/products/category/categoryproduct.php?status=Romance'">
            <img src="/miniproject/user/products/prodimg/Screenshot 2025-03-04 194802.png" alt="Romance Books">
            <div class="imgHome-txt">Romantic Books</div>
        </div>
    </div>
    <br>

    <!-- How-to Section -->
    <div class="how-to-section" id="how-to">
    <!-- How-to Section -->
<div class="how-to-section">
    <h2 class="avbooks">How to Sell on <span>ReRead</span></h2>
    <p class="how-to-intro">Get started in minutes and trade books with our community!</p>
    <div class="how-to-grid">
        <div class="how-to-item">
            <i class="bi bi-person-plus-fill"></i>
            <p>Sign Up Free</p>
            <span>Create your account in seconds.</span>
        </div>
        <div class="how-to-item">
            <i class="bi bi-book-half"></i>
            <p>List Your Book</p>
            <span>Add details and photos easily.</span>
        </div>
        <div class="how-to-item">
            <i class="bi bi-check-circle-fill"></i>
            <p>Get Verified</p>
            <span>We'll review it fast.</span>
        </div>
        <div class="how-to-item">
            <i class="bi bi-arrow-left-right"></i>
            <p>Start Trading</p>
            <span>Swap with readers near you.</span>
        </div>
    </div>
</div>

<style>
.how-to-section {
    max-width: 1300px;
    margin: 40px auto;
    padding: 0 20px;
    text-align: center;
}

.how-to-section h2 span {
    color: var(--primary-color);
}

.how-to-intro {
    font-size: 16px;
    color: #666;
    margin: 20px 0 20px;
    font-weight: 500;
}

.how-to-grid {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.how-to-item {
    background: white;
    border-radius: 15px;
    margin-top:20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 20%;
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.how-to-item:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.how-to-item i {
    font-size: 30px;
    color: var(--primary-color);
    margin-bottom: 10px;
}

.how-to-item p {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0 0 5px;
}

.how-to-item span {
    font-size: 13px;
    color: #666;
    line-height: 1.4;
    max-height: 40px;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (max-width: 768px) {
    .how-to-grid {
        flex-direction: column;
        gap: 15px;
    }
    .how-to-item {
        width: 100%;
        padding: 20px;
    }
    .how-to-item span {
        font-size: 12px;
    }
}
</style>
<br>
   
    <!-- Scripts -->
    <script>
// Define functions globally
function updateArrows(containerId) {
    const wrapper = document.getElementById(containerId);
    const leftArrow = wrapper.parentElement.querySelector('.scroll-arrow.left');
    const rightArrow = wrapper.parentElement.querySelector('.scroll-arrow.right');
    
    const scrollLeft = wrapper.scrollLeft;
    const scrollWidth = wrapper.scrollWidth;
    const clientWidth = wrapper.clientWidth;

    if (scrollWidth > clientWidth) { // Only show arrows if there's overflow
        leftArrow.style.display = scrollLeft > 0 ? 'block' : 'none';
        rightArrow.style.display = scrollLeft < scrollWidth - clientWidth - 1 ? 'block' : 'none';
    } else {
        leftArrow.style.display = 'none';
        rightArrow.style.display = 'none';
    }
}

function scrollContainer(containerId, amount) {
    const wrapper = document.getElementById(containerId);
    wrapper.scrollLeft += amount;
    updateArrows(containerId);
}

function attachArrowEvents(containerId) {
    const wrapper = document.getElementById(containerId);
    if (wrapper) {
        const arrows = wrapper.parentElement.querySelectorAll('.scroll-arrow');
        arrows.forEach(arrow => {
            arrow.removeEventListener('click', arrowClickHandler); // Remove old listeners
            arrow.addEventListener('click', arrowClickHandler);
        });
    }
}

function arrowClickHandler() {
    const containerId = this.getAttribute('data-container');
    const direction = this.classList.contains('left') ? -600 : 600;
    scrollContainer(containerId, direction);
}

// DOMContentLoaded event listener for initialization
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Swiper
    const swiper = new Swiper('.mySwiper', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });

    // Initialize arrows for all sections
    const sections = ['available-picks-scroll', 'our-picks-scroll', 'latest-releases-scroll'];
    sections.forEach(containerId => {
        const wrapper = document.getElementById(containerId);
        if (wrapper) {
            updateArrows(containerId);
            wrapper.addEventListener('scroll', () => updateArrows(containerId));
            attachArrowEvents(containerId);
        }
    });

    // Handle resize for all sections
    window.addEventListener('resize', () => {
        sections.forEach(containerId => updateArrows(containerId));
    });

    // Periodically fetch and update "Available Books" only
    const dynamicContainerId = 'available-picks-scroll';
    setInterval(() => {
        fetch("/miniproject/user/products/loadproducts.php")
            .then(response => response.text())
            .then(data => {
                const wrapper = document.getElementById(dynamicContainerId);
                if (wrapper && wrapper.innerHTML !== data) {
                    wrapper.innerHTML = data;
                    updateArrows(dynamicContainerId);
                    attachArrowEvents(dynamicContainerId); // Reattach events after update
                }
            })
            .catch(error => console.error("Error:", error));
    }, 5000);
});
</script>
</div>
</body>
</html>
