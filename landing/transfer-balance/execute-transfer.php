<?php
    session_start();
    
    //If the user isn't logged in anymore, we don't wanna let them create an account
    if(!isset($_SESSION["USER_ID"])){
        header('Location: /login/?return=4');
    	exit;
    }
    
    /*************************************************************************************/
    //Some variable shit
    
    $errorRet = "0";
    $doReturn = false;

    //Time to get those form values!
    if(isset($_POST["depAmt"])){
        $transAmount = $_POST["depAmt"]; //COMES FROM TRANSFER TO ANOTHER ACCOUNT
    } else {
        $transAmount = $_POST["payAmt"]; //COMES FROM THE DEBT FORM
    }
    
    if(isset($_POST["depAmt"])){
        //TRANSFER TO ANOTHER ACCOUNT SHIT
        $withFrom = $_POST["depFrom"];
        $depositTo = $_POST["depTo"];
    } else {
        //DEBT SHIT
        $withFrom = $_POST["debtFrom"];
        $depositTo = $_POST["payTo"];
    }
    
    //SHOULD BE SUBMITTED EITHER WAY
    $username = $_POST["loginuser"];
    $password = $_POST["loginpass"];

    //Rehash dat password for comparison against the db
    $password = hash('ripemd128', $password);
    
    /*************************************************************************************/
    //Let's connect to a database!
    /*************************************************************************************/
    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
    
    /*************************************************************************************/
    //Damn, let's make sure this person is who they say they are
    /*************************************************************************************/
    $sql = "SELECT * FROM Users;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	if(strtolower($row["USER_NAME"]) == strtolower($username)) {
	    	    if($row["USER_PASS"] == $password) {
	    	        $errorRet = 0;
	    	        $doReturn = false;
                    //They are who they say they are!
                    break;
    	        } else {
    	            //Password is wrong... hmmmmmm....
    	            $doReturn = true;
    	            $errorRet = "2";
    	            break;
    	        }
	        } else {
	            //Username not found, bud.
	            $doReturn = true;
	            $errorRet = "1";
	        }
	    }
	} else {
	    //Aint no users in dat database, my friend
	    $errorRet = "3";
	}
	
	//It'd waste computational resources to continue. If there's something already wrong, just chuck the whole thing out the window.
	if($doReturn){
        header("Location: ./?return=" . $errorRet);
        exit;
    }
	
	/*************************************************************************************/
	//Let's generate a deposit ID that is unique
	/*************************************************************************************/
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
	    $errorRet = $errorRet . "4";
	}
	
	//Let's generate a withdraw transaction ID that is unique
	$tranID2 = rand(100000000000000000,999999999999999999);
	if ($result->num_rows > 0) {
	    do{
	        $rerun = false;
    	    $tempResult = $result;
    	    $tranID2 = rand(100000000000000000,999999999999999999);
    	    while($row = $tempResult->fetch_assoc()) {
    	        echo $tranID2 . "<br>";
    	    	if($row["TRANS_ID"] == $tranID) {
    	    	    $rerun = true;
    	        }
    	    }
	    } while($rerun);
	} else {
	    $errorRet = $errorRet . "4";
	}
    
    date_default_timezone_set('America/Los_Angeles');
    $date = date('Y-m-d H:i:s', time());
    echo $date;
    
    $target_db = "";
    
    /*************************************************************************************/
    /*************************************************************************************/
    /*************************************************************************************/
    
    //TIME TO GET THIS SHIT IN THE DATABASE
    $insertSQL = $conn->prepare("INSERT INTO `Transaction`(`TRANS_ID`, `ACCT_ID`, `TRANS_AMT`, `IS_DEPOSIT`, `FILEPATH`, `DATETIME`) VALUES (?,?,?,3,?,?);");
    echo $insertSQL->bind_param("iidss", $tranID2, $withFrom, $transAmount, $target_db, $date);
    
    //Damn, better make sure this crap works tho...
    if($insertSQL->execute()){
	    $insertSQL->close();
	    
	    $insertSQL2 = $conn->prepare("INSERT INTO `Transaction`(`TRANS_ID`, `ACCT_ID`, `TRANS_AMT`, `IS_DEPOSIT`, `FILEPATH`, `DATETIME`) VALUES (?,?,?,2,?,?);");
        echo $insertSQL2->bind_param("iidss", $tranID, $depositTo, $transAmount, $target_db, $date);
        if($insertSQL2->execute()){
            $insertSQL2->close();
            
            $insertSQL3 = $conn->prepare("UPDATE `Account` SET `BALANCE`=`BALANCE`-? WHERE `ACCT_ID`=?;");
            echo $insertSQL3->bind_param("ds", $transAmount, $withFrom);
            if($insertSQL3->execute()){
                $insertSQL3->close();
                
                $insertSQL4 = $conn->prepare("UPDATE `Account` SET `BALANCE`=`BALANCE`+? WHERE `ACCT_ID`=?;");
                echo $insertSQL4->bind_param("ds", $transAmount, $depositTo);
                if($insertSQL4->execute()){
                    $insertSQL4->close();
                    echo "<br>";
                    echo "Redid balance successfully!";
                    echo "<br>";
                    header('Location: /landing/#TRANSACTIONS_SECTION');
            	    exit;
                } else{
                    echo "<br>";
                    echo "Could not add balance due to a SQL error.";
                    echo "<br>";
                    echo "<span style='color: red'> Error: ";
                    echo htmlspecialchars($insertSQL2->error);
                    $insertSQL2->close();
                    echo "</span><br>";
                }
            } else{
                echo "<br>";
                echo "Could not withdraw balance due to a SQL error.";
                echo "<br>";
                echo "<span style='color: red'> Error: ";
                echo htmlspecialchars($insertSQL2->error);
                $insertSQL2->close();
                echo "</span><br>";
            }
        } else{
            echo "<br>";
            echo "Could not add new transaction due to a SQL error.";
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