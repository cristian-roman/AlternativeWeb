
<link rel="stylesheet" href="../../css/discussions.css"/>
<?php
if(!empty($_POST["id"]))
{
    
    $beginning = "https://192.168.1.19/";
    $base= $beginning."Alternative(2.0)/";

    require "../../Connections/Discussion-ConnectionInfo.php";

    $lastPostId = $_POST["id"];
    $thisUserID = $_POST["thisUserID"];
    $thisUserUsername = $_POST["thisUserUsername"];
    $thisUserEmail = $_POST["thisUserEmail"];
    $thisUserFirstname = $_POST["thisUserFirstname"];
    $thisUserLastname = $_POST["thisUserLastname"];

    $showLimit = 3;

    $tabel = "post_extradata";         
    $sql = "SELECT * FROM $tabel WHERE (UID < ".$lastPostId.") ORDER BY UID DESC LIMIT ".$showLimit;
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
            while($row!=NULL)
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
        <script src="../../scripts/discussion-scripts.js"></script>

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
                <input type="hidden" name="postOwnerFullname" value="<?php echo  $postOwnerFullname ?>">

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
            $row = mysqli_fetch_assoc($result);
        }
?>
<?php 
            if($postID > 0)
            {
?>
     <div class="loading"   lastID="<?php echo $postID; ?>" 
                            thisUserID="<?php echo $thisUserID; ?>" 
                            thisUserUsername="<?php echo $thisUserUsername; ?>" 
                            thisUserFirstname="<?php echo $thisUserFirstname; ?>" 
                            thisUserLastname="<?php echo $thisUserLastname; ?>"
                            thisUserEmail="<?php echo $thisUserEmail; ?>" 
                            style="display: none;">
        </div>
<?php 
            }

            else
            {
?>
    <div class="loading" lastID="0" thisUserID="<?php echo $thisUserID; ?>" 
                                    thisUserUsername="<?php echo $thisUserUsername; ?>" 
                                    thisUserFirstname="<?php echo $thisUserFirstname; ?>" 
                                    thisUserLastname="<?php echo $thisUserLastname; ?>"
                                    thisUserEmail="<?php echo $thisUserEmail; ?>"  >
                                    
        <p>No more posts. Come later for more!</p>
    </div>
<?php   
            }
        }
        else
        {
?>
    <div class="loading" lastID="0" thisUserID="<?php echo $thisUserID; ?>" 
                                    thisUserUsername="<?php echo $thisUserUsername; ?>" 
                                    thisUserFirstname="<?php echo $thisUserFirstname; ?>" 
                                    thisUserLastname="<?php echo $thisUserLastname; ?>" 
                                    thisUserEmail="<?php echo $thisUserEmail; ?>" >
            <p>No more posts. Come later for more!</p>
    </div>
<?php
        }   
    }
}
?>