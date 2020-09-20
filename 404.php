<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["USER_ID"])){
        $isLogged = true;
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
        <div class="login-form-div" style="width: 40%; margin-left: 30%;">
            <img src="/img/CashMoney.png" style="width: 90%; margin-left: 5%; margin-top: 2%; margin-bottom: 2%; border-radius: 20px; border-bottom-right-radius: 0px;">
        </div>
        <div class="page-content">
            <h1>404: That's An Error</h1>
            <hr>
            <br>
            <p>Unfortunately, we can't find the page you're looking for.</p>
        </div>

        <?php 
            if($isLogged){
                echo '
                    <div class="main-header" id="header">
                        <ul>
                            <div class="dropdown">
                                <button class="dropbtn" id="dropper">' . $_SESSION["PATRON_FIRST_NAME"] . " " . $_SESSION["PATRON_LAST_NAME"]  . '</button>
                                <div class="dropdown-content">
                                    <a href="#">'.$_SESSION["USER_NAME"].'</a>
                                    <a href="#">My Profile</a>
                                    <a href="/landing/">My Accounts</a>
                                    <a href="#">Transaction History</a>
                                    <a href="/logout/">Log Out</a>
                                </div>
                            </div>
                            <li><a href="#">Transfer Money</a></li>
                            <li><a href="#">Deposit A Check</a></li>
                            <li><a href="#">Visit ATM</a></li>
                            <li style="float: left !important;"><a href="/">Big Bank Corp.</a></li>
                        </ul>
                    </div>';
            } else {
                echo '
                    <div class="main-header" id="header">
                        <ul>
                            <li><a href="/login/">Log In</a></li>
                            <li><a href="/login/signup/">Create Account</a></li>
                            <li><a href="/#aboutus">About</a></li>
                            <li style="float: left !important;"><a href="/">Big Bank Corp.</a></li>
                        </ul>
                    </div>';
            }
        ?>
        <div class="footer" id="footer-element">
            <div class="main-footer">
                <div class="elem1">
                    <h2>Navigation</h2>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/#aboutus">About</a></li>
                        <li><a href="/login/">Log In</a></li>
                        <li><a href="/login/signup/">Create Account</a></li>
                    </ul>
                </div>
                <div class="elem2">
                    <h2>Our Address</h2>
                    <p>1234 Banking Blvd.<br>Brokersville, BA 51352</p>
                </div>
                <div class="elem3">
                    <h2>Support and Credits</h2>
                    <ul>
                        <li><a href="#">Web Support</a></li>
                        <li><a href="#">Web Source Credits</a></li>
                    </ul>
                </div>
            </div>
            <br>
            <div class="sub-footer">
                <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
            </div>
        </div>
    </body>
</html>