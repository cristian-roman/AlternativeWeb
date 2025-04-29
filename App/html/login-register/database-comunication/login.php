<!DOCTYPE html>
<html>
<?php

if(isset($_POST["submit"]))
{ 
    require_once '../../../Connections/User-ConnectionInfo.php';
    require_once 'login-functions.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['username'];

    if(EmptyInputLogin($username, $password)!==false)
    {
        header("location:../index.php?error=emptyInput"); 
        exit();
    }
    $userID = UserExists($conn, $username, $password);
    if($userID == false)
    {
        header("location:../index.php?error=NotExistsingUser");     
        exit();
    }
?>
        <form method="post" id="GoToDiscussions" action="../../discussions/index.php?Successful-Login&<?php echo$username;?>">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
        </form>
        <script src="../../../scripts/login-scripts.js"></script>  
    </html>
<?php
}
else
{
    header("location:../index.php");
    exit(); 
}
?>