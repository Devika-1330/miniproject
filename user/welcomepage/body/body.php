<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ReRead</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <style>
    :root {
      --primary-color: #6F42C1; /* Booksaw’s primary purple */
      --secondary-color: #E9ECEF; /* Light gray */
      --font-family: 'Poppins', sans-serif;
      --text-dark: #2D2D2D;
    }
    body {
      font-family: var(--font-family);
      margin: 0;
      padding: 0;
      background: #F8F9FA;
    }
    /* Swiper Parent */
    .swiper-parent {
      height: 500px; /* Taller like Booksaw’s hero */
      width: 100%;
      max-width: 100%;
      margin: 0;
      overflow: hidden;
      position: relative;
      border-radius: 0; /* Full-width, no rounded corners */
    }
    /* Swiper Container */
    .swiper-container {
      width: 100%;
      height: 100%;
      position: relative;
    }
    .swiper-slide {
      position: relative;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .swiper-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Booksaw uses cover for a polished look */
      display: block;
    }
    /* Text Overlay */
    .swiper-slide .text-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      width: 80%;
      max-width: 800px;
      padding: 20px;
      z-index: 2;
    }
    .swiper-slide .text-overlay::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Darker overlay for readability */
      z-index: -1;
      border-radius: 10px;
    }
    .swiper-slide .text-overlay h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 15px;
      line-height: 1.2;
    }
    .swiper-slide .text-overlay p {
      font-size: 1.25rem;
      font-weight: 400;
      margin-bottom: 20px;
    }
    .swiper-slide .text-overlay .btn {
      background: var(--primary-color);
      color: white;
      padding: 12px 30px;
      border-radius: 25px;
      text-decoration: none;
      font-size: 1rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .swiper-slide .text-overlay .btn:hover {
      background: #5A32A3;
      transform: scale(1.05);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    /* Pagination */
    .swiper-pagination {
      bottom: 20px;
    }
    .swiper-pagination-bullet {
      width: 12px;
      height: 12px;
      background: white;
      opacity: 0.7;
      margin: 0 6px;
    }
    .swiper-pagination-bullet-active {
      opacity: 1;
      background: var(--primary-color); /* Match primary color */
    }
    /* Navigation Buttons */
    .swiper-button-next,
    .swiper-button-prev {
      color: white;
      width: 40px;
      height: 40px;
      background: rgba(0, 0, 0, 0.3);
      border-radius: 50%;
      transition: all 0.3s ease;
    }
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
      background: var(--primary-color);
    }
    .swiper-button-next:after,
    .swiper-button-prev:after {
      font-size: 18px;
    }
    /* Responsive Design */
    @media (max-width: 768px) {
      .swiper-parent {
        height: 400px;
      }
      .swiper-slide .text-overlay h1 {
        font-size: 2rem;
      }
      .swiper-slide .text-overlay p {
        font-size: 1rem;
      }
    }
    @media (max-width: 480px) {
      .swiper-parent {
        height: 300px;
      }
      .swiper-slide .text-overlay h1 {
        font-size: 1.5rem;
      }
      .swiper-slide .text-overlay p {
        font-size: 0.9rem;
      }
      .swiper-slide .text-overlay .btn {
        padding: 10px 20px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="swiper-parent">
    <div class="swiper swiper-container mySwiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide">
          <img src="/miniproject/user/welcomepage/body/Untitled (1).jpg" alt="New Stories">
          <div class="text-overlay">
            <h1>Discover New Stories</h1>
            <p>Explore a world of books waiting to be rediscovered.</p>
            <a href="/miniproject/user/login/login.php" class="btn">Start Exploring</a>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="swiper-slide">
          <img src="/miniproject/user/welcomepage/body/Untitled (2).jpg" alt="Trade Books">
          <div class="text-overlay">
            <h1>Trade Your Books</h1>
            <p>Share your favorites and find new reads.</p>
            <a href="/miniproject/user/login/login.php" class="btn">Join Now</a>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="swiper-slide">
          <img src="/miniproject/user/welcomepage/body/Untitled (3).jpg" alt="Community">
          <div class="text-overlay">
            <h1>Join Our Community</h1>
            <p>Connect with over 1,500+ book lovers.</p>
            <a href="/miniproject/user/login/login.php" class="btn">Get Started</a>
          </div>
        </div>
      </div>
      <!-- Pagination -->
      <div class="swiper-pagination"></div>
      <!-- Navigation buttons -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>

  <!-- Swiper Initialization Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const swiper = new Swiper('.mySwiper', {
        loop: true,
        autoplay: {
          delay: 3000, // 3 seconds per slide
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
    });
  </script>
</body>
</html>