
<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join ReRead Community</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        .strength-meter { height: 4px; transition: all 0.3s; }
        .password-criteria li.met { color: #10B981; }
        .password-criteria li.met::before { content: "✓"; margin-right: 5px; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#E5E7EB'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <header class="text-center mb-16">
            <h1 class="font-['Pacifico'] text-5xl mb-4 text-primary">ReRead</h1>
            <h2 class="text-3xl font-bold mb-4">Join Our Reading Community</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">Connect with fellow book lovers, share your reading journey, and discover your next favorite book in our vibrant community.</p>
        </header>

        <div class="grid md:grid-cols-2 gap-12 mb-16">
            <div class="relative">
                <img src="/miniproject/user/welcomepage/header/logorr.png" alt="Reading Community" class="rounded-lg object-cover w-full h-full">
            </div>

            <div class="space-y-8">
                <div class="grid grid-cols-2 gap-6">
                    <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary/10 rounded-full mb-4">
                            <i class="ri-book-open-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Track Your Reading</h3>
                        <p class="text-gray-600">Keep a digital record of your reading journey and set personal goals.</p>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary/10 rounded-full mb-4">
                            <i class="ri-group-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Join Book Clubs</h3>
                        <p class="text-gray-600">Connect with readers who share your interests in virtual book clubs.</p>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary/10 rounded-full mb-4">
                            <i class="ri-discuss-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Engage in Discussions</h3>
                        <p class="text-gray-600">Share your thoughts and participate in meaningful literary discussions.</p>
                    </div>
                    <div class="p-6 bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="w-12 h-12 flex items-center justify-center bg-primary/10 rounded-full mb-4">
                            <i class="ri-gift-line text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Exclusive Content</h3>
                        <p class="text-gray-600">Access exclusive author interviews, reading guides, and member events.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 mb-16">
        <div class="relative">
                <img src="https://public.readdy.ai/ai/img_res/57e58d4a962ce1496b2b15ba18028740.jpg" alt="Reading Community" class="rounded-lg shadow-lg object-cover w-full h-full">
            </div>

            <div class="bg-gray-50 p-8 rounded-lg">
                <h3 class="text-2xl font-bold mb-6">Community Guidelines</h3>
                <div class="space-y-4">
                    <details class="group" open>
                        <summary class="flex items-center justify-between cursor-pointer">
                            <h4 class="text-lg font-medium">Respect & Kindness</h4>
                            <span class="transition group-open:rotate-180">
                                <i class="ri-arrow-down-s-line"></i>
                            </span>
                        </summary>
                        <p class="mt-4 text-gray-600">Treat all community members with respect. We maintain a positive environment where everyone feels welcome to share their thoughts about books and reading.</p>
                    </details>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer">
                            <h4 class="text-lg font-medium">Content Guidelines</h4>
                            <span class="transition group-open:rotate-180">
                                <i class="ri-arrow-down-s-line"></i>
                            </span>
                        </summary>
                        <p class="mt-4 text-gray-600">Share meaningful content related to books, reading, and literary discussion. Avoid spam and promotional content without prior approval.</p>
                    </details>
                    <details class="group">
                        <summary class="flex items-center justify-between cursor-pointer">
                            <h4 class="text-lg font-medium">Privacy & Safety</h4>
                            <span class="transition group-open:rotate-180">
                                <i class="ri-arrow-down-s-line"></i>
                            </span>
                        </summary>
                        <p class="mt-4 text-gray-600">Protect your personal information and respect others' privacy. Report any concerning behavior to our moderation team.</p>
                    </details>
                </div>
            </div>
        </div>

        <div class="text-center">
            <label class="inline-flex items-center mb-6 cursor-pointer">
                
                <input type="checkbox" class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary" required>
                <span class="ml-2 text-gray-600">I agree to the <a href="#" class="text-primary hover:underline">Terms of Service</a> and <a href="#" class="text-primary hover:underline">Community Guidelines</a></span>
            </label>
            <button class="block w-full md:w-auto md:mx-auto px-8 py-3 bg-primary text-white font-semibold rounded-button hover:bg-primary/90 transition-colors cursor-pointer" onclick="window.location.href='/miniproject/user/community/communityenter.php?joincomm=1'">Join ReRead Community</button>
        </div>
    </div>

    </div>
    </div>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>