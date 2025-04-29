<link rel="stylesheet" href="../../../css/discussion-hub.css"/>
<?php
if(!empty($_POST["chartID"]))
{
    $chartID = $_POST["chartID"];
    $lastMessageID = $_POST["lastMessageID"];

    require "../../../Connections/Discussion-ConnectionInfo.php";

    $showLimit = 5;
    $tabel = "chart_messages";
    $sql = "SELECT * FROM $tabel WHERE ( Chart_ID = '$chartID' AND UID >'$lastMessageID') ORDER BY UID LIMIT ".$showLimit;;
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("../index.php?false-Error-when-trying-to-connect-to-server");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); 
        $row = mysqli_fetch_assoc($result);
        $messagesCounter = 0;
        if($row!=NULL)
        {
            while($row!=null)
            {
                $messagesCounter++;
                $messageUID = $row['UID'];
                $messageUserID = $row['User_ID'];
                $messageUserUsername = $row['Username'];
                $messageUserName = $row['Name'];
                $messageText = $row['Message'];

?>

    <div class="listed-message">
        <div class="columns">
            <div class="half">
<?php
                if((($messageUserID%3) + $chartID)%2 ==1)
                {
?>
                <div class="message">
                    <div class="profilePicture-username columns" style="justify-content:left;">
                        <div class="profilePicture">
                            <a href="#">
                                <img src="../../../images/Profile.png" alt="user_photo"/>
                            </a>
                        </div>
                        <div class="username">
                            <h4 style="text-align:left;"><?php echo $messageUserUsername ?></h4>
                        </div>
                    </div>
                    <div class="message-text">
                        <p style="font-size:0.9rem; font-weight:bold;"> Message: </p>
                        <p> <?php echo $messageText ?> </p>
                    </div>
                </div>
<?php
                }
                else
                {
?>
                <div class="message empty">
                    <p style="visibility:hidden;"> Hidden content </p>
                </div>
<?php
                }
?>
            </div>
            <div class="half">
<?php
                if((($messageUserID%3) + $chartID)%2==0)
                {
?>
                <div class="message">
                    <div class="profilePicture-username columns" style="justify-content:right;">
                        <div class="username">
                            <h4><?php echo $messageUserUsername ?></h4>
                        </div>
                        <div class="profilePicture">
                            <a href="#">
                                <img src="../../../images/Profile.png" alt="user_photo"/>
                            </a>
                        </div>
                    </div>
                    <div class="message-text">
                        <p style="font-size:0.75rem; font-weight:bold;"> Message: </p>
                        <p> <?php echo $messageText ?> </p>
                    </div>
                </div>
<?php
                }
                else
                {
?>
            <div class="message empty"> 
                <p style="visibility:hidden;"> Hidden content </p>
            </div>
<?php
                }
?>
            </div>
        </div>
    </div>
    
<?php 
                $row = mysqli_fetch_assoc($result);
            }       
        }
    
?>
<?php       if($messagesCounter >= 5)
            {
?>

    <div class="loading"lastMessageID="<?php echo $messageUID; ?>" 
                        messagesCounter="<?php echo $messagesCounter;?>"
                        chartID = "<?php echo $chartID;?>"
                        style="display:none;" >
    </div>

<?php
            }
            else
            {
?>
    <div class="loading"lastMessageID="10000" 
                        messagesCounter="0"
                        style="display:none;" >
    </div>
<?php
            }
        }
    }
?>