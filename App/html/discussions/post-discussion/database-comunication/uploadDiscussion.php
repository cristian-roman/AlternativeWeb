<?php
error_reporting(0);
require '../../../../Connections/Discussion-ConnectionInfo.php';

$title = $_POST['postTile'];
$content = $_POST['postText'];
$userID = $_POST['thisUserID'];
$username = $_POST['thisUserUsername'];
$img = $_FILES['postImages'];

$photosCounter = 0;
$count=0; 
$name="";
$allowed = array('jpg', 'jpeg', 'png');

foreach ($_FILES['postImages']['name'] as $listFile) 
{
    $photosCounter = $photosCounter+1;
    $name = $listFile;
}

if($photosCounter == 1)
{
    $fileExtension = strtolower(end(explode('.', $name)));
    if(!in_array($fileExtension, $allowed))
    {
        $photosCounter = 0;
    }
}

$timeStamp = hashUsername($username);

$sql = "INSERT INTO post_details (TimeStamp, Title, Content, Photos_Counter) VALUE (?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);
	
if (!mysqli_stmt_prepare($stmt, $sql))
{
    echo "Post failed";
	exit();
}

else
{
	mysqli_stmt_bind_param($stmt, "sssi", $timeStamp, $title, $content, $photosCounter);
	mysqli_stmt_execute($stmt);
	
	$sql = "INSERT INTO post_extradata (TimeStamp, User_ID, Username, Fullname) VALUE (?, ?, ?, ' ')";

	$stmt = mysqli_stmt_init($conn);
	
	if (!mysqli_stmt_prepare($stmt, $sql))
	{
		echo "Post failed";
		exit();
	}
	else
	{
		mysqli_stmt_bind_param($stmt, "sss", $timeStamp, $userID, $username);
		mysqli_stmt_execute($stmt);
		
        foreach ($_FILES['postImages']['name'] as $listFile) 
        {
            $fileName = "Discussion_".$timeStamp;
            $source = $fileName;
            $fileName = $fileName."_".$count.".jpg";
            $fileError = $_FILES['postImages']['error'][$count];
            $fileTmpName = $_FILES['postImages']['tmp_name'][$count];
            $fileSize = $_FILES['postImages']['size'][$count];

            $fileExtension = strtolower(end(explode('.', $fileName)));
           
            $savingName = $fileName.hash("md2", $fileName.$source.$timeStamp);
            $table = "discussion";

            if (in_array($fileExtension, $allowed))
            {
                if($fileError === 0)
                {
                    if($fileSize < 5000000)
                    {	
                        $fileNewName = $savingName.'.'.$fileExtension;
                        
                        $directory = "A:/Xampp/htdocs/Alternative(2.0)/discussions/DiscussionImages/$source";
                        if(!is_dir($directory))
                        {
                            mkdir("$directory/");
                        }
                        
                        $fileDestination = "$directory/$fileNewName";
                        move_uploaded_file($fileTmpName, $fileDestination);
                        
                        require 'A:\Xampp\htdocs\Alternative(2.0)\discussions\ConnectionInfo.php';
                        $sql = "SELECT UID FROM post_extradata WHERE (TimeStamp='$timeStamp' AND User_ID='$userID')";
                        $stmt = mysqli_stmt_init($conn);

                        if (mysqli_stmt_prepare($stmt, $sql))
                        {
                            mysqli_stmt_execute($stmt);
                            
                            $result = mysqli_stmt_get_result($stmt);
                            $row = mysqli_fetch_assoc($result);

                            $uid = $row['UID'];
                            
                            require 'A:\Xampp\htdocs\Alternative(2.0)\images\ConnectionInfo.php';
                            $sql = "INSERT INTO $table (Discussion_ID, User_ID, Source, Name, Extension) VALUES (?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            
                            if (mysqli_stmt_prepare($stmt, $sql))
                            {
                                $savedDestination = "discussions/"."DiscussionImages/$source/$fileNewName";
                                mysqli_stmt_bind_param($stmt, "iisss", $uid, $userID, $savedDestination, $savingName, $fileExtension);
                                mysqli_stmt_execute($stmt);
                            }
                            
                            else
                            {
                                echo "false";
                            }
                        }
                        else
                        {
                            echo "false";
                        }
                    }
                    else
                    {
                        echo "false";
                    }
                }
                
                else
                {
                    echo "false"; 
                }
            }

            $count =  $count+1;
        }

		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	}
}

function numHash($str, $len=null)
{
    $binhash = md5($str, true);
    $numhash = unpack('N2', $binhash);
    $hash = $numhash[1] . $numhash[2];
    if($len && is_int($len)) {
        $hash = substr($hash, 0, $len);
    }
     
    return $hash;
}

function hashUsername($username)
{
    $usernameHashCode = ((numHash($username,20) + 8951) % 10000) * 9973 + 76329576;

    $timeHashCode = ((numHash(time(), 20) % rand(2, 485803)) * 9973) + 6397;
    if ($timeHashCode < 0)
    {
        $timeHashCode *= -1;
    } 

    $hashCode = ($usernameHashCode % rand(2, 7630841) + 38457) + ($timeHashCode * rand(17, 5927));
    if ($hashCode < 0) 
    {
        $hashCode *= -1;
    }

    return $hashCode;
}

?>
        <form method="post" action="http://localhost/AlternativeWebSite(1.0)/html/discussions/index.php" id="myForm">
            <input type="hidden" name="username" value=<?php echo $username;?>/>
        </form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
    alert("succesful post!");
</script>


