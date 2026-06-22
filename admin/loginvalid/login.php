
<?php
session_start();

    $f=1;
    $flag=1;
    $admin=0;
    $user=0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/commonconnect.php';

echo "Connected successfully<br>";


    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = "SELECT * FROM tbl_logininfo";
    $result = $connection->query($stmt);
    if ($result && $result->num_rows > 0) {
        while($row= $result->fetch_assoc())
        {
           if($username==$row['username']&&$password==$row['password']){
            $f=0;
                $query="select role from tbl_users where username='$username'";
                $resultx=$connection->query($query);
                if($resultx->num_rows>0)
                {
                    $row1 = $resultx->fetch_assoc();
                    if($row1['role']==1)
                    {
                   
                $_SESSION['adminid']=1;
                $admin=1;
                    }
                    else
                {
                    $_SESSION['id']=$row['userid'];
                    $user=1;
                }
                }
                
                break;
           }          
            }
        }
        if($f==0)
        {
            $connection->close();
            
            if($admin==1)
            {
                header("location: /miniproject/admin/adminpage/adminhome.php");
                exit();
            }
            else if($user==1){
            $_SESSION['username']=$username;
            header("location: /miniproject/user/welcomepage/homepage.php");
            
            exit();
            }
            
        }
        else{ 
            $stmt = "SELECT * FROM tbl_logininfo";
            $result = $connection->query($stmt);
            if ($result && $result->num_rows > 0) {
                while($row= $result->fetch_assoc())
                {
                   if($username==$row['username']){
                    if($password!=$row['password']){
                        $flag=2;
                        break;
                    }
                   }       
                    }
                }
            $connection->close();

            header("Location: /miniproject/user/login/login.php?flag=$flag&username=" . urlencode($username) . "&password=" . urlencode($password));
            exit();
            
        }
    }
  
?>
