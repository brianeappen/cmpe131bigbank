<!DOCTYPE html>
<?php
    session_start();
    if(isset($_SESSION["ATM_USER_ID"])){
        header('Location: /atm/interface/');
    	exit;
    }
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
	<title>ATM Login | ATM | Big Bank</title>
	<link rel="stylesheet" href="/atm/css/atm.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="/favicon.png">
</head>
<script>
    function addOne(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "1";
        console.log(inputField.value);
    }
    
    function addTwo(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "2";
        console.log(inputField.value);
    }
    
    function addThree(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "3";
        console.log(inputField.value);
    }
    
    function addFour(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "4";
        console.log(inputField.value);
    }
    
    function addFive(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "5";
        console.log(inputField.value);
    }
    
    function addSix(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "6";
        console.log(inputField.value);
    }
    
    function addSeven(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "7";
        console.log(inputField.value);
    }
    
    function addEight(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "8";
        console.log(inputField.value);
    }
    
    function addNine(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "9";
        console.log(inputField.value);
    }
    
    function addZero(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal + "0";
        console.log(inputField.value);
    }
    
    function delLast(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        inputField.value = currentVal.substring(0, currentVal.length - 1);;
        console.log(inputField.value);
    }
</script>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Big Bank ATM</h1>
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
                <form action="execute-login.php" method="POST">
                    <br>
                    <br>
                    <input type="password" id="loginpass" name="loginpass" placeholder="ACCT PIN" autofocus required>
                    <br><br>
                    <div class="pinPadHolder">
                        <div class="pinPadRow">
                            <input type="button" class="key" value="1" onClick="addOne();">
                            <input type="button" class="key" value="2" onClick="addTwo();"> 
                            <input type="button" class="key" value="3" onClick="addThree();"> 
                        </div>
                        <div class="pinPadRow">
                            <input type="button" class="key" value="4" onClick="addFour();">
                            <input type="button" class="key" value="5" onClick="addFive();"> 
                            <input type="button" class="key" value="6" onClick="addSix();"> 
                        </div>
                        <div class="pinPadRow">
                            <input type="button" class="key" value="7" onClick="addSeven();">
                            <input type="button" class="key" value="8" onClick="addEight();"> 
                            <input type="button" class="key" value="9" onClick="addNine();"> 
                        </div>
                        <div class="pinPadRow">
                            <input type="button" class="key" value="0" onClick="addZero();">
                            <input type="button" class="delButton" value="< Del" onClick="delLast();"> 
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="Submit"> 
                </form>
                <br>
                <br>
            </div>
            <div class="signup">
                <?php if(($retMeaning == 2) || ($retMeaning == 1)){ echo '<h2 style="color: #ff4500;">Incorrect PIN</h2>'; } else { echo '<h2>No Account Yet?</h2>';} ?>
                <hr>
                <p>Sign up Online and Give us Money!</p>
                <br><br>
                <button class="signupButton" style="width: 50%;" onClick='location.href = "/";'>That's A Big Bank!</button>
                <br><br><br>
            </div>
        </div>
        <div class="footer" id="footer-element">
            <br>
            <div class="sub-footer">
                <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
            </div>
        </div>
    </body>
</html>