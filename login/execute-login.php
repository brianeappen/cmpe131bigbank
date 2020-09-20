<?php
    session_start();
    
    $errorRet = "";
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
    
    $password = hash('ripemd128', $password);

    $conn = new mysqli("localhost", "bigbankers", "frankbutt!", "bigbank");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT * FROM Users;";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	if(strtolower($row["USER_NAME"]) == strtolower($username)) {
	    	    if($row["USER_PASS"] == $password) {
    	            $_SESSION["USER_NAME"] = $row["USER_NAME"];
    	            $_SESSION["SECURITY_LVL"] = $row["SECURITY_LVL"];
    	            $_SESSION["USER_ID"] = $row["USER_ID"];
    	            $_SESSION["PATRON_FIRST_NAME"] = $row["PATRON_FIRST_NAME"];
    	            $_SESSION["PATRON_LAST_NAME"] = $row["PATRON_LAST_NAME"];
    	            $_SESSION["USER_PIN"] = $row["USER_PIN"];
    	            header('Location: /landing/');
    	            exit;
    	        } else {
    	            $errorRet = "2";
    	            break;
    	        }
	        } else {
	            $errorRet = "1";
	        }
	    }
	} else {
	    $errorRet = "3";
	}
    
    header('Location: /login/?return='.$errorRet);
    exit;
	
    $conn->close();
?>