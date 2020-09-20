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
	<title>Deposit A Check | Big Bank</title>
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
        <h1 style="text-align: center; padding-top: 1%; font-size: 3em;">Deposit A Check</h1>

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
                <form action="execute-deposit.php" method="POST" id="accountForm" enctype="multipart/form-data">
                    <input type="text" id="depAmt" name="depAmt" placeholder="Deposit Amount ($)" required><br><sup style="margin-left: 49%;">1</sup>
                    <br><br>
                    <select name="depTo" form="accountForm" class="select-css" required>
                        <option value="" selected disabled hidden>Deposit To:</option>
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
                            	        echo '
                            	            <option value="' . $row["ACCT_ID"] . '">'. $row["ACCT_NAME"] .'</option>
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
                        ?>
                    </select>
                    <sup style="margin-left: 49%;">2</sup>
                    <br><hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                    <h3>Upload Check Image</h3>
                    <input type="file" name="fileUp" id="fileUp" class="inputfile" accept="image/*" required><br>
                    <sup style="margin-left: 49%;">3</sup>
                    <br><hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                    <h2>Verify Your Identity</h2>
                    <br>
                    <input type="text" id="loginuser" name="loginuser" placeholder="Username" required>
                    <br><br><br>
                    <input type="password" id="loginpass" name="loginpass" placeholder="Password" required>
                    <br><br><br>
                    <input type="submit" value="Submit">
                </form>
                <br>
                <br>
            </div>
            <div class="signup" style="padding: 0 15px; width: calc(45% - 30px);">
                <h2>FAQ</h2>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <p><sup>1&nbsp;&nbsp;</sup>The dollar amount of the check you're depositing. We'll verify that you put in the right amount, and then add that value
                to your account. We'll also attempt to arrest you, if we think you keep trying to get too much money.</p>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <p><sup>2&nbsp;&nbsp;</sup>Which account you want to deposit your money to. We'd recommend one of our low-APR savings accounts or paying off your
                credit account, but to each their own.</p>
                <hr style="width: 80%; margin-left: 10%; border: 0; height: 2px; background-image: linear-gradient(to right, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.75), rgba(0, 0, 0, 0));">
                <p><sup>3&nbsp;&nbsp;</sup>Upload an image of your check. We accept .png, .jpeg, and .gif file extensions. Please... please make sure it's actually
                an image of your check and not something... else.</p>
                <br>
                <br>
            </div>
        </div>
        <div class="page-content"></div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . '/incl/logged-header-footer.php'; ?>
    </body>
</html>
