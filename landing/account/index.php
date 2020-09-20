<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["USER_ID"])){
        header('Location: /login/?return=4');
    	exit;
    }
    if(!isset($_GET["accountid"])){
        header('Location: /landing/?return=6');
    	exit;
    }
    
    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
    $sql2 = 'SELECT * FROM `Account` WHERE `ACCT_ID` = ' . $_GET["accountid"] .';';
	$result = $conn->query($sql2);
	$count = 0;
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
            $ACCOUNT_ID = $_GET["accountid"];
            $ACCOUNT_BALANCE = round(floatval ($row["BALANCE"]),2);
            $ACCOUNT_NAME = $row["ACCT_NAME"];
	        if($row["ACCT_TYPE"] == "0"){
	            $acctTYPE = "Credit";
	        } else if($row["ACCT_TYPE"] == "1") {
	            $acctTYPE = "Checking";
	        } else if($row["ACCT_TYPE"] == "2"){
	            $acctTYPE = "Savings";
	        }
	    }
	} 
?>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&amp;display=swap" rel="stylesheet">
	<title>Transaction Review | Big Bank</title>
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
    function closeOveray(){
        var overlay = document.getElementById("pageover");
        overlay.style.display = "none";
    }
    function openOverlay(){
        var overlay = document.getElementById("pageover");
        overlay.style.display = "block";
    }
</script>
<div class="page-overlay" id="pageover" style="display: none;">
    <div class="pageOverlayCanvas">
        <div class="pageOverlayHeader">
            <h2>Close Account</h2>
        </div>
        <div class="pageOverlayContent">
            <?php
                if($ACCOUNT_BALANCE > 0){
                    echo '
                        <form action="execute-transfer.php" method="POST" id="accountForm" enctype="multipart/form-data">
                            <h4>Are You Sure You Want To Remove This Account?</h4>
                            <input type="hidden" name="depFrom" id="depFrom" value='. $_GET["accountid"] .'>
                            <input type="hidden" id="depAmt" name="depAmt" value='. $ACCOUNT_BALANCE .'>
                            <select name="depTo" form="accountForm" class="special-select-css" required>
                                <option value="" selected disabled hidden>&#9660; Deposit Remaining Balance To:</option>';
                                    // GET ALL ACCOUNTS, REGARDLESS OF BALANCE
                                	$sql2 = 'SELECT * FROM Account WHERE `IS_ACTIVE`=1 AND `ACCT_ID` <> '.$_GET["accountid"].';';
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
                            echo '</select>
                            <br><hr>
                            <h4>Verify Your Identity</h4>
                            <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                            <br><br>
                            <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                            <br><br><br>
                            <input type="submit" form="accountForm" value="Close Account" style="margin-right: 2%;">
                            <input type="button" onclick="closeOveray();" class="cancelButton" value="Cancel" style="margin-left: 2%;">
                        </form>
                    ';
                } else if($ACCOUNT_BALANCE == 0){
                    echo '
                        <form action="execute-transfer.php" method="POST" id="accountForm" enctype="multipart/form-data">
                            <h4>Are You Sure You Want To Remove This Account?</h4>
                            <input type="hidden" name="depFrom" id="depFrom" value='. $_GET["accountid"] .'>
                            <input type="hidden" id="depAmt" name="depAmt" value='. $ACCOUNT_BALANCE .'>';
                            	$sql2 = 'SELECT * FROM Account WHERE `IS_ACTIVE`=1 AND `ACCT_ID` <> '.$_GET["accountid"].';';
                            	$result = $conn->query($sql2);
                            	$count = 0;
                            	if ($result->num_rows > 0) {
                            	    while($row = $result->fetch_assoc()) {
                            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
                            	            $randAcct = $row["ACCT_ID"];
                            	        }
                            	    }
                            	    if($count != 0){
                            	        $noAcc = true;
                            	    }
                            	} 
                            	if($count == 0){
                            	    $noAcc = true;
                            	}
                            echo '<input type="hidden" name="depTo" id="depTo" value='. $randAcct .'>
                            <p>Your account is completely paid off! Nice work, we just need to verify that<br>
                            you have the authorization to close this account! Thanks for banking with us!
                            <br><hr>
                            <h4>Verify Your Identity</h4>
                            <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                            <br><br>
                            <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                            <br><br><br>
                            <input type="submit" form="accountForm" value="Close Account" style="margin-right: 2%;">
                            <input type="button" onclick="closeOveray();" class="cancelButton" value="Cancel" style="margin-left: 2%;">
                        </form>
                    ';
                } else {
                    echo '
                        <br>
                        <h3>ERROR: Insufficient Funds To Close Account</h3>
                        <br>
                        <hr>
                        <br>
                        <p>You can\'t close an account that has a negative balance. Please transfer funds<br> to this account or deposit money if you wish 
                        to close this account.</p>
                        <br><br>
                        <input type="button" onclick="closeOveray();" class="cancelButton" value="Exit">
                    ';
                }
            ?>
        </div>
        <button class="pageOverlayCloser" onclick="closeOveray();">X</button>
    </div>
