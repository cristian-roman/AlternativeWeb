<?php

function EmptyInputLogin($username, $password)
{
    $result;
    if(empty($username) || empty($password))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }

    return $result;
}

function UserExists($conn, $username, $password)
{
    $tabel = "authentication";
    $sql = "SELECT User_ID FROM $tabel WHERE (Username = ? OR Email = ?) AND Password = ? ";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        header("location: ../index.php?error=loginIdentificationFailed");
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($stmt, "sss", $username, $username, $password);
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