<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION["USER_ID"])){
        header('Location: /login/?return=4');
    	exit;
    }
    if(!isset($_GET["transactionid"])){
        header('Location: /landing/?return=4');
    	exit;
    }
    
    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
    $sql2 = 'SELECT * FROM `Transaction` WHERE `TRANS_ID` = ' . $_GET["transactionid"] .';';
	$result = $conn->query($sql2);
	$count = 0;
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
            $TRANSACTION_ID = $_GET["transactionid"];
            $TRANSACTION_AMOUNT = $row["TRANS_AMT"];
            $LINKED_ACCOUNT = $row["ACCT_ID"];
            $IS_DEPOSIT = $row["IS_DEPOSIT"];
            $IMAGE_FILEPATH = $row["FILEPATH"];
            $DATETIME = $row["DATETIME"];
	    }
	} 
	
	$sql3 = 'SELECT `ACCT_NAME` FROM `Account` WHERE `ACCT_ID` = ' . $LINKED_ACCOUNT .';';
	$result3 = $conn->query($sql3);
	$count = 0;
	if ($result3->num_rows > 0) {
	    while($row = $result3->fetch_assoc()) {
            $ACCOUNT_NAME = $row["ACCT_NAME"];
	    }
	} 
	
	$conn->close();
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
</script>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Review Transaction <?php echo $TRANSACTION_ID; ?></h1>
        
        <div class="login-form-div">
            <div class="login">
                <h2>Transaction Information: </h2>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <?php 
                    if($IS_DEPOSIT == "1"){
                        echo '
                            <h3>Amount Deposited</h3>
                            <p>$'.$TRANSACTION_AMOUNT.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Account Deposited To</h3>
                            <p>'.$ACCOUNT_NAME.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Transaction Completed At</h3>
                            <p>'. $DATETIME .'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        ';
                    } else if($IS_DEPOSIT == "0"){
                        echo '
                            <h3>Amount Withdrawn</h3>
                            <p>$'.$TRANSACTION_AMOUNT.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Account Withdrawn From</h3>
                            <p>'.$ACCOUNT_NAME.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Transaction Completed At</h3>
                            <p>'. $DATETIME .'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        ';
                    } else if($IS_DEPOSIT == "3"){
                        echo '
                            <h3>Amount Transferred</h3>
                            <p>$'.$TRANSACTION_AMOUNT.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Account Transferred From</h3>
                            <p>'.$ACCOUNT_NAME.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Transaction Completed At</h3>
                            <p>'. $DATETIME .'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        ';
                    } else if($IS_DEPOSIT == "2"){
                        echo '
                            <h3>Amount Transferred</h3>
                            <p>$'.$TRANSACTION_AMOUNT.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Account Transferred To</h3>
                            <p>'.$ACCOUNT_NAME.'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <h3>Transaction Completed At</h3>
                            <p>'. $DATETIME .'</p>
                            <br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                        ';
                    }
                ?>
                <br>
                <br>
            </div>
            <div class="signup" style="padding: 0 15px; width: calc(45% - 30px);">
                <?php 
                    if($IS_DEPOSIT == "1"){
                        echo '
                            <h2>Image Upload</h2>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <br>
                            <img src="'. $IMAGE_FILEPATH .'" style="width: 60%;">
                            <br><br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <br>
                        ';
                    } else {
                        echo '
                            <h2>Image Upload</h2>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <br>
                            <h3>No Image Uploaded</h3>
                            <br><br>
                            <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                            <br>
                        ';
                    }
                ?>
            </div>
        </div>
        <div class="page-content">
        </div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php'; ?>
    </body>
</html>
