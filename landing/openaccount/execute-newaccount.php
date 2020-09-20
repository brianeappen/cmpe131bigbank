<?php
    session_start();
    
    //If the user isn't logged in anymore, we don't wanna let them create an account
    if(!isset($_SESSION["USER_ID"])){
        header('Location: /login/?return=4');
    	exit;
    }
    
    //Some variable shit
    $errorRet = "0";
    $doReturn = false;

    //Time to get those form values!
    $accountName = $_POST["acctname"];
    $accountType = $_POST["accttype"];
    $username = $_POST["loginuser"];
    $password = $_POST["loginpass"];

    //Rehash dat password for comparison against the db
    $password = hash('ripemd128', $password);
    
    //Let's connect to a database!
    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
    
    //Damn, let's make sure this person is who they say they are
    $sql = "SELECT * FROM Users;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        echo "______________________<br>";
	        echo strtolower($row["USER_NAME"]);
	        echo " vs. ";
	        echo strtolower($username);
	        echo "<br>";
	    	if(strtolower($row["USER_NAME"]) == strtolower($username)) {
	    	    echo "YES!<br>";
	    	    $errorRet = 0;
	    	    $doReturn = false;
	    	    if($row["USER_PASS"] == $password) {
                    //They are who they say they are!
                    break;
    	        } else {
    	            //Password is wrong... hmmmmmm....
    	            $doReturn = true;
    	            $errorRet = "2";
    	            break;
    	        }
	        } else {
	            //Username not found, buddy
	            $doReturn = true;
	            $errorRet = "1";
	        }
	    }
	} else {
	    //Aint no users in dat database, my friend
	    $errorRet = "3";
	}
	
	echo $errorRet;
    echo "<br>";
	
	//It'd waste computational resources to continue. If there's something already wrong, just chuck the whole thing out the window.
	if($doReturn){
        header("Location: ./?return=" . $errorRet);
        exit;
    }
	
	//Let's generate an account ID that is unique
	$sql2 = "SELECT ACCT_ID FROM Account;";
	$result = $conn->query($sql2);
	$rerun = false;
	$acctID = rand(1000000000000000,9999999999999999);
	if ($result->num_rows > 0) {
	    do{
	        $rerun = false;
    	    $tempResult = $result;
    	    $acctID = rand(1000000000000000,9999999999999999);
    	    while($row = $tempResult->fetch_assoc()) {
    	        echo $acctID . "<br>";
    	    	if($row["ACCT_ID"] == $acctID) {
    	    	    $rerun = true;
    	        }
    	    }
	    } while($rerun);
	} else {
	    //Lol this is the first account, then! Or... something's gone catastrophically wrong.... one of the two.
	    $errorRet = $errorRet . "4";
	}
    
    //TIME TO GET THIS SHIT IN THE DATABASE
    $insertSQL = $conn->prepare("INSERT INTO `Account`(`ACCT_ID`, `USER_ID`, `BALANCE`, `ACCT_NAME`, `ACCT_TYPE`) VALUES (?,?,0.00,?,?);");
    echo $insertSQL->bind_param("iiss", $acctID, $_SESSION["USER_ID"], $accountName, $accountType);
    
    //Damn, better make sure this crap works tho...
    if($insertSQL->execute()){
	    $insertSQL->close();
	    echo "<br>";
        echo "Added new account successfully!";
        echo "<br>";
        header('Location: /landing/');
	    exit;
	} else {
	    echo "<br>";
        echo "Could not add new account due to a SQL error.";
        echo "<br>";
        echo $acctID;
        echo "<br>";
        echo "<span style='color: red'> Error: ";
        echo htmlspecialchars($insertSQL->error);
        $insertSQL->close();
        echo "</span><br>";
	}
    
    $conn->close();
?>