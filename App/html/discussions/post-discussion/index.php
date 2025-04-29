<?php 
    $thisUserUsername = $_GET['thisUserUsername'];
    $thisUserID = $_GET['thisUserID'];

    //$thisUserUsername = "admin";
    //$thisUserID = "1";

    include_once 'header.php';
?>
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
        <div class="main post-form">
            <div class="form-title">
                <h1>Share your thoughts:</h1>
            </div>
            <form method="post" enctype="multipart/form-data" action="database-comunication/uploadDiscussion.php">
                <div class="discussion-header columns">
                    <div class="profile-image">
                        <img src="../../../images/Profile.png" alt="profile_picture"/>
                    </div>
                    <div class="username">
                        <h4><?php echo $thisUserUsername;?></h4>
                    </div>
                    <div class="discussion-title">
                        <input type="text" id="discussion-title" name="postTile" placeholder="Type the title..."/>
                    </div>
                </div>
                <div class="post-from-text">
                    <textarea id="post-text" name="postText" rows="4" cols="50">Describe the subject to be disputed...</textarea>
                </div>
                <div class="discussion-form">
                    <div class= "addPhoto columns">  
                        <p> Add Photos: </p>
                        <div class="post-images">
                            <input type="file" name="postImages[]" id="postImages" multiple>
                            <input type="hidden" name="thisUserID" value="<?php echo $thisUserID ?>">
                            <input type="hidden" name="thisUserUsername" value="<?php echo $thisUserUsername ?>">
                        </div>
                    </div>
                    <div class="upload-button">
                        <input type="submit"id="submitButton" value="Upload post"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="right-space"></div>
    </div>
    <div class="footer"></div>
</div><!--- end of the container -->
</body>
</html>
