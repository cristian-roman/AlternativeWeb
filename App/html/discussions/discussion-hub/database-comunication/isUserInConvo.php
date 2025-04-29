<?php
    require '../../../../Connections/Discussion-ConnectionInfo.php';

    $chartID = $_POST['lastChartID'];
    $userID = $_POST['thisUserID'];

    $sql = "SELECT * FROM discussion_charts WHERE (UID='$chartID' AND (First_User_ID='$userID' OR Second_User_ID='$userID' OR Third_User_ID='$userID'))";

    $stmt = mysqli_stmt_init($conn);
        
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "Can NOT establish connection";
        exit();
    }

    else
    {
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt); 
        $row = mysqli_fetch_assoc($result);

        if($row!=null)
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }
?>