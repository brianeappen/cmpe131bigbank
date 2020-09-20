<?php
    session_start();
    
    if(!isset($_SESSION["ATM_USER_ID"])){
        header('Location: /atm/');
    	exit;
    }
    
    //Some variable shit
    $errorRet = "0";
    $doReturn = false;

    //Time to get those form values!
    $withdrawInfo = $_POST["hiddenAmount"];
    $withdrawInfo_arr = explode("::", $withdrawInfo);
    
    $withdrawAmount = $withdrawInfo_arr[0];
    $withdrawAccount = $withdrawInfo_arr[1];
    
    $withdrawAmount  = floatval($withdrawAmount);
    
    
    //Let's connect to a database!
    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	//Let's generate an transaction ID that is unique
	$sql2 = "SELECT TRANS_ID FROM Transaction;";
	$result = $conn->query($sql2);
	$rerun = false;
	$tranID = rand(100000000000000000,999999999999999999);
	if ($result->num_rows > 0) {
	    do{
	        $rerun = false;
    	    $tempResult = $result;
    	    $tranID = rand(100000000000000000,999999999999999999);
    	    while($row = $tempResult->fetch_assoc()) {
    	        echo $tranID . "<br>";
    	    	if($row["TRANS_ID"] == $tranID) {
    	    	    $rerun = true;
    	        }
    	    }
	    } while($rerun);
	} else {
	    //Lol this is the first account, then! Or... something's gone catastrophically wrong.... one of the two.
	    $errorRet = $errorRet . "4";
	}
    
    date_default_timezone_set('America/Los_Angeles');
    $date = date('Y-m-d H:i:s', time());
    echo $date;
    
    $fakepath = "";
    
    //TIME TO GET THIS SHIT IN THE DATABASE
    $insertSQL = $conn->prepare("INSERT INTO `Transaction`(`TRANS_ID`, `ACCT_ID`, `TRANS_AMT`, `IS_DEPOSIT`, `FILEPATH`, `DATETIME`) VALUES (?,?,?,0,?,?);");
    echo $insertSQL->bind_param("iidss", $tranID, $withdrawAccount, $withdrawAmount, $fakepath, $date);
    
    //Damn, better make sure this crap works tho...
    if($insertSQL->execute()){
	    $insertSQL->close();
	    
	    $insertSQL2 = $conn->prepare("UPDATE `Account` SET `BALANCE`=`BALANCE`-? WHERE `ACCT_ID`=?;");
        echo $insertSQL2->bind_param("ds", $withdrawAmount, $withdrawAccount);
        if($insertSQL2->execute()){
            echo "<br>";
            echo "Removed balance successfully!";
            echo "<br>";
            header('Location: /atm/interface/withdraw/success.php');
    	    exit;
        } else{
            echo "<br>";
            echo "Could not remove balance due to a SQL error... lucky you";
            echo "<br>";
            echo "<span style='color: red'> Error: ";
            echo htmlspecialchars($insertSQL2->error);
            $insertSQL2->close();
            echo "</span><br>";
        }
	} else {
	    echo "<br>";
        echo "Could not add new transation due to a SQL error.";
        echo "<br>";
        echo "<span style='color: red'> Error: ";
        echo htmlspecialchars($insertSQL->error);
        $insertSQL->close();
        echo "</span><br>";
	}
    
    $conn->close();
?>