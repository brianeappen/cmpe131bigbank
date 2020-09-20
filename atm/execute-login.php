<?php
    session_start();
    
    $errorRet = "";
    $password = $_POST["loginpass"];

    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT * FROM Users;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
    	    if(strval($row["USER_PIN"]) == $password) {
	            $_SESSION["ATM_USER_NAME"] = $row["USER_NAME"];
	            $_SESSION["ATM_SECURITY_LVL"] = $row["SECURITY_LVL"];
	            $_SESSION["ATM_USER_ID"] = $row["USER_ID"];
	            $_SESSION["ATM_PATRON_FIRST_NAME"] = $row["PATRON_FIRST_NAME"];
	            $_SESSION["ATM_PATRON_LAST_NAME"] = $row["PATRON_LAST_NAME"];
	            header('Location: /atm/interface/');
	            exit;
	        } else {
	            $errorRet = "2";
	        }
	    }
	} else {
	    $errorRet = "3";
	}
    
    header('Location: /atm/?return='.$errorRet);
    exit;
	
    $conn->close();
?>