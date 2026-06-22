<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include $_SERVER['DOCUMENT_ROOT'].'/miniproject/commonconnect.php';

if (isset($_GET['choice'])) {
    $choice = $_GET['choice'];
    $uid = $_SESSION['id'];
    if ($choice == 'purchase') { ?>
        <h3><i class="bi bi-cart4"></i> Purchase History</h3>
        <?php
        if (isset($_GET['opt'])) {
            $opt = $_GET['opt'];
            if ($opt == 'preserve') { ?>
                <h4>Books Reserved for You</h4>
                <?php
                $status = 1;
                $query = "SELECT * FROM tbl_history WHERE userid='$uid' AND status='$status'";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['productid'];
                        $query2 = "SELECT * FROM tbl_products WHERE productid = '$product_id'";
                        $product_result = $connection->query($query2);
                        $product = $product_result->fetch_assoc();
                        if ($product) {
                            $query3 = "SELECT * FROM tbl_productimage WHERE productid = '$product_id'";
                            $image_result = $connection->query($query3);
                            $image = $image_result->fetch_assoc();
                            ?>
                            <div class="cart-item">
                                <div class="profile-container-image">
                                    <?php if ($image) { ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" alt="Book Image"/>
                                    <?php } ?>
                                </div>
                                <div class="cart-details">
                                    <p><strong>Title:</strong> <?php echo $product['title']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $product['price']; ?>₹</p>
                                    <p><strong>Method:</strong> <?php echo $row['method'] == 1 ? "Offline" : "Online"; ?></p>
                                    <p><strong>From:</strong> <?php 
                                        $sellerid = $row['sellerid'];
                                        $stmt2 = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
                                        $stmt2->bind_param("i", $sellerid);
                                        $stmt2->execute();
                                        $result3 = $stmt2->get_result();
                                        echo $result3->fetch_assoc()['username'];
                                    ?></p>
                                    <p><strong>Date:</strong> <?php echo $row['trdate']; ?></p>
                                    <?php if ($product['avstatus'] == 2) { ?>
                                        <div class="soldOrReserve">Reserved</div>
                                    <?php } elseif ($product['avstatus'] == 3) { ?>
                                        <div class="soldOrReserve">Sold Out</div>
                                    <?php } ?>
                                </div>
                                <div class="cart-actions">
                                    <?php if ($product['archive'] == 0) { ?>
                                        <button class="details-btn" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $product_id; ?>&user-id=<?php echo $product['userid']; ?>'">Details</button>
                                        <button class="details-btn cancel-reserve" 
                                            style="background:orangered;" 
                                            data-sellerid="<?php echo $row['sellerid']; ?>"
                                            data-productid="<?php echo $row['productid']; ?>">Cancel</button>
                                        <a href="/miniproject/user/cart/cartdetails/cartdetails.php" class="details-btn">Pay Now</a>
                                    <?php } else { ?>
                                        <button class="details-btn cancel-reserve" 
                                            style="background:orangered;" 
                                            data-sellerid="<?php echo $row['sellerid']; ?>"
                                            data-productid="<?php echo $row['productid']; ?>">Cancel</button>
                                        <strong style="color: #666;">Product removed by seller</strong>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else { ?>
                    <div class="center-text">
                        <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy">
                        <p>No Books Reserved For You</p>
                    </div>
                <?php }
            } elseif ($opt == 'pbought') { ?>
                <h4>Books Bought By You</h4>
                <?php
                $status = 2;
                $query = "SELECT * FROM tbl_history WHERE userid='$uid' AND status='$status'";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['productid'];
                        $query2 = "SELECT * FROM tbl_products WHERE productid = '$product_id'";
                        $product_result = $connection->query($query2);
                        $product = $product_result->fetch_assoc();
                        if ($product) {
                            $query3 = "SELECT * FROM tbl_productimage WHERE productid = '$product_id'";
                            $image_result = $connection->query($query3);
                            $image = $image_result->fetch_assoc();
                            ?>
                            <div class="cart-item">
                                <div class="profile-container-image">
                                    <?php if ($image) { ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" alt="Book Image"/>
                                    <?php } ?>
                                </div>
                                <div class="cart-details">
                                    <p><strong>Title:</strong> <?php echo $product['title']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $product['price']; ?>₹</p>
                                    <p><strong>Method:</strong> <?php echo $row['method'] == 1 ? "Offline" : "Online"; ?></p>
                                    <p><strong>From:</strong> <?php 
                                        $sellerid = $row['sellerid'];
                                        $stmt2 = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
                                        $stmt2->bind_param("i", $sellerid);
                                        $stmt2->execute();
                                        $result3 = $stmt2->get_result();
                                        echo $result3->fetch_assoc()['username'];
                                    ?></p>
                                    <p><strong>Date:</strong> <?php echo $row['trdate']; ?></p>
                                    <?php if ($product['avstatus'] == 3) { ?>
                                        <div class="soldOrReserve">Sold Out</div>
                                    <?php } ?>
                                </div>
                                <div class="cart-actions">
                                    <?php if ($product['archive'] == 0) { ?>
                                        <button class="details-btn" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $product_id; ?>&user-id=<?php echo $product['userid']; ?>'">Details</button>
                                    <?php } else { ?>
                                        <strong style="color: #666;">Product removed by seller</strong>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else { ?>
                    <div class="center-text">
                        <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy">
                        <p>You Haven't Bought Any Books</p>
                    </div>
                <?php }
            }
        }
    } elseif ($choice == 'sales') { ?>
        <h3><i class="bi bi-check-square-fill"></i> Sales History</h3>
        <?php
        if (isset($_GET['opt'])) {
            $opt = $_GET['opt'];
            if ($opt == 'salereserve') { ?>
                <h4>Books Reserved By You</h4>
                <?php
                $status = 1;
                $query = "SELECT * FROM tbl_history WHERE sellerid='$uid' AND status='$status'";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['productid'];
                        $query2 = "SELECT * FROM tbl_products WHERE productid = '$product_id'";
                        $product_result = $connection->query($query2);
                        $product = $product_result->fetch_assoc();
                        if ($product) {
                            $query3 = "SELECT * FROM tbl_productimage WHERE productid = '$product_id'";
                            $image_result = $connection->query($query3);
                            $image = $image_result->fetch_assoc();
                            ?>
                            <div class="cart-item">
                                <div class="profile-container-image">
                                    <?php if ($image) { ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" alt="Book Image"/>
                                    <?php } ?>
                                </div>
                                <div class="cart-details">
                                    <p><strong>Title:</strong> <?php echo $product['title']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $product['price']; ?>₹</p>
                                    <p><strong>Method:</strong> <?php echo $row['method'] == 1 ? "Offline" : "Online"; ?></p>
                                    <p><strong>To:</strong> <?php 
                                        $buyerid = $row['userid'];
                                        $stmt2 = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
                                        $stmt2->bind_param("i", $buyerid);
                                        $stmt2->execute();
                                        $result3 = $stmt2->get_result();
                                        echo $result3->fetch_assoc()['username'];
                                    ?></p>
                                    <p><strong>Date:</strong> <?php echo $row['trdate']; ?></p>
                                    <?php if ($product['avstatus'] == 2) { ?>
                                        <div class="soldOrReserve">Reserved</div>
                                    <?php } ?>
                                </div>
                                <div class="cart-actions">
                                    <?php if ($product['archive'] == 0) { ?>
                                        <button class="details-btn" onclick="window.location.href='/miniproject/user/cart/saledetails/saleitem.php?product_id=<?php echo $product_id; ?>&user-id=<?php echo $product['userid']; ?>'">Details</button>
                                    <?php } else { ?>
                                        <strong style="color: #666;">Product removed by you</strong>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else { ?>
                    <div class="center-text">
                        <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy">
                        <p>No Books Reserved By You</p>
                    </div>
                <?php }
            } elseif ($opt == 'salesold') { ?>
                <h4>Books Bought From You</h4>
                <?php
                $status = 2;
                $query = "SELECT * FROM tbl_history WHERE sellerid='$uid' AND status='$status'";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $product_id = $row['productid'];
                        $query2 = "SELECT * FROM tbl_products WHERE productid = '$product_id'";
                        $product_result = $connection->query($query2);
                        $product = $product_result->fetch_assoc();
                        if ($product) {
                            $query3 = "SELECT * FROM tbl_productimage WHERE productid = '$product_id'";
                            $image_result = $connection->query($query3);
                            $image = $image_result->fetch_assoc();
                            ?>
                            <div class="cart-item">
                                <div class="profile-container-image">
                                    <?php if ($image) { ?>
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image['image']); ?>" alt="Book Image"/>
                                    <?php } ?>
                                </div>
                                <div class="cart-details">
                                    <p><strong>Title:</strong> <?php echo $product['title']; ?></p>
                                    <p><strong>Price:</strong> <?php echo $product['price']; ?>₹</p>
                                    <p><strong>Method:</strong> <?php echo $row['method'] == 1 ? "Offline" : "Online"; ?></p>
                                    <p><strong>To:</strong> <?php 
                                        $buyerid = $row['userid'];
                                        $stmt2 = $connection->prepare("SELECT username FROM tbl_users WHERE id = ?");
                                        $stmt2->bind_param("i", $buyerid);
                                        $stmt2->execute();
                                        $result3 = $stmt2->get_result();
                                        echo $result3->fetch_assoc()['username'];
                                    ?></p>
                                    <p><strong>Date:</strong> <?php echo $row['trdate']; ?></p>
                                    <?php if ($product['avstatus'] == 3) { ?>
                                        <div class="soldOrReserve">Sold Out</div>
                                    <?php } ?>
                                </div>
                                <div class="cart-actions">
                                    <?php if ($product['archive'] == 0) { ?>
                                        <button class="details-btn" onclick="window.location.href='/miniproject/user/cart/saledetails/saleitem.php?product_id=<?php echo $product_id; ?>&user-id=<?php echo $product['userid']; ?>'">Details</button>
                                    <?php } else { ?>
                                        <strong style="color: #666;">Product removed by you</strong>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                } else { ?>
                    <div class="center-text">
                        <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Messages" loading="lazy">
                        <p>No Books Sold From You</p>
                    </div>
                <?php }
            }
        }
    }
}
?>