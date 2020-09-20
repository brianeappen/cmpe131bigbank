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
	<title>Account Information | ATM | Big Bank</title>
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
        <a class="backLink" href="../">
            <div class="backButton">
                <h3>< Back</h3>
            </div>
        </a>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Your Accounts</h1>
        <div class="account-column">
            <?php
                //Let's connect to a database!
                $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
            	if ($conn->connect_error) {
            		die("Connection failed: " . $conn->connect_error);
            	}
            	$atmpin = $_SESSION["ATM_USER_ID"];
            	
            	//Let's generate an account ID that is unique
            	$sql2 = "SELECT * FROM Account WHERE `IS_ACTIVE`=1 ORDER BY `BALANCE` DESC;";
            	$result = $conn->query($sql2);
            	$count = 0;
            	if ($result->num_rows > 0) {
            	    while($row = $result->fetch_assoc()) {
            	        if($row["USER_ID"] == $atmpin){
            	            $count++;
                	        if($row["ACCT_TYPE"] == "0"){
                	            $acct = "Credit";
                	        } else if($row["ACCT_TYPE"] == "1") {
                	            $acct = "Checking";
                	        } else if($row["ACCT_TYPE"] == "2"){
                	            $acct = "Savings";
                	        }
                	        echo '
                	            <a href="#">
                                    <div class="account-obj">
                                        <!--hr-->
                                        <h1>'.$row["ACCT_NAME"].'</h1>
                                        <p>$'.round(floatval ($row["BALANCE"]),2).'</p>
                                        <p style="text-align: initial; left: 15px !important;  bottom: 5px;">'. $acct .'</p>
                                    </div>
                                </a>
                	        ';
            	        }
            	    }
            	    if($count != 0){ /* If there's accounts, do this */ }
            	} 
            	if($count == 0){
            	    echo '<h5 style="text-align: center;">Hmm... it doesn\'t look like you have any accounts.</h5>';
            	}
            ?>
        </div>
        <div class="footer" id="footer-element">
            <br>
            <div class="sub-footer">
                <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
            </div>
        </div>
    </body>
</html>