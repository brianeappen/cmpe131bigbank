<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["USER_ID"])){
        header('Location: /login/?return=4');
    	exit;
    }
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
	<title>New Account | Big Bank</title>
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
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Open a New Big Bank Account</h1>
        
        <div class="login-form-div">
            <div class="login">
                <h2>Enter Account Information Below: </h2>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <br>
                <?php 
                    $retMeaning = 5;
                    if(isset($_GET["return"])){
                        $retVal = $_GET["return"];
                        $retMeaning = 9;
                        if($retVal == "1"){
                            $retMeaning = 1;
                        } else if($retVal == "2") {
                            $retMeaning = 2;
                        } else if($retVal[0] == "3"){
                            $retMeaning = 3;
                        } else {
                            $retMeaning = 9;
                        }
                    }
                ?>
                <form action="execute-newaccount.php" method="POST" id="accountForm">
                    <input type="text" id="acctname" name="acctname" placeholder="Account Description" required><br><sup style="margin-left: 49%;">1</sup>
                    <br><br>
                    <select name="accttype" form="accountForm" class="select-css">
                        <option value="" selected disabled hidden>Account Type</option>
                        <option value="0">Credit</option>
                        <option value="1">Checking</option>
                        <option value="2">Savings</option>
                    </select>
                    <sup style="margin-left: 49%;">2</sup>
                    <br><hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                    <h2>Verify Your Identity</h2>
                    <br>
                    <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                    <br><br><br>
                    <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                    <br><br><br>
                    <input type="submit" value="Open Account">
                </form>
                <br>
                <br>
            </div>
            <div class="signup" style="padding: 0 15px; width: calc(45% - 30px);">
                <h2>FAQ</h2>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <p><sup>1&nbsp;&nbsp;</sup>The "nickname" you want for this account. It can be anything you want! (E.G. "My Checking", "Car Savings", etc.)
                This will be visible on your accounts page and is to help you better identify your own accounts.</p>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <p><sup>2&nbsp;&nbsp;</sup>Here at Big Bank, we offer three types of accounts! We offer a savings plan that offers a low interest rate, a 
                credit plan with a higher interest rate and overdraft fees, and a checking account that you can just dump your money into if you feel like it.</p>
                <br>
                <br>
            </div>
        </div>
        <div class="page-content">
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php'; ?>
    </body>
</html>