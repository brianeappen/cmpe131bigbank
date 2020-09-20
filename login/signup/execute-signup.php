<?php
    session_start();
    $errorRet = "";
    $doReturn = false;
    
    
    if(isset($_POST["userfirst"])){
        $firstName = $_POST["userfirst"];
    } else {
        $firstName = "";
    }
    if(isset($_POST["userlast"])){
        $lastName = $_POST["userlast"];
    } else {
        $lastName = "";
    }
    if(isset($_POST["loginuser"])){
        $username = $_POST["loginuser"];
    } else {
        $username = "";
    }
    if(isset($_POST["loginpass"])){
        $password = $_POST["loginpass"];
    } else {
        $password = "";
    }
    if(isset($_POST["loginpass2"])){
        $passwordCheck = $_POST["loginpass2"];
    } else {
        $passwordCheck = "";
    }
    
    /*
    $firstName = $_POST["userfirst"];
    $lastName = $_POST["userlast"];
    $username = $_POST["loginuser"];
    $password = $_POST["loginpass"];
    $passwordCheck = $_POST["loginpass2"];
    */
    
    //Post-submission verification that passwords match
    if(strcmp($password, $passwordCheck) == 0){
    } else {
        $errorRet = "1";
        $doReturn = true;
    }
    
    $username = strtolower($username);
    $password = hash('ripemd128', $password);
    
    if($doReturn){
        header("Location: ./?return=" . $errorRet);
        exit;
    }
    
    //Post-submission verification that username is free and user ID generation is unique
    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT USER_ID, USER_NAME FROM Users;";
	$result = $conn->query($sql);
	$rerun = false;
	$userID = rand(1000000000,9999999999);
	$userPIN = rand(100000,999999);
	if ($result->num_rows > 0) {
	    do{
	        $rerun = false;
    	    $tempResult = $result;
    	    $userID = rand(1000000000,9999999999);
    	    while($row = $tempResult->fetch_assoc()) {
    	        echo $userID . "<br>";
    	    	if($row["USER_ID"] == $userID) {
    	    	    $rerun = true;
    	        }
    	        if(strtolower($row["USER_NAME"]) == strtolower($username)) {
    	            $rerun = false;
    	            $errorRet = "2";
    	            $doReturn = true;
    	        }
    	    }
	    } while($rerun);
	} else {
	    $errorRet = $errorRet . "3";
	}
    
    if($doReturn){
        header("Location: ./?return=" . $errorRet);
        exit;
    }
    
    //If verification returns all good
    echo "ALL GOOD!";
    echo "<br>Username: ";
    echo $username;
    echo "<br>Password (Hashed): ";
    echo $password;
    echo "<br>User ID (KEY): ";
    echo (int)$userID;
    echo "<br>Patron Name: ";
    echo $firstName . " " . $lastName;
    echo "<br>User Pin: ";
    echo $userPIN;
    echo "<br>";
    
    $insertSQL = $conn->prepare("INSERT INTO `Users`(`USER_ID`, `USER_NAME`, `USER_PASS`, `USER_PIN`, `PATRON_FIRST_NAME`, `PATRON_LAST_NAME`, `SECURITY_LVL`) VALUES (?,?,?,?,?,?,0)");
    echo $insertSQL->bind_param("ississ", $userID, $username, $password, $userPIN, $firstName, $lastName);
    
    if($insertSQL->execute()){
	    $insertSQL->close();
	    echo "<br>";
        echo "Added new user successfully!";
        echo "<br>";
        header('Location: /login/');
	    exit;
	} else {
	    echo "<br>";
        echo "Could not add new user due to a SQL error.";
        echo "<br>";
        echo $userID;
        echo "<br>";
        echo "<span style='color: red'> Error: ";
        echo htmlspecialchars($insertSQL->error);
        $insertSQL->close();
        echo "</span><br>";
	}
	
    $conn->close();
?>