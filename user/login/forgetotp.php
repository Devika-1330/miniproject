<?php

if (session_status() === PHP_SESSION_NONE) {
   session_start();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userotp = $_POST['otp'];
    $sessionOtp = $_SESSION['otp'];

    if ($userotp == $sessionOtp) {
        echo 'OTP has been verified successfully!';
        // Redirect or proceed with the next step
        header("location: /miniproject/user/login/forgetpass.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        :root {
            --primary-color: #4B0FBA;
            --secondary-color: #d1c4ff;
            --font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            font-family: var(--font-family);
 
            color: var(--primary-color);
        }

        .otp-container {
            max-width: 500px;
            display:flex;
            flex-direction:column;
            margin: 50px auto;
            align-items:center;
            justify=content:center;
            padding: 20px;
            border: 1px solid var(--secondary-color);
            border-radius: 10px;
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .otp-container h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 300px;
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: var(--secondary-color);
            outline: none;
        }

        .otp-button {
            width: 100%;
            padding: 10px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .otp-button:hover {
            background-color: var(--secondary-color);
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h1>OTP Verification</h1>
        <form method="post">
            <div class="form-group">
                <label for="otp">OTP</label>
                <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            </div>
            <button type="submit" class="otp-button">Verify</button>

            <?php
            // Display error message if OTP verification fails
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && $userotp != $sessionOtp) {
                echo '<div class="error-message">OTP verification failed. Please try again.</div>';
            }
            ?>
        </form>
    </div>
</body>

