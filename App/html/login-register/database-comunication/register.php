<?php

if(isset($_POST["submit"]))
{ 
    require_once '../../../Connections/User-ConnectionInfo.php';
    require_once 'register-functions.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $repeatedPassword = $_POST['repeatedPassword'];
    $email = $_POST['email'];

    if(EmptyInputSignup($username, $password, $repeatedPassword, $email)!==false)
    {
        header("location:../index.php?error=emptyInput"); 
        exit();
    }
    if(InvalidUsername($username)!==false)
    {
        header("location:../index.php?error=invalidUsername"); 
        exit();
    }
    if(InvalidEmail($email)!==false)
    {
        header("location:../index.php?error=invalidEmail"); 
        exit();
    }
    
    if($a=PasswordMatch($password, $repeatedPassword) !== true)
    {
        header("location:../index.php?error=differentPasswords");
        exit();
    }
    if(UsernameExists($conn, $username) !== false)
    {
        header("location:../index.php?error=usernameAlreadyInUse");     
        exit();
    }
    if(EmailExists($conn, $email) !== false)
    {
        header("location:../index.php?error=usernameAlreadyInUse");     
        exit();
    }
    
    createUser($conn, $username, $email, $password);
}
else
{
    header("location:../index.php");
    exit(); 
}