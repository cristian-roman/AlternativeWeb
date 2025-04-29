<?php 
    $usernameOrEmail = $_POST['username'];
    $beginning = "https://localhost/";
    $base = $beginning."Alternative(2.0)/";
    include_once 'header.php';
    error_reporting(0);

?>
<link rel="stylesheet" href="../../css/discussions.css"/>
<body>
<!-- start of the container -->
<div class="container">
    <div class="header columns">
        <div class="title">
            <h1> Alternative </h1>  
        </div>
        <div class="pages">
            <div id="posts">
                <a href="#">
                  <img src="../../images/posts-page.png" alt="Posts">
                </a>
            </div>
            <div id="discussions">
                <a href="#">
                  <img src="../../images/selected-discussions-page.png" alt="Discussions">
                </a>
            </div>
            <div id="companies">
                <a href="#">
                  <img src="../../images/companies-page.png" alt="Companies">
                </a>
            </div>
        </div>
        <div class="user-section">
        <?php
            require "../../Connections/User-ConnectionInfo.php";     
            $sql = "SELECT * FROM personal_details WHERE (Username='$usernameOrEmail' OR Email='$usernameOrEmail')";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql))
            {
                header("../../login-register/index.php?false-Error-when-trying-to-connect-to-server");
                exit();
            }
            else
            {
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);

                $thisUserID = $row['User_ID'];
                $thisUserUsername = $row['Username'];
                $thisUserEmail = $row['Email'];
                $thisUserFirstname = $row['Firstname'];
                $thisUserLastname = $row['Lastname'];

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }
        ?>
            <a href="#">
                <img src="../../images/Profile.png" alt="user_photo"></img>
            </a>
            <h4><?php echo $thisUserUsername ?></h4>
        </div>
    </div>
    <div class="main columns">
        <div class="left-space"></div>
        <div class="post-list" id="postList">
<?php
            require "../../Connections/Discussion-ConnectionInfo.php";
            $tabel = "post_extradata";
                    
            $sql = "SELECT * FROM $tabel ORDER BY UID DESC LIMIT 5";
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
                while($row = mysqli_fetch_assoc($result))
                {
                    require "../../Connections/Discussion-ConnectionInfo.php";
                    $postID = $row['UID'];
                    $postOwnerID = $row['User_ID'];
                    $postOwnerUsername = $row['Username'];
                    $postOwnerFullname = $row['Fullname'];
                    $postUps = $row['Ups'];
                    $postDiscussionChartsCounter = $row['Discussions'];

                    $tabel = "post_details";
                    $sql = "SELECT * FROM $tabel WHERE (UID='$postID')";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql))
                    {
                        header("../../login-register/index.php?false-Error-when-trying-to-connect-to-server");
                        exit();
                    }
                    else
                    {
                        mysqli_stmt_execute($stmt);
                        $secondResult = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($secondResult);

                        $postTitle=$row['Title'];
                        $postContent=$row['Content'];
                        $photosCounter=$row['Photos_Counter'];

                        require "../../Connections/Image-ConnectionInfo.php";
                        $tabel = "discussion";
                        $unique_identifier = "Discussion_ID";
                        $unique_identfier_value = $postID;
                
                        $sql = "SELECT * FROM $tabel WHERE ($unique_identifier='$unique_identfier_value')";
                        $stmt = mysqli_stmt_init($conn);
            
                        if (!mysqli_stmt_prepare($stmt, $sql))
                        {
                            header("../../login-register/index.php?false-Error-when-trying-to-connect-to-server");
                            exit();
                        }
                        else
                        {
                            mysqli_stmt_execute($stmt);
                            $allImageLinks = mysqli_stmt_get_result($stmt);
            
?>
            <div class="listed-item">
                <div class="discussion-header">
                    <img src="../../images/Profile.png" alt="profile_picture"></img>
                    <h4><?php echo $postOwnerUsername;?> <!--<br><span>·Date format zz mth hh::ss</span>--></h4>
                    <h4 id="discussion-title"> <?php echo $postTitle;?> </h4>
                </div>
<?php
                if($photosCounter==0)
                {

?>
                <div class="NoPhotosSection"><p><?php echo $postContent; ?></p></div>
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
?>
                <div class="interact-bar columns">
                    <div class="up-button columns">
                    <h5> <?php echo $postUps; ?> </h5>
                    <img id="Up" src="../../images/Up-unselected.png" onclick="changeImage()"></img>
                </div>
                <div class="discussion-index">
                    <h5>Discussed</h5>
                    <h6><?php echo $postDiscussionChartsCounter;?></h6>
                </div>
                <div class="toDiscussionButton">
                    <form method="post" id="GoToDisscusion" action="discussion-hub/index.php">

                        <input type="hidden" name="thisUserID" value="<?php echo $thisUserID ?>">
                        <input type="hidden" name="thisUserUsername" value="<?php echo $thisUserUsername ?>">
                        <input type="hidden" name="thisUserEmail" value="<?php echo $thisUserEmail ?>">
                        <input type="hidden" name="thisUserFirstname" value="<?php echo $thisUserFirstname ?>">
                        <input type="hidden" name="thisUserLastname" value="<?php echo $thisUserLastname ?>">

                        <input type="hidden" name="postID" value="<?php echo $postID ?>">

                        <input type="hidden" name="postOwnerID" value="<?php echo $postOwnerID ?>">
                        <input type="hidden" name="postOwnerUsername" value="<?php echo $postOwnerUsername ?>">
                        <input type="hidden" name="postOwnerFullname" value="<?php echo $postOwnerFullname ?>">

                        <input type="hidden" name="postTitle" value="<?php echo $postTitle ?>">
                        <input type="hidden" name="postContent" value="<?php echo $postContent ?>">
                        <input type="hidden" name="photosCounter" value="<?php echo $photosCounter ?>">                     

                        <button type="submit"> Discuss ᐅ</button>
                    </form>
                </div>
            </div>
        </div>
<?php 
                }
            }
        }
