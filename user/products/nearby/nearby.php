<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['username'])) {
    header("location: /miniproject/user/login/login.php");
    exit();
}

$minprice = 0;
$maxprice = 100000;
if (isset($_GET['minprice']) && isset($_GET['maxprice'])) {
    $minprice = $_GET['minprice'];
    $maxprice = $_GET['maxprice'];
}
$uid = $_SESSION['id'];
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/welcomepage/header/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';
$stmt = $connection->prepare("SELECT location FROM tbl_users WHERE id = ?");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result2 = $stmt->get_result();

$location = isset($_GET['locationopt']) ? strtolower($_GET['locationopt']) : strtolower($result2->fetch_assoc()['location']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books Near You</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
        .locselect {
            max-width: 1300px;
            margin: 20px auto;
            display: flex;
            justify-content: flex-end;
            padding: 0 20px;
        }
        .locselect select {
            width: 250px;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 25px;
            border: 1px solid #ced4da;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .locselect select:hover {
            border-color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .locselect select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
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
            .locselect {
                justify-content: center;
            }
            .locselect select {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
    <script>
        function redirectToLocation(select) {
            let district = select.value;
            if (district) {
                window.location.href = `/miniproject/user/products/nearby/nearby.php?locationopt=${encodeURIComponent(district)}`;
            }
        }
    </script>
</head>
<body>
<h2 class="avbooks">Books Near You <i class="bi bi-geo-alt-fill" style="margin-left:10px;"></i></h2>
    <div class="locselect">
        <select name="district" class="form-select" id="districtDropdown" onchange="redirectToLocation(this)">
            <option value="" disabled <?php if (!isset($_GET['locationopt'])) echo 'selected'; ?>>Select a district</option>
            <?php
            $districts = [
                "Thiruvananthapuram", "Kollam", "Pathanamthitta", "Alappuzha", "Kottayam", "Idukki",
                "Ernakulam", "Thrissur", "Palakkad", "Malappuram", "Kozhikode", "Wayanad", "Kannur", "Kasaragod"
            ];
            foreach ($districts as $district) {
                $selected = strtolower($location) === strtolower($district) ? 'selected' : '';
                echo "<option value='$district' $selected>$district</option>";
            }
            ?>
        </select>
    </div>


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
                echo "<label><input type='radio' onclick=\"window.location.href='/miniproject/user/products/nearby/nearby.php?minprice=$min&maxprice=$max&locationopt=$location'\" $checked> $label</label>";
            }
            ?>
        </div>

        <main class="book-section">
            <?php
            $count = 0;
            $users = [];
            $query1 = "SELECT * FROM tbl_products WHERE userid != '$uid' AND archive=0 AND avstatus=1";
            $result1 = $connection->query($query1);
            while ($row1 = $result1->fetch_assoc()) {
                $query = "SELECT * FROM tbl_users WHERE id != '$uid'";
                $result = $connection->query($query);
                while ($row = $result->fetch_assoc()) {
                    if ($row['id'] == $row1['userid'] && (stripos(strtolower($row['location']), $location) !== false || stripos($location, strtolower($row['location'])) !== false)) {
                        $count++;
                        if (!in_array($row['id'], $users)) {
                            $users[] = $row['id'];
                        }
                    }
                }
            }
            ?>
            <div class="top-bar">
                <p>Showing results for <strong><?php echo ucfirst($location); ?></strong></p>
            </div>
            <div class="book-grid">
                <?php
                $check = 0;
                foreach ($users as $userId) {
                    $query = "SELECT * FROM tbl_products WHERE userid = '$userId' AND userid != '$uid' AND archive=0 AND avstatus=1 AND price > $minprice AND price <= $maxprice";
                    $result = $connection->query($query);
                    while ($row = $result->fetch_assoc()) {
                        $query2 = "SELECT * FROM tbl_productimage WHERE productid = '{$row['productid']}' LIMIT 1";
                        $result2 = $connection->query($query2);
                        if ($result2->num_rows > 0 && $row['appstatus'] == 1) {
                            $row2 = $result2->fetch_assoc();
                            $check = 1;
                            ?>
                            <div class="profile-container" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="<?php echo $row['title']; ?>"/>
                                <p class="title"><?php echo $row['title']; ?></p>
                                <p class="price"><?php echo $row['price']; ?>₹</p>
                                <p class="posted">Posted: <?php
                                    $days = floor((strtotime(date("Y-m-d H:i:s")) - strtotime($row['date'])) / (60 * 60 * 24));
                                    echo $days == 0 ? "Today" : "$days days ago";
                                ?></p>
                                <a href="/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>" class="btn">View Details</a>
                            </div>
                            <?php
                        }
                    }
                }
                if ($check == 0) {
                    ?>
                    <div class="center-text">
                        <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Books" loading="lazy">
                        <p>No books available currently</p>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
            $locality = [
                "kottayam" => ["aalapuzha", "idukki", "ernakulam", "pathanamthitta"],
                "idukki" => ["pathanamthitta", "kottayam", "ernakulam"],
                "aalapuzha" => ["kottayam", "ernakulam", "kollam", "pathanamthitta"],
                "thrissur" => ["palakkad", "ernakulam", "malappuram"],
                "palakkad" => ["thrissur", "malappuram"],
                "kasaragod" => ["kannur"],
                "kannur" => ["wayanad", "kasaragod", "kozhikode"],
                "malappuram" => ["wayanad", "thrissur", "kozhikode", "palakkad"],
                "wayanad" => ["kannur", "malappuram", "kozhikode"],
                "kozhikode" => ["wayanad", "malappuram", "kannur"],
                "ernakulam" => ["aalapuzha", "kottayam", "idukki", "thrissur", "palakkad"],
                "pathanamthitta" => ["aalapuzha", "kottayam", "idukki", "kollam"],
                "kollam" => ["aalapuzha", "pathanamthitta", "thiruvananthapuram"],
                "thiruvananthapuram" => ["kollam"]
            ];
            $nearbyLocations = $locality[strtolower($location)] ?? [];
            foreach ($nearbyLocations as $nearbyLoc) {
                $count = 0;
                $users = [];
                $query1 = "SELECT * FROM tbl_products WHERE userid != '$uid' AND archive=0 AND avstatus=1";
                $result1 = $connection->query($query1);
                while ($row1 = $result1->fetch_assoc()) {
                    $query = "SELECT * FROM tbl_users WHERE id != '$uid'";
                    $result = $connection->query($query);
                    while ($row = $result->fetch_assoc()) {
                        if ($row['id'] == $row1['userid'] && (stripos(strtolower($row['location']), $nearbyLoc) !== false || stripos($nearbyLoc, strtolower($row['location'])) !== false)) {
                            $count++;
                            if (!in_array($row['id'], $users)) {
                                $users[] = $row['id'];
                            }
                        }
                    }
                }
                if ($count > 0) {
                    ?>
                    <div class="top-bar">
                        <p>Showing results for <strong><?php echo ucfirst($nearbyLoc); ?></strong></p>
                    </div>
                    <div class="book-grid">
                        <?php
                        $check = 0;
                        foreach ($users as $userId) {
                            $query = "SELECT * FROM tbl_products WHERE userid = '$userId' AND userid != '$uid' AND archive=0 AND avstatus=1 AND price > $minprice AND price <= $maxprice";
                            $result = $connection->query($query);
                            while ($row = $result->fetch_assoc()) {
                                $query2 = "SELECT * FROM tbl_productimage WHERE productid = '{$row['productid']}' LIMIT 1";
                                $result2 = $connection->query($query2);
                                if ($result2->num_rows > 0 && $row['appstatus'] == 1) {
                                    $row2 = $result2->fetch_assoc();
                                    $check = 1;
                                    ?>
                                    <div class="profile-container" onclick="window.location.href='/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>'">
                                        <img src="data:image/jpeg;base64,<?php echo base64_encode($row2['image']); ?>" alt="<?php echo $row['title']; ?>"/>
                                        <p class="title"><?php echo $row['title']; ?></p>
                                        <p class="price"><?php echo $row['price']; ?>₹</p>
                                        <p class="posted">Posted: <?php
                                            $days = floor((strtotime(date("Y-m-d H:i:s")) - strtotime($row['date'])) / (60 * 60 * 24));
                                            echo $days == 0 ? "Today" : "$days days ago";
                                        ?></p>
                                        <a href="/miniproject/user/products/productdetails/productdetails.php?product_id=<?php echo $row['productid']; ?>&user-id=<?php echo $row['userid']; ?>" class="btn">View Details</a>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        if ($check == 0) {
                            ?>
                            <div class="center-text">
                                <img src="/miniproject/user/userchat/nomsg/text-phone.gif" alt="No Books" loading="lazy">
                                <p>No books available currently</p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </main>
    </div>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/user/welcomepage/footer/footer.php'; ?>
</body>
</html>