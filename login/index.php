<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["USER_ID"])){
        header('Location: /landing/');
    	exit;
    }
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
	<title>Login | Big Bank</title>
	<link rel="stylesheet" href="/css/index.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="/favicon.png">
</head>
<script>
    window.onscroll = function() {
        scroller()
    };
    function scroller() {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            var header = document.getElementById("header")
            header.style.fontSize = "12px";
        } else {
            var header = document.getElementById("header")
            header.style.fontSize = "18px";
        }
    }
</script>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Log Into Big Bank</h1>
        <div class="login-form-div">
            <?php 
                $retMeaning = 9;
                if(isset($_GET["return"])){
                    $retVal = $_GET["return"];
                    if($retVal == "1"){
                        $retMeaning = 1;
                    } else if($retVal == "2") {
                        $retMeaning = 2;
                    } else if($retVal == "3"){
                        $retMeaning = 3;
                    } else {
                        $retMeaning = 9;
                    }
                }
            ?>
            <div class="login">
                <h2>Login to Your Account!</h2>
                <form action="execute-login.php" method="POST">
                    <?php if(($retMeaning == 2) || ($retMeaning == 1)){ echo '<p style="color: #ff4500;">Incorrect Username or Password</p>'; } ?>
                    <!--h3>Username</h3-->
                    <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                    <!--h3>Password</h3--><br><br><br>
                    <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                    <br><br><br>
                    <input type="submit">
                </form>
                <br>
                <br>
            </div>
            <div class="signup">
                <h2>No Account Yet?</h2>
                <hr>
                <p>Let us take your money!</p>
                <br>
                <button class="signupButton" onClick='location.href = "/login/signup/";'>Sign Up!</button>
                <br><br>
            </div>
        </div>
        <div class="page-content">
            <h1>Log In or Sign Up</h1>
            <hr>
            <br>
            <p>Not a Big Bank member? No worries! Click the "Sign Up!" button and provide us with a tiny bit of personal information and you'll be on your way to giving us your money! All that's required is your name, a good 
            username, and a secure password! Just like that, you're on your way to banking with us! <br>
            <br>Already a member? Log in today to access your account and manage your money! Manage your accounts, create new ones, deposit checks, and transfer money all in a few clicks! Kind of scary how easy it is
            to move your money around? No worries! With our own unique encryption methods, you can always be sure your money is safe with us!</p>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/unlogged-header-footer.php'; ?>
    </body>
</html>