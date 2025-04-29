<?php
    require '../../../../Connections/Discussion-ConnectionInfo.php';

    $userID = $_POST['thisUserID'];
    $postID = $_POST['postID'];

    $sql = "SELECT * FROM discussion_charts WHERE First_User_ID='$userID' AND Post_ID='$postID'";

    $stmt = mysqli_stmt_init($conn);
        
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "-1";
        exit();
    }

    else
    {
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt); 
        $row = mysqli_fetch_assoc($result);

        if($row!=null)
        {
            echo $row['UID']; ///chart_UID
        }
        else
        {
            echo "-1";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }
?>