<?php include_once 'header.php'
?>
<body>
<!-- start of the container -->
<div class="container">
    <div class="columns header">
        <div class="logo">
            <img src="../../images/RoundedLogo.png"></img>
        </div>  
        <div class="links">
            <a href="#">Posts</a>
        </div>
        <div class="links">
            <a href="#">Discussions</a>
        </div>
        <div class="links">
            <a href="#">Companies</a>
        </div>
        <div class="links">
            <a href="#">About us</a>
        </div>
    </div>
    <div class="columns">
        <div class="form-box">
            <div class="title"> 
                <h1>Welcome to <span>Alternative</span></h1>
            </div>
            <div class="button-box columns">
                <div id="btn-bg"></div>
                <button type="button" class="toggle-btn" onclick="login()" id="login-btn"> Log In </button>
                <button type="button" class="toggle-btn" onclick="register()" id="register-btn"> Register </button>
            </div>>
            <form action="database-comunication/login.php" method="post" id="login" class="input-group">
                 <div>
                    <input type="text" name="username" placeholder="Username or email" class="input-field"/>
                </div>
                <div>
                    <input type="password" name="password" placeholder="Password" class="input-field"/>
                </div>
                <div>
                    <button type="submit" class="submit-btn" name="submit"> Log in </button>
                </div>
            </form>
            <form action="database-comunication/register.php" method="post" id="register" class="input-group">
                <div>
                    <h4>Username:</h4>
                    <input type="text" name="username" class="input-field"/>
                </div>
                <div>
                    <h4>Password:</h4>
                    <input type="password" name="password" class="input-field"/>
                </div>
                <div>
                    <h4>Repeat password:</h4>
                    <input type="password" name="repeatedPassword" class="input-field"/>
                </div>
                <div>
                    <h4>Email:</h4>
                    <input type="text" name="email" class="input-field"/>
                </div>
                <div>
                    <button type="submit" class="submit-btn" name="submit"> Sign up </button>
                </div>
            </form>
            <script src="../../scripts/login-scripts.js"></script>
        </div>
        <div class="listed-pages">
            <div class="columns">
                <div id="posts">
                    <img src="../../images/posts-for-web.png">
                    <h3>Posts</h3>
                    <p> Get <span>motivation</span> from people who succeeded! Look at public people who share not only the achievements 
                        with the community but also the story behind that success.  
                    </p>
                </div>
                <div id="discussions">
                    <img src="../../images/discussions-for-web.png">
                    <h3>Discussions</h3>
                    <p> Create <span>discussion pools</span> and talk about subjects you are interested in. 
                        <span>Ask a question</span> about what you don't understand. <span>Be open-minded!</span> See other's mindset.
                    </p>
                </div>
            </div>
            <div id="companies">
                <img src="../../images/companies-for-web.png">
                <h3>Companies</h3>
                <p> Check about the <span>companies</span> listed and see what are their <span>duty</span>, how they accomplish that mission and what 
                    <span>skills</span> are required to be employed. Moreover, read about <span>employees's opinion</span> regarding to working in those companies,
                    what they must do and how they <span>progress in their career</span>. Last, check out when are the <span>events hosted</span> by them as you might be interested
                    to take part in.
                </p>
            </div>
        </div>
    </div>
    <div>
        <div class="footer">
        </div>
    </div>
</div> <!--- end of the container -->
</body>
</html>