<!DOCTYPE html>
<?php
    session_start();
    $isLogged = false;
    if(isset($_SESSION["USER_ID"])){
        $isLogged = true;
    } else {
        $isLogged = false;
    }
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
	<title>Big Bank | CmpE 131 Project</title>
	<link rel="stylesheet" href="/css/index.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="/favicon.png">
</head>
<?php
    if($isLogged){
        echo '
        <script>
            window.onscroll = function() {
                scroller()
            };
            function scroller() {
                if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                    var header = document.getElementById("header");
                    var dropbar = document.getElementById("dropper");
                    header.style.fontSize = "12px";
                    dropbar.style.fontSize = "12px";
                } else {
                    var header = document.getElementById("header");
                    var dropbar = document.getElementById("dropper");
                    header.style.fontSize = "18px";
                    dropbar.style.fontSize = "18px";
                }
            }
        </script>
        ';
    } else {
        echo '
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
        ';
    }
?>
<body>
        <!--a href="https://www.freepik.com/free-photos-vectors/business">Business vector created by freepik - www.freepik.com</a>
        <a href="https://www.freepik.com/free-photos-vectors/money">Money vector created by rawpixel.com - www.freepik.com</a-->
        <div class="banner">
            <div class="banner-img">
                <img src="/img/BigMoney.png">
            </div>
            <div class="banner-content">
                <h1 style="margin-top: 10%; text-align: center; font-size: 4em; color: #fff;">Big Bank Corp.</h1>
                <h3>Somewhere else to put your Money.</h3>
                <?php
                    if($isLogged){
                        echo '<button class="banner-button" onClick=\'location.href = "/landing/";\'>View My Accounts</button>';
                    } else {
                        echo '<button class="banner-button" onClick=\'location.href = "/login/";\'>Log In/Sign Up</button>';
                    }
                ?>
            </div>
        </div>
        <div class="page-content">
            <h1>Welcome to the Big Bank Corp.</h1>
            <hr>
            <p>
                <h2>Why choose Big Bank?</h2>
                <h3><B>Security</B></h3>
                <p style="margin-left: 15px;">
                    We back all of our transactions with state of the art security and regularly maintain our servers and work off of customer feedback.
                    Any work done on Big Bank is encrypted and uses industry-leading safety features to protect our customer data.
                    <br><br>
                    We are a bank built for our clients, not for ourselves. Our account tellers are experts with our fully online system and
                    feature consistent and friendly support channels.
                    <br><br>
                    Big Bank supports third party bank transfers, picture based check deposits, multiple accounts per user, and a fully
                    customizable banking experience! Big Bank caters to individuals and families alike, so sign up today and turn your little bank into Big Bank!
                </p>
            </p>
        </div>
        <div class="rev-banner" id="aboutus">
            <div class="banner-content-rev">
                <h1 style="margin-top: 10%; text-align: center; font-size: 1.6em; color: #fff;">
                    Find the Right <span style="font-size: 0.5em; vertical-align: bottom;">High APR</span><span style="font-size: 0.4em; vertical-align: middle;">*</span> Account For You!
                </h1>
                <p>We're Sure that we Have the Right One for You!</p>
                <?php
                    if($isLogged){
                        echo '<button class="banner-button" onClick=\'location.href = "/landing/";\'>Account Details</button>';
                    } else {
                        echo '<button class="banner-button" onClick=\'location.href = "/login/";\'>Start Here!</button>';
                    }
                ?>
            </div>
            <div class="banner-img-rev">
                <img src="/img/BigPiggy.png">
            </div>
        </div>
        <div class="page-content">
            <h2>Who are we?</h2>
            <p style="margin-left: 15px;">
                <a href="/" style="text-decoration: none; color: var(--main-ac-color);"><B>Big Bank Corp.</B></a>
                was founded by eight college students who understand the struggles that major banks have
                invoked upon us with confusing jargon and unsightly graphics from a prehistoric time.
                <br><br>
                We have created a bank simply for managing your personal finances, in a space safe from constant loan and credit card
                advertisements. Banking with Big Bank has never been more approachable, as we ensure all transactions are fulfilled accurately
                and in a timely manner. We vow to work with you as you carry out your everyday life using our services... Maybe ;)
                <br><br>
                We consume those little banks and make an even bigger bank!
            </p>
        </div>
        <?php
            if($isLogged){
                require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php';
            } else {
                require $_SERVER['DOCUMENT_ROOT'] . '/incl/unlogged-header-footer.php';
            }
        ?>
    </body>
</html>
