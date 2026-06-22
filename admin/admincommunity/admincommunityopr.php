<?php
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

if(isset($_GET['banusr']))
{
    $uid=$_GET['banusr'];
    $query="update tbl_community set status=1 where userid = '$uid'";
    $result=$connection->query($query);

    $query="delete from tbl_community_msgs where userid = '$uid'";
    $result=$connection->query($query);
    if($result)
    {
        header("location: /miniproject/admin/admincommunity/admincommunity.php");
        exit();
    }
}

if(isset($_GET['remmsg']))
{
    $mid=$_GET['remmsg'];
    

    $query="delete from tbl_community_msgs where msgid = '$mid'";
    $result=$connection->query($query);
    if($result)
    {
        header("location: /miniproject/admin/admincommunity/admincommunity.php");
        exit();
    }
}
if(isset($_GET['delrep']))
{
    $rid=$_GET['delrep'];
    

    $query="delete from tbl_reports where repid = '$rid'";
    $result=$connection->query($query);
    if($result)
    {
        header("location: /miniproject/admin/admincommunity/admincommunity.php");
        exit();
    }
}
?>