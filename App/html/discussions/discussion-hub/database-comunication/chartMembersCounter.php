<?php
    require '../../../../Connections/Discussion-ConnectionInfo.php';

    $chartID = $_POST['lastChartID'];

    $sql = "SELECT * FROM discussion_charts WHERE (UID='$chartID')";

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
            echo $row["Members_Counter"];
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