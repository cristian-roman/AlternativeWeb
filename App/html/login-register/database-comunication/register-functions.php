<?php

function createUser($conn, $username, $email, $password)
{
    $sql = "INSERT INTO authentication (Username, Password, Email) VALUE (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }
    else
    {
        /*$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $password = $hashedPassword;*/
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);
        mysqli_stmt_execute($stmt);

        $sql = "SELECT * FROM authentication WHERE (Username='$username')";
        if (mysqli_stmt_prepare($stmt, $sql))
        {
            mysqli_stmt_execute($stmt);
            
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            
            $user_ID = $row['User_ID'];

            $sql = "INSERT INTO discussion_details (User_ID) VALUE (?)";
            if (mysqli_stmt_prepare($stmt, $sql))
            {
                mysqli_stmt_bind_param($stmt, "i", $user_ID);
                mysqli_stmt_execute($stmt);
        
                $sql = "INSERT INTO events_details (User_ID) VALUE (?)";
                if(mysqli_stmt_prepare($stmt, $sql))
                {
                    mysqli_stmt_bind_param($stmt, "i", $user_ID);
                    mysqli_stmt_execute($stmt);

                        $sql = "INSERT INTO job_details (User_ID) VALUE (?)";
                        if(mysqli_stmt_prepare($stmt, $sql))
                        {
                            mysqli_stmt_bind_param($stmt, "i", $user_ID);
                            mysqli_stmt_execute($stmt);
                            
                            $sql = "INSERT INTO personal_details (User_ID, Username, Email) VALUE (?, ?, ?)";
                            if(mysqli_stmt_prepare($stmt, $sql))
                            {
                                mysqli_stmt_bind_param($stmt, "iss", $user_ID, $username, $email);
                                mysqli_stmt_execute($stmt);
                                
                                require 'A:\Xampp\htdocs\Alternative(2.0)\images\ConnectionInfo.php';
                                $stmt = mysqli_stmt_init($conn);
                                
                                $sql = "INSERT INTO user_profile (User_ID) VALUE (?)";
                                if(mysqli_stmt_prepare($stmt, $sql))
                                {
                                    mysqli_stmt_bind_param($stmt, "i", $user_ID);
                                    mysqli_stmt_execute($stmt);
                                    
                                    $sql = "INSERT INTO user_background (User_ID) VALUE (?)";
                                    if(mysqli_stmt_prepare($stmt, $sql))
                                    {
                                        mysqli_stmt_bind_param($stmt, "i", $user_ID);
                                        mysqli_stmt_execute($stmt);
                                        
                                        header("location: ../index.php?#SUCCESSFUL_SIGN_UP");
                                    }
                                    else
                                    {
                                        header("location: ../index.php?error=stmtFailed");
                                        exit();
                                    }
                                }
                                else
                                {
                                    header("location: ../index.php?error=stmtFailed");
                                    exit(); /// nu a mers a doua conexiune
                                }
                            }
                            else
                            {
                                header("location: ../index.php?error=stmtFailed");
                                exit();
                            }
                        }
                        else
                        {
                            header("location: ../index.php?error=stmtFailed");
                            exit();
                        }
                }
                else
                {
                    header("location: ../index.php?error=stmtFailed");
                    exit();
                }
            }
            else
            {
                header("location: ../index.php?error=stmtFailedAtInsertingInDiscussions");
                exit();
            }
        }
        else
        {
            header("location: ../index.php?error=stmtFailedAtSelectingUser");
            exit();
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }
}

function EmptyInputSignup($username, $password, $repeatedPassword, $email)
{
    $result;
    if(empty($username) || empty($password) || empty($repeatedPassword) || empty($email))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }

    return $result;
}

function InvalidUsername($username)
{
    /*$result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return result;*/

    return false;
}

function InvalidEmail($email)
{
    $result;
    if(!filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }

    return $result;
}

function PasswordMatch($password, $repeatedPassword)
{
    $result;
    if(strcmp($password,$repeatedPassword)==0)
    {
        $result = true;
    }
    else
    {
        $result = false;
    }

    return $result;
}

function UsernameExists($conn, $username)
{
    $tabel = "authentication";
    $sql = "SELECT User_ID FROM $tabel WHERE Username = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($resultData))
        {
            return $row;
        }
        else
        {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}

function EmailExists($conn, $email)
{
    $tabel = "authentication";
    $sql = "SELECT User_ID FROM $tabel WHERE Email = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../index.php?error=stmtFailed");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        $resultData = mysqli_stmt_get_result($stmt);
        
        if($row = mysqli_fetch_assoc($resultData))
        {
            return $row;
        }
        else
        {
            $result = false;
            return $result;
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}