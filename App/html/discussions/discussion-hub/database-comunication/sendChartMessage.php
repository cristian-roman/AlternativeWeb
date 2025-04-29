<?php
    require '../../../../Connections/Discussion-ConnectionInfo.php';

    $chartID = $_POST['chartID'];
    $postID = $_POST['lastPostID'];
    $userID = $_POST['thisUserID'];
    $username = $_POST['thisUserUsername'];
    $name = "";
    $message = $_POST['message'];

    $sql = "INSERT INTO chart_messages (Chart_ID, Post_ID, User_ID, Username, Name, Message) VALUE (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
        
    if (!mysqli_stmt_prepare($stmt, $sql))
    {
        echo "Message was NOT sent";
        exit();
    }

    else
    {
        mysqli_stmt_bind_param($stmt, "iiisss", $chartID, $postID, $userID, $username, $name, $message);
        mysqli_stmt_execute($stmt);
        
        echo "Message sent successfully!";

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }
?>