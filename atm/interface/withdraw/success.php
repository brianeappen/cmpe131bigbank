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
	<title>Withdraw Successful | ATM | Big Bank</title>
	<link rel="stylesheet" href="/atm/css/atm.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="/favicon.png">
	<style>
        #nameHeader {
            -webkit-animation: fadeInFromNone 1s ease-out;
            -moz-animation: fadeInFromNone 1s ease-out;
            -o-animation: fadeInFromNone 1s ease-out;
            animation: fadeInFromNone 1s ease-out;
            text-align: center;
        }
        
        #subHeader {
            -webkit-animation: fadeInFromNone 2s ease-out 0.7s forwards;
            -moz-animation: fadeInFromNone 2s ease-out 0.7s forwards;
            -o-animation: fadeInFromNone 2s ease-out 0.7s forwards;
            animation: fadeInFromNone 2s ease-out 0.7s forwards;
            text-align: center;
        }
        
        @-webkit-keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }
        
            1% {
                display: block;
                opacity: 0;
            }
        
            100% {
                display: block;
                opacity: 1;
            }
        }
        
        @-moz-keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }
        
            1% {
                display: block;
                opacity: 0;
            }
        
            100% {
                display: block;
                opacity: 1;
            }
        }
        
        @-o-keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }
        
            1% {
                display: block;
                opacity: 0;
            }
        
            100% {
                display: block;
                opacity: 1;
            }
        }
        
        @keyframes fadeInFromNone {
            0% {
                display: none;
                opacity: 0;
            }
        
            1% {
                display: block;
                opacity: 0;
            }
        
            100% {
                display: block;
                opacity: 1;
            }
        }
	</style>
</head>
<script>

</script>
<body>
        <div class="banner">
            <div class="banner-img">
            </div>
            <div class="banner-content">
            </div>
        </div>
        <?php
            echo '
                    <div style="margin-top: 15%;"></div>
                    <div id="welcomeText">
                        <h1 id="nameHeader">Please Take Your Money Below...</h1>
                        <h3 id="subHeader" style="opacity: 0">(If only it were real...)</h3>
                    </div>
                    ';
                    echo '
    		        <script>
                        setTimeout(function(){ window.location.replace("/atm/interface/"); }, 3000);
    		        </script>
		        ';
        ?>
        <div class="footer" id="footer-element">
            <br>
            <div class="sub-footer">
                <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
            </div>
        </div>
    </body>
</html>