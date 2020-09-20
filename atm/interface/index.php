<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["ATM_USER_ID"])){
        header('Location: /atm/');
    	exit;
    }
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
	<title>ATM Interface | ATM | Big Bank</title>
	<link rel="stylesheet" href="/atm/css/atm.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="/favicon.png">
</head>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Hey there, <?php echo $_SESSION["ATM_PATRON_FIRST_NAME"]; ?>!</h1>
        <div class="option-column">
            <a href="/atm/interface/withdraw/">
                <div class="option-obj">
                    <hr>
                    <h1>Withdraw Money &#128184;</h1>
                </div>
            </a>
            <a href="/atm/interface/acctinfo/">
                <div class="option-obj">
                    <hr>
                    <h1>Your Account Info</h1>
                </div>
            </a>
        </div>
        <div class="option-column">
            <a href="/">
                <div class="option-obj">
                    <hr>
                    <h1>Back to Big Bank</h1>
                </div>
            </a>
            <a href="/atm/logout/">
                <div class="option-obj">
                    <hr>
                    <h1>Log Out</h1>
                </div>
            </a>
        </div>
        <div class="footer" id="footer-element">
            <br>
            <div class="sub-footer">
                <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
            </div>
        </div>
    </body>
</html>