<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: /miniproject/user/login/login.php");
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uid = $_SESSION['id'];
    $message = $_POST['post_content'] ?? '';
    $img = null; 

 
    if (isset($_FILES['post_image']) && is_uploaded_file($_FILES['post_image']['tmp_name'])) {
        $img = file_get_contents($_FILES['post_image']['tmp_name']);
    }
   
    elseif (isset($_FILES['sticker_image']) && is_uploaded_file($_FILES['sticker_image']['tmp_name'])) {
        $img = file_get_contents($_FILES['sticker_image']['tmp_name']);
    }

  
    $stmt = $connection->prepare(
        "INSERT INTO tbl_community_msgs (userid, message, image) 
         VALUES (?, ?, ?)"
    );
    $stmt->bind_param("iss", $uid, $message, $img);
    $stmt->execute();
    $stmt->close();
    $connection->close();


    echo "Success";
    exit();
}

if (isset($_GET['joincomm'])) {
    $uid = $_SESSION['id'];
    $status = 0;

    $stmt = $connection->prepare(
        "INSERT INTO tbl_community (userid, status) 
         VALUES (?, ?)"
    );
    $stmt->bind_param("ii", $uid, $status);
    $stmt->execute();
    $stmt->close();
    $connection->close();

    header("Location: /miniproject/user/community/community.php");
    exit();
}

if (isset($_GET['msgid'])) {
    $uid = $_SESSION['id'];
    $msgid = $_GET['msgid'];
    
   
    $stmt = $connection->prepare(
        "DELETE FROM tbl_community_msgs WHERE msgid = ? AND userid = ?"
    );
    $stmt->bind_param("ii", $msgid, $uid);
    
    if ($stmt->execute()) {
        $stmt->close();
        $connection->close();
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete message']);
    }
    exit();
}
?>