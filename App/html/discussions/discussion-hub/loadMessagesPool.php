<link rel="stylesheet" href="../../../css/discussion-hub.css"/>
<div class="wrapper" id="wrapper">
<?php
if(!empty($_GET["chartID"]))
{
    $chartID = $_GET["chartID"];
    require "../../../Connections/Discussion-ConnectionInfo.php";

    $tabel = "chart_messages";
    $sql = "SELECT * FROM $tabel WHERE ( Chart_ID = ".$chartID.")  ORDER BY UID LIMIT 5";
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
    }
}
    
?>
    <div class="loading"    lastMessageID="<?php echo $messageUID; ?>" 
                            messagesCounter="<?php echo $messagesCounter;?>"
                            chartID = "<?php echo $chartID;?>"
                            style="display:none;" >
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        var isRunning = false;
                $(document).ready(function(){
                $('.wrapper').scroll(function(){
                    var lastMessageID = $('.loading').attr('lastMessageID');
                    var messagesCounter = $('.loading').attr('messagesCounter');
                    var chartID = $('.loading').attr('chartID');

                    if(($(window).scrollTop() == $(document).height() - $(window).height()) && (messagesCounter >= 5) && (isRunning==false)){
                            $.ajax({
                            type:'POST',
                            url:'getMoreMessages.php',
                            data:
                            {
                                lastMessageID: lastMessageID,
                                chartID: chartID
                            },
                            beforeSend:function(){
                                isRunning=true;
                                $('.loading').show();
                            },
                            success:function(html){
                            
                                $('.loading').remove();
                                $('#wrapper').append(html);
                                isRunning = false;
                            }
                        });
                    }
            });
            });
                
    </script>
</div>