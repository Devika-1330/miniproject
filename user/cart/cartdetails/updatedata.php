<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

$user_id = $_POST['user_id'];
$total_price = 0;

$query = "SELECT uc.*, p.*, 
          CASE 
              WHEN h.userid = '$user_id' AND h.status = 1 THEN 0  
              WHEN h.status = 2 THEN 1  
              ELSE 2 
          END AS sort_order
          FROM tbl_usercart uc
          INNER JOIN tbl_products p ON uc.productid = p.productid
          LEFT JOIN tbl_history h ON uc.productid = h.productid
          AND (h.status = 1 OR h.status = 2)
          WHERE uc.userid = '$user_id'
          ORDER BY sort_order ASC, p.avstatus = 2 DESC, p.avstatus ASC;";

$result = $connection->query($query);

$output = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $flag = 0;
        $flag1 = 0;
        $product_id = $row['productid'];

        $query4 = "select * from tbl_history where userid='$user_id' and productid='$product_id' and status=1";
        $result4 = $connection->query($query4);
        if($result4->num_rows>0) $flag=1;
        
        $query4 = "select * from tbl_history where userid='$user_id' and productid='$product_id' and status=2";
        $result4 = $connection->query($query4);
        if($result4->num_rows>0) $flag1=1;

        $query2 = "SELECT * FROM tbl_products WHERE productid = '$product_id' and archive=0";
        $product_result = $connection->query($query2);
        $product = $product_result->fetch_assoc();

        if ($product) {
            $total_price += $product['price'];
            $query3 = "SELECT * FROM tbl_productimage WHERE productid = '$product_id'";
            $image_result = $connection->query($query3);
            $image = $image_result->fetch_assoc();

            $output .= "
                <div class='cart-item'>
                    <div class='profile-container-image'>";
            if ($image) {
                $output .= "<img src='data:image/jpeg;base64," . base64_encode($image['image']) . "'/>";
            }
            $output .= "
                    </div>
                    <div class='cart-details'>
                        <p><strong>Title:</strong> " . htmlspecialchars($product['title']) . "</p>
                        <p><strong>Price:</strong> " . htmlspecialchars($product['price']) . "₹</p>
                        <p><strong>Status:</strong> ";
            if($product['avstatus'] == 1) {
                $output .= "<span style='color:green; font-weight:bold;'>Available</span>";
            } else if($product['avstatus'] == 2) {
                $output .= "<span style='color:orangered; font-weight:bold;'>Reserved</span>";
            } else if($product['avstatus'] == 3) {
                $output .= "<span style='color:red; font-weight:bold;'>Sold Out</span>";
            }
            $output .= "</p>";

            if($product['avstatus'] == 2) {
                $output .= "<div class='soldOrReserve'>";
                $output .= ($flag == 1) ? "Reserved For You" : "Reserved";
                $output .= "</div>";
            }
            if($product['avstatus'] == 3) {
                $output .= "<div class='soldOrReserve'>";
                $output .= ($flag1 == 1) ? "Sold Out To You" : "Sold Out";
                $output .= "</div>";
            }
            $output .= "
                    </div>
                    <div class='cart-actions'>
                        <button " . ($flag == 1 ? "style='display:none;'" : "") . " id='delBtn' class='delete-btn'>Delete</button>
                        <button class='details-btn' onclick=\"window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=" . $product_id . "&user-id=" . $product['userid'] . "'\">Details</button>";

            $query4 = "select * from tbl_history where userid='$user_id' and productid='$product_id' and status=1";
            $result4 = $connection->query($query4);
            if($result4->num_rows > 0) {
                $output .= "<button class='pay-btn' data-product-id='" . $product_id . "'>Pay Now</button>";
            }

            $sellerid = $product['userid'];
            $queryfetch = "SELECT name FROM tbl_users WHERE id='$sellerid'";
            $resultfetch = $connection->query($queryfetch);
            $seller_name = "";
            if ($resultfetch->num_rows > 0) {
                $rowfetch = $resultfetch->fetch_assoc();
                $seller_name = $rowfetch['name'];
            }

            $output .= "
                    <section>
                        <div class='container5 py-5' id='paymentgateway-" . $product_id . "' style='display:none'>
                            <div class='row d-flex justify-content-center'>
                                <div class='col-md-8 col-lg-6 col-xl-4'>
                                    <div class='card rounded-3' style='border:2px solid; margin-bottom:350px;'>
                                        <div class='card-body mx-1 my-2'>
                                            <div class='d-flex align-items-center'>
                                                <div><i class='fab fa-cc-visa fa-4x text-body pe-3'></i></div>
                                                <div>
                                                    <p class='d-flex flex-column mb-0'>
                                                        <b>";
            $queryfetch = "SELECT name FROM tbl_users WHERE id='$user_id'";
            $resultfetch = $connection->query($queryfetch);
            if ($resultfetch->num_rows > 0) {
                $rowfetch = $resultfetch->fetch_assoc();
                $output .= htmlspecialchars($rowfetch['name']);
            }
            $output .= "</b>
                                                        <span class='small text-muted'>**** 8880</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class='pt-3'>
                                                <div class='d-flex flex-row pb-3'>
                                                    <div class='rounded border border-primary border-2 d-flex w-100 p-3 align-items-center'>
                                                        <div class='d-flex flex-column'>
                                                            <p class='mb-1 small text-primary'>Total Amount</p>
                                                            <input type='number' class='form-control form-control-sm' style='width: 85px;' value='" . $product['price'] . "' readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='d-flex flex-row pb-3'>
                                                    <div class='rounded border d-flex w-100 px-3 py-2 align-items-center'>
                                                        <div class='d-flex align-items-center pe-3'> To: </div>
                                                        <div class='d-flex flex-column py-1'>
                                                            <h6 class='mb-1 text-primary'>" . htmlspecialchars($seller_name) . "</h6>
                                                            <p class='mb-0 small text-primary'>
                                                                " . htmlspecialchars($seller_name) . "
                                                                <span class='small text-muted'>**** XXXX</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style='text-align:left; width:100%; display:flex; margin-left:10px;'>Powered By: </div>
                                            <div class='imgof-payment'>
                                                <img src='/miniproject/user/welcomepage/footer/footerimage/Screenshot 2025-01-12 233626.png' alt='Visa'>
                                                <img src='/miniproject/user/welcomepage/footer/footerimage/visa.png' alt='MasterCard'>
                                                <img src='/miniproject/user/welcomepage/footer/footerimage/Screenshot 2025-01-12 233707.png' alt='RuPay'>
                                            </div>
                                            <div class='d-flex justify-content-between align-items-center pb-1'>
                                                <button class='text-muted'>Go back</button>
                                                <button class='pay-btn' data-product-id='" . $product_id . "' data-seller-id='" . $sellerid . "' data-price='" . $product['price'] . "'>Pay Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    </div>
                </div>";
        }
    }
    $output .= "<div class='cart-total'><h3>Total: ₹" . $total_price . "</h3></div>";
} else {
    $output .= "<div class='center-text'>
        <img src='/miniproject/user/userchat/nomsg/text-phone.gif' alt='No Messages' loading='lazy' style='width: 200px; height: auto;'>
        <p style='font-weight:bold; font-size:20px;'>Your cart is empty</p>
    </div>";
}

echo $output;
$connection->close();
?>