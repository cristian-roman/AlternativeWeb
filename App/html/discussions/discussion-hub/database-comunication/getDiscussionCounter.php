<?php

error_reporting(0);
require '../../../../Connections/Discussion-ConnectionInfo.php';

$tabel = "post_extradata";
$column = "Discussions";
$unique_identifier = "UID";
$unique_identfier_value = $_POST['lastPostID'];
	
$sql = "SELECT $column FROM $tabel WHERE ($unique_identifier='$unique_identfier_value')";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql))
{
	echo "false Error when trying to connect to server";
	exit();
}
else
{
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);

	if ($row!=NULL)
	{
		echo $row["$column"];
	}

	else
	{
		echo "-1";
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
