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
	<title>ATM Withdraw | ATM | Big Bank</title>
	<link rel="stylesheet" href="/atm/css/atm.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="/favicon.png">
</head>
<script>
    var hasDot = false;
    var afterDot = 0;
    
    function addOne(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "1";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "1";
        }
        console.log(inputField.value);
    }
    
    function addTwo(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "2";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "2";
        }
        console.log(inputField.value);
    }
    
    function addThree(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "3";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "3";
        }
        console.log(inputField.value);
    }
    
    function addFour(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "4";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "4";
        }
        console.log(inputField.value);
    }
    
    function addFive(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "5";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "5";
        }
        console.log(inputField.value);
    }
    
    function addSix(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "6";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "6";
        }
        console.log(inputField.value);
    }
    
    function addSeven(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "7";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "7";
        }
        console.log(inputField.value);
    }
    
    function addEight(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "8";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "8";
        }
        console.log(inputField.value);
    }
    
    function addNine(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "9";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "9";
        }
        console.log(inputField.value);
    }
    
    function addZero(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if((hasDot) && (afterDot < 2)){
            inputField.value = currentVal + "0";
            afterDot = afterDot + 1;
        } else if(!hasDot){
            inputField.value = currentVal + "0";
        }
        console.log(inputField.value);
    }
    
    function addDot(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if(!hasDot){
            inputField.value = currentVal + ".";
            hasDot = true;
        }
        console.log(inputField.value);
    }
    
    function delLast(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        if(currentVal.charAt(currentVal.length-1) == '.'){
            hasDot = false;
        } else if((hasDot == true) && (afterDot > 0)){
            afterDot = afterDot - 1
        }
        inputField.value = currentVal.substring(0, currentVal.length - 1);
        console.log(inputField.value);
    }
    
    function quickSubmit(amountRequested){
        var amountFormInput = document.getElementById("hiddenAmount");
        amountFormInput.value = amountRequested;
        var amountFormAcct = document.getElementById("withFromSelect");
        var accountInfo = amountFormAcct.value;
        if(accountInfo == ""){
            alert("Please Select an Account to Withdraw From");
            return;
        }
        accountInfo = accountInfo.split("::");
        var accountID = accountInfo[0];
        var accountBalance = accountInfo[1];
        if((parseFloat(accountBalance) < parseFloat(amountRequested)) && (parseFloat(amountRequested) < 30.0)){
            alert("Lol you're broke, try another account or a custom amount if you... can...");
            return;
        } else if (parseFloat(accountBalance) < parseFloat(amountRequested)){
            alert("Attempt to Overdraw Account, Please Choose Another Account or a Lower Amount");
            return;
        }
        amountFormInput.value = amountRequested + "::" + accountID;
        var amountForm = document.getElementById("amountRequest");
        amountForm.submit();
    }
    
    function customSubmit(){
        var inputField = document.getElementById("loginpass");
        var currentVal = inputField.value;
        var amountFormInput = document.getElementById("hiddenAmount");
        var amountFormAcct = document.getElementById("withFromSelect");
        var accountInfo = amountFormAcct.value;
        if(accountInfo == ""){
            alert("Please Select an Account to Withdraw From");
            return;
        }
        accountInfo = accountInfo.split("::");
        var accountID = accountInfo[0];
        var accountBalance = accountInfo[1];
        if((parseFloat(accountBalance) < parseFloat(currentVal)) && (parseFloat(currentVal) < 30.0)){
            alert("Lol you're broke, try another account or a custom amount if you... can...");
            return;
        } else if (parseFloat(accountBalance) < parseFloat(currentVal)){
            alert("Attempt to Overdraw Account, Please Choose Another Account or a Lower Amount");
            return;
        }
        amountFormInput.value = currentVal + "::" + accountID;
        var amountForm = document.getElementById("amountRequest");
        amountForm.submit();
    }

</script>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <a class="backLink" href="../">
            <div class="backButton">
                <h3>< Back</h3>
            </div>
        </a>
        <div class="dropdown-holder">
            <select id="withFromSelect" name="depTo" class="select-css" required>
                <option value="" selected disabled hidden>&#9660; Withdraw From:</option>
                <?php
                    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
                	if ($conn->connect_error) {
                		die("Connection failed: " . $conn->connect_error);
                	}
                	$sql2 = "SELECT * FROM Account WHERE `BALANCE` > 0 AND `IS_ACTIVE`=1;";
                	$result = $conn->query($sql2);
                	$count = 0;
                	if ($result->num_rows > 0) {
                	    while($row = $result->fetch_assoc()) {
                	        if($row["USER_ID"] == $_SESSION["ATM_USER_ID"]){
                	            $count++;
                    	        echo '
                    	            <option value="' . $row["ACCT_ID"] . '::' . round(floatval ($row["BALANCE"]),2) . '">'. $row["ACCT_NAME"] . ' $' . round(floatval ($row["BALANCE"]),2) .'</option>
                    	        ';
                	        }
                	    }
                	    if($count != 0){
                	        $noAcc = true;
                	    }
                	} 
                	if($count == 0){
                	    $noAcc = true;
                	}
                	$conn->close();
                ?>
            </select>
        </div>
        <h1 style="padding-top: 1%; font-size: 3em; margin-left: 20%;">Withdraw</h1>
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
                <form action="#" method="POST">
                    <br>
                    <br>
                    <input type="text" id="loginpass" name="loginpass" placeholder="Custom Amount ($)" autofocus required>
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
                            <input type="button" class="key" value="." onClick="addDot();">
                            <input type="button" class="key" value="< Del" onClick="delLast();">
                        </div>
                    </div>
                    <br>
                    <input type="button" onclick='customSubmit();' value="Submit" class="quickButton"> 
                </form>
                <br>
                <br>
            </div>
            <div class="signup">
                <h2>Quick Withdraw</h2>
                <hr>
                <button class="quickButton" onclick='quickSubmit("20");'>$20</button>
                <br><br>
                <button class="quickButton" onclick='quickSubmit("40");'>$40</button>
                <br><br>
                <button class="quickButton" onclick='quickSubmit("50");'>$50</button>
                <br><br>
                <button class="quickButton" onclick='quickSubmit("100");'>$100</button>
                <br><br>
            </div>
        </div>
        <form id="amountRequest" method="POST" action="attempt-withdraw.php">
            <input type="hidden" id="hiddenAmount" name="hiddenAmount">
        </form>
        <div class="footer" id="footer-element">
            <br>
            <div class="sub-footer">
                <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
            </div>
        </div>
    </body>
</html>