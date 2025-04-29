<?php

error_reporting(0);
require '../../../../Connections/Discussion-ConnectionInfo.php';

$tabel = "post_extradata";
$unique_identifier = "UID";

$uid = $_POST['lastPostID'];
$column = $_POST['column'];
$newValue = $_POST['newValue'];

$sql = "UPDATE $tabel SET $column=$newValue WHERE ($unique_identifier='$uid')";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql))
{
	echo "false";
	exit();
}
else
{
	mysqli_stmt_execute($stmt);

	echo "true";

	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
