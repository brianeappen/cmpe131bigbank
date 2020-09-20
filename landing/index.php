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
	<title>Welcome Back | CmpE 131 Project</title>
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
        <div class="rev-banner" id="aboutus">
            <div class="banner-content-rev">
                <h1 style="margin-top: 10%; text-align: center;">
                    Welcome Back, <?php echo $_SESSION["PATRON_FIRST_NAME"]; ?>!
                </h1>
                <p>Let's see how those accounts are doing!</p>
                <p>ATM PIN: <?php echo $_SESSION["USER_PIN"]; ?></p>
                <br>
            </div>
            <div class="banner-img-rev-land">
                <img src="/img/BigMoney.png">
            </div>
        </div>
        <div class="page-content">
            <h2 id="ACCOUNTS_SECTION">Your Accounts</h2>
            <hr><br>
            <?php
                //Let's connect to a database!
                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
            	if ($conn->connect_error) {
            		die("Connection failed: " . $conn->connect_error);
            	}
            	
            	//Let's generate an account ID that is unique
            	$sql2 = "SELECT * FROM Account WHERE `IS_ACTIVE`=1;";
            	$result = $conn->query($sql2);
            	$count = 0;
            	if ($result->num_rows > 0) {
            	    while($row = $result->fetch_assoc()) {
            	        if($row["USER_ID"] == $_SESSION["USER_ID"]){
            	            $count++;
                	        if($row["ACCT_TYPE"] == "0"){
                	            $acct = "Credit";
                	        } else if($row["ACCT_TYPE"] == "1") {
                	            $acct = "Checking";
                	        } else if($row["ACCT_TYPE"] == "2"){
                	            $acct = "Savings";
                	        }
                	        echo '
                	            <div class="account-reviewer">
                                    <div class="elem1">
                                        <h3>'. $row["ACCT_NAME"] .'</h3>
                                    </div>
                                    <div class="elem2">
                                        <h5>'. $acct .'</h5>
                                    </div>
                                    <div class="elem3">
                                        <h3>$'. round(floatval ($row["BALANCE"]),2) .'</h3>
                                    </div>
                                    <div class="elem4">
                                        <button class="detailButton" onClick=\'location.href = "/landing/account/?accountid='. $row["ACCT_ID"] .'";\'>Account Details</button>
                                    </div>
                                </div>
                	        ';
            	        }
            	    }
            	    if($count != 0){
            	        echo '
                	        <div class="account-add-prompt-div">
                                <div class="add-elem">
                                    <button class="detailButton" onClick=\'location.href = "/landing/openaccount/";\'>Open Another Account</button>
                                </div>
                            </div>
                        ';
            	    }
            	} 
            	if($count == 0){
            	    echo '<h5 style="text-align: center;">Hmm... it doesn\'t look like you have any accounts.</h5>';
            	    echo '
                	        <div class="account-add-prompt-div">
                                <div class="add-elem">
                                    <button class="detailButton" onClick=\'location.href = "/landing/openaccount/";\'>Open Your First Account</button>
                                </div>
                            </div>
                        ';
            	}
            ?>
            <h2 id="TRANSACTIONS_SECTION">Your Recent Transactions</h2>
            <hr><br>
            <table class="transactionTable" cellspacing="0">
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Details</th>
                </tr>
                <?php
                	$sql2 = 'SELECT * FROM `Transaction` WHERE `ACCT_ID` IN (SELECT `ACCT_ID` FROM Account WHERE `USER_ID` = '. $_SESSION["USER_ID"] .') ORDER BY `DATETIME` DESC;';
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
            <br>
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php'; ?>
    </body>
</html>