<?php
        $beginning = "https://192.168.1.19/";
        $base = $beginning."Alternative(2.0)/";

        $thisUserID = $_POST['thisUserID'];
        $thisUserUsername = $_POST['thisUserUsername'];
        $thisUserEmail = $_POST['thisUserEmail'];
        $thisUserFirstname = $_POST['thisUserFirstname'];
        $thisUserLastname = $_POST['thisUserLastname'];

        $postID = $_POST['postID'];
        $postOwnerID = $_POST['postOwnerID'];
        $postOwnerUsername = $_POST['postOwnerUsername'];
        $postOwnerFullname = $_POST['postOwnerFullname']; 
        $postTitle=$_POST['postTitle'];
        $postContent=$_POST['postContent'];
        $photosCounter=$_POST['photosCounter'];

        require "../../../Connections/Image-ConnectionInfo.php";
        $tabel = "discussion";
        $unique_identifier = "Discussion_ID";
        $unique_identfier_value = $postID;

        $sql = "SELECT * FROM $tabel WHERE ($unique_identifier='$unique_identfier_value')";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql))
        {
            header("../../../login-register/index.php?false-Error-when-trying-to-connect-to-server");
            exit();
        }
        else
        {
            mysqli_stmt_execute($stmt);
            $allImageLinks = mysqli_stmt_get_result($stmt);

    include_once 'header.php';
?>
<link rel="stylesheet" href="../../../css/discussion-hub.css"/>
<body>
<div class="container">
    <div class="header columns">
        <div class="title">
            <h1> Alternative </h1>  
        </div>
        <div class="pages">
            <div id="posts">
                <a href="#">
                    <img src="../../../images/posts-page.png" alt="Posts">
                </a>
            </div>
            <div id="discussions">
                <a href="#">
                    <img src="../../../images/selected-discussions-page.png" alt="Discussions">
                </a>
            </div>
            <div id="companies">
                <a href="#">
                    <img src="../../../images/companies-page.png" alt="Companies">
                </a>
            </div>
        </div>
        <div class="user-section">
            <a href="#">
                <img src="../../../images/Profile.png" alt="user_photo"></img>
            </a>
            <h4><?php echo $thisUserUsername ?></h4>
        </div>
    </div>
    <div class="mid-screen columns">
        <div class="left-space"></div>
        <div class="main">
            <div class="post">
                <div class="discussion-header">
                    <img src="../../../images/Profile.png" alt="profile_picture"></img>
                    <h4><?php echo $postOwnerUsername;?> <!--<br><span>·Date format zz mth hh::ss</span>--></h4>
                    <h4 id="discussion-title"> <?php echo $postTitle;?> </h4>
                </div>
<?php
        if($photosCounter==0)
        {
?>
                <div class="NoPhotosSection">
                    <p><?php echo $postContent; ?></p>
                </div>
<?php
        }
        else if($photosCounter==1)
        {
            $link = mysqli_fetch_assoc($allImageLinks);
            $photoLink = $base.$link['Source'];
?>
<!-- One photo section -->
                <div class="text-section">
                    <p><?php echo $postContent; ?></p>
                </div>
                <div class="photosSection">
                    <div class="photo">
                        <img src="<?php echo $photoLink ?>"></img>
                    </div>
                </div>
<?php
        }
        else if($photosCounter==2)
        {
            $count=0;
            while($count<2)
            {
                $link = mysqli_fetch_assoc($allImageLinks);
                if($count==1)
                {
                    $firstPhotoLink = $base.$link['Source'];
                }
                else
                {
                    $secondPhotoLink = $base.$link['Source'];
                }
                $count=$count+1;
            }
?>
<!-- Two photos section -->
                <div class="text-section">
                    <p><?php echo $postContent; ?></p>
                </div>
                <div class="photosSection">
                    <div class="photo">
                        <img src="<?php echo $firstPhotoLink ?>"></img>
                    </div>
                    <div class="photo">
                        <img src="<?php echo $secondPhotoLink ?>"></img>
                    </div>
                </div>
<?php
                }
                else if($photosCounter==3)
                {
                    $count=0;
                    while($count<3)
                    {
                        $link = mysqli_fetch_assoc($allImageLinks);
                        if($count==1)
                        {
                            $firstPhotoLink = $base.$link['Source'];
                        }
                        else if($count==2)
                        {
                            $secondPhotoLink = $base.$link['Source'];
                        }
                        else
                        {
                            $thirdPhotoLink = $base.$link['Source'];
                        }
                        $count=$count+1;
                    }
?>
<!-- Three photo section -->
                <div class="text-section">
                    <p><?php echo $postContent; ?></p>
                </div>
                <div class="photosSection columns">
                    <div class="half photo" id="first-photo">
                        <img src="<?php echo $firstPhotoLink ?>"></img>
                    </div>
                    <div class="half">
                        <div class="photo">
                            <img src="<?php echo $secondPhotoLink ?>"></img>
                        </div>
                        <div class="photo">
                            <img src="<?php echo $thirdPhotoLink ?>"></img>
                        </div>
                    </div>
                </div>
<?php
                }
                else if($photosCounter>=3)
                {
                    $count=0;
                    while($count<3)
                    {
                        $link = mysqli_fetch_assoc($allImageLinks);
                        if($count==1)
                        {
                            $firstPhotoLink = $base.$link['Source'];
                        }
                        else if($count==2)
                        {
                            $secondPhotoLink = $base.$link['Source'];
                        }
                        else
                        {
                            $thirdPhotoLink = $base.$link['Source'];
                        }
                        $count=$count+1;
                    }
?>
<!-- Multimple photo section -->
                <div class="text-section">
                    <p><?php echo $postContent; ?></p>
                </div>
                <div class="photosSection columns">
                    <div class="half photo" id="first-photo">
                        <img src="<?php echo $firstPhotoLink ?>"></img>
                        <input type="submit" value="More photos" id="seeAllPhotosButton"/>  
                    </div>
                    <div class="half">
                        <div class="photo">
                            <img src="<?php echo $secondPhotoLink ?>"></img>
                        </div>
                        <div class="photo">
                            <img src="<?php echo $thirdPhotoLink ?>"></img>
                        </div> 
                    </div>
                </div>
<?php
            }
        }
