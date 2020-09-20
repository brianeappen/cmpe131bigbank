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
    $depositAmount = $_POST["depAmt"];
    $depositTo = $_POST["depTo"];
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
	            //Username not found, buddy
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
	
    echo "<h3>From File Upload: </h3>";
    echo "Filename: ";
    $file_name = $_FILES['fileUp']['name'];
    echo $file_name;
    echo "<br>";
    echo "Temp file location: ";
    $file_tmp = $_FILES['fileUp']['tmp_name'];
    echo $file_tmp;
    echo "<br>";
    echo "Target directory: ";
    $target_dir = "../../img/check-uploads/";
    $db_dir = "/img/check-uploads/";
    echo $target_dir;
    echo "<br>";
    echo "Extension of upload: ";
    $imageFileType = strtolower(end(explode(".", $file_name)));
    echo $imageFileType;
    echo "<br>";
    echo "Target filepath: ";
    $target_file = $target_dir . $tranID . "." . $imageFileType;
    $target_db = $db_dir . $tranID . "." . $imageFileType;
    echo $target_file;
    $upload = 1;
    echo "<br>";
    echo "Verification: ";
    $check = getimagesize($file_tmp);

    if($check !== false) {
        $upload = 1;
    } else {
        $upload = 0;
    }
    
    echo $upload;
    echo "<br>";
    
    if ($upload == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            echo "Upload Success.";
        } else {
            echo "Error Uploading.";
        }
    }
    
    date_default_timezone_set('America/Los_Angeles');
    $date = date('Y-m-d h:i:s', time());
    echo $date;
    
    //TIME TO GET THIS SHIT IN THE DATABASE
    $insertSQL = $conn->prepare("INSERT INTO `Transaction`(`TRANS_ID`, `ACCT_ID`, `TRANS_AMT`, `IS_DEPOSIT`, `FILEPATH`, `DATETIME`) VALUES (?,?,?,1,?,?);");
    echo $insertSQL->bind_param("iidss", $tranID, $depositTo, $depositAmount, $target_db, $date);
    
    //Damn, better make sure this crap works tho...
    if($insertSQL->execute()){
	    $insertSQL->close();
	    
	    $insertSQL2 = $conn->prepare("UPDATE `Account` SET `BALANCE`=`BALANCE`+? WHERE `ACCT_ID`=?;");
        echo $insertSQL2->bind_param("ds", $depositAmount, $depositTo);
        if($insertSQL2->execute()){
            echo "<br>";
            echo "Added balance successfully!";
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