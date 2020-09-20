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
	<title>Transfer Money | Big Bank</title>
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
    function getRadio(){
        var selectedValue = document.querySelector('input[name="transferFunction"]:checked').value;
        var xferAcctForm = document.getElementById('accountForm');
        var xferDebtForm = document.getElementById('debtForm');
        var infoElement = document.getElementById('hideMe');
        //var sendDebtForm = document.getElementById('sendForm');
        if(selectedValue == "1"){
            xferDebtForm.style.display = "none";
            xferAcctForm.style.display = "inherit";
            infoElement.style.display = "none";
            sendDebtForm.style.display = "none";
        } else if(selectedValue == "2"){
            xferDebtForm.style.display = "inherit";
            xferAcctForm.style.display = "none";
            infoElement.style.display = "none";
            sendDebtForm.style.display = "none";
        } /*else if(selectedValue == "0"){
            xferDebtForm.style.display = "none";
            xferAcctForm.style.display = "none";
            infoElement.style.display = "none";
            sendDebtForm.style.display = "inherit";
        }*/
    }
</script>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Transfer Money</h1>
        
        <div class="login-form-div">
            <div class="transfr">
                <div class="centerer">
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
                    <div id="hideMe">
                        <hr style="margin-top: 20%; width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        <h2>Select a Transfer Type →</h2>
                        <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                    </div>
                    <?php /*************************************************************************************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <?php /******************                     FORM DATA                     ****************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <form action="execute-transfer.php" method="POST" id="accountForm" enctype="multipart/form-data" style="display: none; transition: 0.4s;">
                        <h2>Transfer Money to Another Account</h2>
                        <br>
                        <select name="depFrom" form="accountForm" class="select-css" required>
                            <option value="" selected disabled hidden>&#9660; Withdraw From:</option>
                            <?php
                                // GET ALL ACCOUNTS THAT HAVE A POSITIVE BALANCE
                                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
                            	if ($conn->connect_error) {
                            		die("Connection failed: " . $conn->connect_error);
                            	}
                            	$sql2 = "SELECT * FROM Account WHERE `BALANCE` > 0 AND `IS_ACTIVE`=1;";
                            	$result = $conn->query($sql2);
                            	$count = 0;
                            	if ($result->num_rows > 0) {
                            	    while($row = $result->fetch_assoc()) {
                            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
                            	            $count++;
                                	        echo '
                                	            <option value="' . $row["ACCT_ID"] . '">'. $row["ACCT_NAME"] . ' $' . round(floatval ($row["BALANCE"]),2) .'</option>
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
                        <br><br>
                        <input type="text" id="depAmt" name="depAmt" placeholder="Transfer Amount ($)" required><br><sup style="margin-left: 49%;">1</sup>
                        <br><br>
                        <select name="depTo" form="accountForm" class="select-css" required>
                            <option value="" selected disabled hidden>&#9660; Deposit To:</option>
                            <?php
                                // GET ALL ACCOUNTS, REGARDLESS OF BALANCE
                                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
                            	if ($conn->connect_error) {
                            		die("Connection failed: " . $conn->connect_error);
                            	}
                            	$sql2 = "SELECT * FROM Account WHERE `IS_ACTIVE`=1;";
                            	$result = $conn->query($sql2);
                            	$count = 0;
                            	if ($result->num_rows > 0) {
                            	    while($row = $result->fetch_assoc()) {
                            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
                            	            $count++;
                                	        echo '
                                	            <option value="' . $row["ACCT_ID"] . '">'. $row["ACCT_NAME"] . ' $' . round(floatval ($row["BALANCE"]),2) .'</option>
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
                        <br><hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        <h2>Verify Your Identity</h2>
                        <br>
                        <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                        <br><br><br>
                        <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                        <br><br><br>
                        <input type="submit" form="accountForm" value="Transfer Funds">
                    </form>
                    <?php /*************************************************************************************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <!--form action="execute-send-bal.php" method="POST" id="sendForm" enctype="multipart/form-data" style="display: none; transition: 0.4s;">
                        <h2>Send Money to an External Account</h2>
                        <br>
                        <select name="withFrom" form="sendForm" class="select-css" required>
                            <option value="" selected disabled hidden>&#9660; Withdraw From:</option>
                            <!--?php
                                // GET ALL ACCOUNTS THAT HAVE A POSITIVE BALANCE
                                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
                            	if ($conn->connect_error) {
                            		die("Connection failed: " . $conn->connect_error);
                            	}
                            	$sql2 = "SELECT * FROM Account WHERE `BALANCE` > 0;";
                            	$result = $conn->query($sql2);
                            	$count = 0;
                            	if ($result->num_rows > 0) {
                            	    while($row = $result->fetch_assoc()) {
                            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
                            	            $count++;
                                	        echo '
                                	            <option value="' . $row["ACCT_ID"] . '">'. $row["ACCT_NAME"] . ' $' . round(floatval ($row["BALANCE"]),2) .'</option>
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
                        <br><br>
                        <input type="text" id="withAmount" name="withAmount" placeholder="Transfer Amount ($)" required><br><sup style="margin-left: 49%;">1</sup>
                        <br><br>
                        <input type="text" id="routNum" name="routNum" placeholder="Routing Number" required>
                        <br><br>
                        <br><hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        <h2>Verify Your Identity</h2>
                        <br>
                        <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                        <br><br><br>
                        <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                        <br><br><br>
                        <input type="submit" form="accountForm" value="Transfer Funds">
                    </form-->
                    <?php /*************************************************************************************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <form action="execute-transfer.php" method="POST" id="debtForm" enctype="multipart/form-data" style="display: none; transition: 0.4s;">
                        <h2>Transfer to a Negative Account</h2>
                        <br>
                        <select name="debtFrom" form="debtForm" class="select-css" required>
                            <option value="" selected disabled hidden>&#9660; Withdraw From:</option>
                            <?php
                                //Let's connect to a database!
                                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
                            	if ($conn->connect_error) {
                            		die("Connection failed: " . $conn->connect_error);
                            	}
                            	
                            	//Let's generate an account ID that is unique
                            	$sql2 = "SELECT * FROM Account WHERE `BALANCE` > 0 AND `IS_ACTIVE`=1;";
                            	$result = $conn->query($sql2);
                            	$count = 0;
                            	if ($result->num_rows > 0) {
                            	    while($row = $result->fetch_assoc()) {
                            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
                            	            $count++;
                                	        echo '
                                	            <option value="' . $row["ACCT_ID"] . '">'. $row["ACCT_NAME"] . ' $' . round(floatval ($row["BALANCE"]),2) .'</option>
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
                        <br><br>
                        <input type="text" id="payAmt" name="payAmt" placeholder="Transfer Amount ($)" required><br><sup style="margin-left: 49%;">2</sup>
                        <br><br>
                        <select name="payTo" form="debtForm" class="select-css" required>
                            <option value="" selected disabled hidden>&#9660; Pay To:</option>
                            <?php
                                //Let's connect to a database!
                                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
                            	if ($conn->connect_error) {
                            		die("Connection failed: " . $conn->connect_error);
                            	}
                            	
                            	//Let's generate an account ID that is unique
                            	$sql2 = "SELECT * FROM Account WHERE `BALANCE` < 0 AND `IS_ACTIVE`=1;";
                            	$result = $conn->query($sql2);
                            	$count = 0;
                            	if ($result->num_rows > 0) {
                            	    while($row = $result->fetch_assoc()) {
                            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
                            	            $count++;
                                	        echo '
                                	            <option value="' . $row["ACCT_ID"] . '">'. $row["ACCT_NAME"] . ' $' . round(floatval ($row["BALANCE"]),2) .'</option>
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
                            	$conn -> close();
                            ?>
                        </select>
                        <br><hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        <h2>Verify Your Identity</h2>
                        <br>
                        <input type="text" id="loginuser2" name="loginuser" placeholder="Username" required>
                        <br><br><br>
                        <input type="password" id="loginpass2" name="loginpass" placeholder="Password" required>
                        <br><br><br>
                        <input type="submit" form="debtForm" value="Transfer Funds">
                    </form>
                    <?php /*************************************************************************************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <?php /******************                END/FORM DATA                      ****************/ ?>
                    <?php /*************************************************************************************/ ?>
                    <?php /*************************************************************************************/ ?>
                </div>
                <br>
                <br>
            </div>
            <div class="signup" style="padding: 0 15px; width: calc(45% - 30px);">
                <div class="centerer">
                    <h2>What Type of Transfer?</h2>
                    <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                    <br>
                </div>
                <div class="radioHolder">
                    <!--input type="radio" name="transferFunction" id="tf00" value="0">
                    <label for="tf00">Send to External Account</label>
                    <br-->
                    <input type="radio" name="transferFunction" id="tf01" value="1">
                    <label for="tf01">Transfer Between Accounts</label>
                    <br>
                    <input type="radio" name="transferFunction" id="tf02" value="2">
                    <label for="tf02">Pay Off Negative Balance</label>
                    <br>
                    <input type="button" class="signupButton" value="Submit" onClick="getRadio();">
                    <br><br>
                </div>
            </div>
            <br><br>
        </div>
        <br><br><br><br><br>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php'; ?>
    </body>
</html>
