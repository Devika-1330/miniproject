<?php
// updateprof.php
ob_start(); // Start output buffering
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: /miniproject/user/login/login.php");
    exit();
}

$uid = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
    $pin = filter_var($_POST['pin'], FILTER_SANITIZE_NUMBER_INT);
    $dob = filter_var($_POST['dob'], FILTER_SANITIZE_STRING);
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);

    // Handle profile picture upload
    $profilePicPath = "";
    $uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/login/loginimg/';

    if (isset($_FILES['profile-pic']) && $_FILES['profile-pic']['error'] != UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['profile-pic'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        // Get username and current image for unique filename
        $userQuery = "SELECT username, image FROM tbl_users WHERE id='$uid'";
        $userResult = $connection->query($userQuery);
        $userData = $userResult->fetch_assoc();
        $username = $userData['username'];
        $oldImage = $userData['image'];

        if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = $username . '.' . $extension;
            $profilePicPath = $newFileName;

            // Delete old image if it exists and isn't the default
            if (!empty($oldImage) && file_exists($uploadPath . $oldImage) && 
                $oldImage !== 'default-profile-pic.png') {
                unlink($uploadPath . $oldImage);
            }

            // Move new uploaded file
            if (!move_uploaded_file($file['tmp_name'], $uploadPath . $newFileName)) {
                $_SESSION['error'] = "Error uploading new profile picture.";
                header("Location: /miniproject/user/login/signup/signup.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid file type or size. Please upload JPG, PNG or GIF under 5MB.";
            header("Location: /miniproject/user/login/signup/signup.php");
            exit();
        }
    }

    // Prepare update query
    $query = "UPDATE tbl_users SET 
        name = ?, 
        phone = ?, 
        address = ?, 
        location = ?, 
        pin = ?, 
        dob = ?, 
        bio = ?";

    // Add image to query if it was uploaded
    if (!empty($profilePicPath)) {
        $query .= ", image = ?";
    }

    $query .= " WHERE id = ?";

    // Prepare statement
    $stmt = $connection->prepare($query);
    
    // Bind parameters with correct types
    if (!empty($profilePicPath)) {
        $stmt->bind_param("sdssisssi", 
            $name,          // s (varchar(50))
            $phone,         // d (double)
            $address,       // s (varchar(100))
            $location,      // s (varchar(200))
            $pin,           // i (int)
            $dob,           // s (date - handled as string)
            $bio,           // s (varchar(1500))
            $profilePicPath,// s (varchar(100))
            $uid            // i (int)
        );
    } else {
        $stmt->bind_param("sdssissi", 
            $name,          // s (varchar(50))
            $phone,         // d (double)
            $address,       // s (varchar(100))
            $location,      // s (varchar(200))
            $pin,           // i (int)
            $dob,           // s (date - handled as string)
            $bio,           // s (varchar(1500))
            $uid            // i (int)
        );
    }

    // Execute and check result
    if ($stmt->execute()) {
        $stmt->close();
        $connection->close();
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: /miniproject/admin/panel/test.php"); // Redirect back to form
        exit();
    } else {
        $_SESSION['error'] = "Error updating profile: " . $connection->error;
        $stmt->close();
        $connection->close();
        header("Location: /miniproject/user/login/signup/signup.php");
        exit();
    }
} else {
    // If not POST request, redirect back
    header("Location: /miniproject/user/login/signup/signup.php");
    exit();
}

ob_end_flush(); // Flush output buffer
exit();
?>