?>
    </div>
    <div class="loading"    lastID="<?php echo $postID; }?>" 
                            thisUserID="<?php echo $thisUserID; ?>" 
                            thisUserUsername="<?php echo $thisUserUsername; ?>" 
                            thisUserFirstname="<?php echo $thisUserFirstname; ?>" 
                            thisUserLastname="<?php echo $thisUserLastname; ?>" 
                            thisUserEmail="<?php echo $thisUserEmail; ?>" 
                            style="display: none;">
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
    var isRunning = false;
        $(document).ready(function(){
        $(window).scroll(function(){
            var lastID = $('.loading').attr('lastID');
            var thisUserID = $('.loading').attr('thisUserID');
            var thisUserUsername = $('.loading').attr('thisUserUsername');
            var thisUserFirstname = $('.loading').attr('thisUserFirstname');
            var thisUserLastname = $('.loading').attr('thisUserLastname');
            var thisUserEmail = $('.loading').attr('thisUserEmail');

            if(($(window).scrollTop() == $(document).height() - $(window).height()) && (lastID != 0) && (isRunning==false)){
                    $.ajax({
                    type:'POST',
                    url:'getData.php',
                    data:
                    {
                        id: lastID,
                        thisUserID: thisUserID,
                        thisUserUsername: thisUserUsername,
                        thisUserFirstname: thisUserFirstname,
                        thisUserLastname: thisUserLastname,
                        thisUserEmail: thisUserEmail
                    },
                    beforeSend:function(){
                        isRunning=true;
                        $('.loading').show();
                    },
                    success:function(html){
                        isRunning=false;
                        $('.loading').remove();
                        $('#postList').append(html);
                    }
                });
            }
        });
        });</script>
    <div class="right-space">
        <button type="button"   id="goToPostingPageButton"
                                thisUserID = "<?php echo $thisUserID; ?>";
                                thisUserUsername = "<?php echo $thisUserUsername; ?>";
                                onclick="GoToPostingPage()"
                                style="position:fixed;  width: 20%;
                                                        height: 3.5em;
                                                        margin-left:25px;
                                                        background-color: #30d2db;
                                                        color: white;

                                                        font-size: 1.25rem;
                                                        margin-top:50px;"
                                > Create a discussion </button>
    </div>
    <script type="text/javascript" src="../../scripts/discussion-scripts.js"></script>
</div>
<div class="footer"></div>
</div> <!--- end of the container -->
</body>
</html>
