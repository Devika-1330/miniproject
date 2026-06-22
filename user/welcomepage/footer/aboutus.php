
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/header/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us - ReRead</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #3a3a3a;
            margin: 0;
            padding: 0;
        }
        .about-us {
            background-color: #f5f5f5;
            color: #3a3a3a;
            padding: 40px;
            text-align: center;
            margin: 30px 20px; /* Adds space on both ends */
            max-width: 900px; /* Limits content width */
            margin-left: auto;
            margin-right: auto; /* Centers the content */
        }
        .about-us h2 {
            color: #6a4c9c; /* Violet color */
            margin-bottom: 20px;
        }
        .about-us p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .logoabt img{
            width:200px;
        }
    </style>
</head>
<body>

    <div class="about-us">
    <div class="logoabt"><img src="/miniproject/user/welcomepage/header/logorr.png"></div>
        <h2>About Us</h2>
        <p>At ReRead, our mission is simple: to connect book lovers by providing a space to exchange books. We believe books have the power to change lives, and we're dedicated to making sure they have a second (and third) chance to do so!</p>

        <p>ReRead is a community-driven platform that lets you trade books with others. Whether you're an avid reader looking to share your latest find, or you're searching for your next literary adventure, ReRead helps you pass on the stories that matter.</p>

        <p>Join our growing community today and start exchanging your books for something new. Let's make reading more sustainable, accessible, and enjoyable for everyone!</p>
    </div>

</body>
</html>

<?php
include $_SERVER['DOCUMENT_ROOT'] .'/miniproject/user/welcomepage/footer/footer.php';
?>