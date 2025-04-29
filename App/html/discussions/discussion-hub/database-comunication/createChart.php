<?php

require '../../../../Connections/Discussion-ConnectionInfo.php';

$postID = $_POST['postID'];
$firstUserID = $_POST['thisUserID'];

$sql = "INSERT INTO discussion_charts (Post_ID, First_User_ID) VALUE (?, ?)";

$stmt = mysqli_stmt_init($conn);
	
if (!mysqli_stmt_prepare($stmt, $sql))
{
	echo "Could NOT create a new conversation";
	exit();
}

else
{
	mysqli_stmt_bind_param($stmt, "ii", $postID, $firstUserID);
	mysqli_stmt_execute($stmt);

	echo "Conversation created suuuuper";
		
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	exit();
	
}