?>
            </div>
            <div class="charts-messages columns">
                <div class="charts" id="charts">
<?php
            require "../../../Connections/Discussion-ConnectionInfo.php";
            $tabel = "discussion_charts";
            $sql = "SELECT * FROM $tabel WHERE ( Post_ID = ".$postID.")  ORDER BY UID DESC LIMIT 5";
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
                if($row!=NULL)
                {
                    $firstChartID = $row['UID'];
                    while($row!=null)
                    {
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
                                <img src="../../../images/Profile.png" alt="user_photo"/>
                            </div>
                            <div class="second-image image">
<?php
                    if($secondUserID!=0)
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
            }
        }
?>
                    <div class="loading"lastChartID="<?php echo $chartID; ?>" 
                                        postID="<?php echo $postID;?>"  
                                        thisUserID = "<?php echo $thisUserID;?>"
                                        thisUserUsername = "<?php echo $thisUserUsername;?>"
                                        style="display:none;" >
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script type="text/javascript">
                            var chartProcessing = false;
                                $(document).ready(function(){
                                $('.charts').scroll(function(){
                                    var lastChartID = $('.loading').attr('lastChartID');
                                    var postID = $('.loading').attr('postID');
                                    var thisUserID = $('.loading').attr('thisUserID');
                                    var thisUserUsername = $('.loading').attr('thisUserUsername');
                                    if(($(window).scrollTop() >= $(window).height()*0.64) && (lastChartID > 0) && (chartProcessing==false)){
                                            $.ajax({
                                            type:'POST',
                                            url:'getMoreCharts.php',
                                            data:
                                            {
                                                lastChartID: lastChartID,
                                                postID: postID,
                                                thisUserUsername:thisUserUsername,
                                                thisUserID:thisUserID

                                            },
                                            beforeSend:function(){
                                                chartProcessing = true;
                                                $('.loading').show();
                                            },
                                            success:function(html){
                                                chartProcessing = false;
                                                $('.loading').remove();
                                                $('#charts').append(html);
                                            }
                                        });
                                    }
                                });
                                });
                    </script>
                </div>
                <div class="messages" id="messages">
                </div>    
            </div>
            <div class="input-bar columns">
                <div class="yourConvoButton">
                    <button type="button"   id="create-selectConvoButton" 
                                            thisUserID = "<?php echo $thisUserID;?>"
                                            thisUserUsername = "<?php echo $thisUserUsername;?>"  
                                            postID="<?php echo $postID;?>" 
                    onclick="SelectYourConvo()"> Your conversation </button>
                </div>
                <div class="input-message">
                    <input type="text"  id="toSendMessage" name="message" placeholder="Type your point of view...">
                    <button type="button" id="sendButton" onclick="SendMessage()" > Send </button>
                <script src="../../../scripts/discussion-hub-scripts.js"></script>
                </div>
            </div>
        </div>
        <div class="right-space"></div>
    </div>
    <div class="footer"></div>
</div>
</body>
</html>