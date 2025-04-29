<link rel="stylesheet" href="../../../css/discussion-hub.css"/>
<?php
if(!empty($_POST["lastChartID"]))
{
    
    require "../../../Connections/Discussion-ConnectionInfo.php";
    $lastChartID = $_POST["lastChartID"];
    $postID = $_POST["postID"];
    $thisUserID =  $_POST["thisUserID"];
    $thisUserUsername = $_POST["thisUserUsername"]; 
    $showLimit = 3;

    $tabel = "discussion_charts";         
    $sql = "SELECT * FROM $tabel WHERE ( Post_ID = '$postID' AND UID < ".$lastChartID.") ORDER BY UID DESC LIMIT ".$showLimit;
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql))
    {
        header("../../login-register/index.php?false-Error-when-trying-to-connect-to-server");
        exit();
    }
    else
    {
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt); 
        $row = mysqli_fetch_assoc($result);
        if($row!=NULL)
        {
            $firstChartID = $row['UID'];
            while($row!=null)
            {
                require "../../../Connections/Discussion-ConnectionInfo.php";
                $chartID = $row['UID'];
                $membersCounter = $row['Members_Counter'];
                $firstUserID = $row['First_User_ID'];
                $secondUserID = $row['Second_User_ID'];
                $thirdUserID = $row['Third_User_ID'];
                $votes = $row['Votes'];

?>
    <div class="listed-chart">
        <div class="first-line columns">
            <div class="first-user-image image">
                <img src="../../../images/Profile.png" alt="user_photo"></img>
            </div>
            <div class="second-image image">
<?php
                if($secondUserID!=0)
                {
?>
                <img src="../../../images/Profile.png" alt="user_photo"></img>
<?php
                }
                else
                {
?>
                <img src="../../../images/Unlocked.png" alt="user_photo"></img>
<?php
                }               
?>
            </div>
        </div>
        <div class="second-line columns">
            <div class="half image">
<?php
                if($thirdUserID!=0)
                {
?>
                    <img src="../../../images/Profile.png" alt="user_photo"/>
<?php
                }
                else
                {
?>
                    <img src="../../../images/Unlocked.png" alt="user_photo"/>
<?php
                }               
?>
            </div>
            <div class="half loadConvoButton">
                    <button id="<?php echo $chartID;?>" 
                            postID="<?php echo $postID;?>" 
                            membersCounter="<?php echo $membersCounter;?>" 
                            thisUserID = "<?php echo $thisUserID;?>"
                            firstUserID = "<?php echo $firstUserID;?>"
                            secondUserID = "<?php echo $secondUserID;?>"
                            thirdUserID = "<?php echo $thirdUserID;?>"
                            thisUserUsername = "<?php echo $thisUserUsername;?>"
                            onclick="LoadConvo(this.id)"> → </button>
                    <script src="../../../scripts/discussion-hub-scripts.js"></script>
            </div>
            </div> 
    </div>
<?php 
                $row = mysqli_fetch_assoc($result);
            }
            if($chartID>0)
            {
?>
                <div class="loading" lastChartID="<?php echo $chartID;?>" 
                                     postID="<?php echo $postID;?>"
                                     thisUserID = "<?php echo $thisUserID;?>"
                                     thisUserUsername = "<?php echo $thisUserUsername;?>" 
                                     style="disply:none;" >
                    <img src="../../../images/loading.gif"/>
                </div>
<?php
            }
            else
            {
?>
            <div class="loading" lastChartID="0" 
                                 postID="<?php echo $postID;?>"
                                 thisUserID = "<?php echo $thisUserID;?>"
                                 thisUserUsername = "<?php echo $thisUserUsername;?>" 
                                 >
                <p>No more charts. Come later for more or create one by yourself!</p>
            </div>
<?php
        }
    }
            else
            {
?>
            <div class="loading" lastChartID="0" 
                                 postID="<?php echo $postID;?>"
                                 thisUserID = "<?php echo $thisUserID;?>"
                                 thisUserUsername = "<?php echo $thisUserUsername;?>" 
                                 >
                <p>No more charts. Come later for more or create one by yourself!</p>
            </div>
<?php
            }
        }
    }
?> 
    