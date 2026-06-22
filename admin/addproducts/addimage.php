<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ob_start();  

$flag = 0;
$image_inputs = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

    $avstatus = 1;  
    $archive = 0;
    $appstatus = 0;

    $stmt = $connection->prepare(
        "INSERT INTO tbl_products (userid, title, price, description, genre, bkcondition, date, avstatus, appstatus, archive) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("isdssssiii", $_SESSION['id'], $_SESSION['title'], $_SESSION['price'], $_SESSION['description'], $_SESSION['genre'], $_SESSION['condition'], $_SESSION['date'], $avstatus, $appstatus, $archive);

    if ($stmt->execute()) {
        $pid = $connection->insert_id;
        $_SESSION['pid'] = $pid;
    }

    if (isset($_FILES['book_images1'])) $image_inputs[] = $_FILES['book_images1'];
    if (isset($_FILES['book_images2'])) $image_inputs[] = $_FILES['book_images2'];
    if (isset($_FILES['book_images3'])) $image_inputs[] = $_FILES['book_images3'];
    if (isset($_FILES['book_images4'])) $image_inputs[] = $_FILES['book_images4'];

    foreach ($image_inputs as $image) {
        $tmp_name = $image['tmp_name'];
        $file_type = $image['type'];

        if (in_array($file_type, ['image/jpg', 'image/jpeg', 'image/png'])) {
            $image_data = file_get_contents($tmp_name);
            $stmt = $connection->prepare("INSERT INTO tbl_productimage (productid, image) VALUES (?, ?)");
            $null = NULL;
            $stmt->bind_param("ib", $_SESSION['pid'], $null);
            $stmt->send_long_data(1, $image_data);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Only JPG, JPEG, and PNG files are allowed.";
        }
    }

    $requiredParams = ['title', 'pid', 'price', 'description', 'genre', 'condition', 'date'];
    foreach ($requiredParams as $param) {
        if (isset($_SESSION[$param])) {
            unset($_SESSION[$param]);
        }
    }

    ob_end_clean();  
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
echo "<script>
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: 'Your book has been submitted. We are reviewing it now <br> <b>stay tuned for updates.</b>',
            confirmButtonText: 'OK',
            backdrop: true
        }).then(() => {
            window.location.href = '/miniproject/user/welcomepage/homepage.php';
        });
    }, 300);
</script>";


    exit();
}
?>