</div>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Review <?php echo $ACCOUNT_NAME; ?> Account</h1>
        
        <div class="login-form-div">
            <div class="login">
                <h2>Account Information: </h2>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <?php 
                    echo '
                        <h3>Account Balance</h3>
                        <p>$'.$ACCOUNT_BALANCE.'</p>
                        <br>
                        <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        <h3>Account Name</h3>
                        <p>'.$ACCOUNT_NAME.'</p>
                        <br>
                        <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        <h3>Account Type</h3>
                        <p>'.$acctTYPE.'</p>
                        <br>
                        <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                    ';
                ?>
                <br>
                <br>
            </div>
            <div class="signup" style="padding: 0 15px; width: calc(45% - 30px);">
                <h2>Account Options</h2>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <br>
                <button class="closeAccButton" id="closeAccountButton" onClick="openOverlay();">Close Account</button>
                <br><br><br>
            </div>
        </div>
        <div class="page-content">
            <table class="transactionTable" cellspacing="0">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
                <?php
                	$sql2 = 'SELECT * FROM `Transaction` WHERE EXISTS (SELECT `ACCT_ID` FROM Account WHERE `USER_ID` = '. $_SESSION["USER_ID"] .') AND `ACCT_ID` = ' . $_GET["accountid"] .' ORDER BY `DATETIME` DESC;';
                	$result = $conn->query($sql2);
                	$count = 0;
                	if ($result->num_rows > 0) {
                	    while($row = $result->fetch_assoc()) {
            	            $count++;
            	            
            	            //DETERMINES WHAT TYPE OF TRANSACTION
                	        if($row["IS_DEPOSIT"] == "0"){
                	            $tranType = "Withdraw from ";
                	            $moneyPrefix = "-";
                	        } else if($row["IS_DEPOSIT"] == "1") {
                	            $tranType = "Deposit to ";
                	            $moneyPrefix = "";
                	        } else if($row["IS_DEPOSIT"] == "2") {
                	            $tranType = "Transfer to ";
                	            $moneyPrefix = "";
                	        } else if($row["IS_DEPOSIT"] == "3") {
                	            $tranType = "Transfer from ";
                	            $moneyPrefix = "-";
                	        }
                	        
                	        $sql4 = 'SELECT `ACCT_NAME` FROM Account WHERE `ACCT_ID` = '. $row["ACCT_ID"] .';';
                	        $result2 = $conn->query($sql4);
                	        if ($result2->num_rows > 0) {
                        	    while($row2 = $result2->fetch_assoc()) {
                        	        $accNm = $row2["ACCT_NAME"];
                        	    }
                	        }
                	        echo '
                	            <tr>
                	                <td>'. $tranType . $accNm .'</td>
                	                <td>'. $moneyPrefix .'$'. $row["TRANS_AMT"] .'</td>
                	                <td>'. $row["DATETIME"] .'</td>
                	                <td>
                	                    <button class="detailButton" onClick=\'location.href = "/landing/transaction/?transactionid='. $row["TRANS_ID"] .'";\'>Details</button>
                                    </td>
                	            </tr>
                	        ';
                	    }
                	} 
                	if($count == 0){
                	    echo '<h5 style="text-align: center;">Wow! No recent transactions to see!</h5>';
                	}
                	
                	$conn->close();
                ?>
            </table>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php'; ?>
    </body>
</html>
