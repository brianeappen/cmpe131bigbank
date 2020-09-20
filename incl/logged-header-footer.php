<?php
    if(session_id() == ''){
        session_start();
    }
    echo '
        <div class="main-header" id="header">
            <ul>
                <div class="dropdown">
                    <button class="dropbtn" id="dropper"><span style="font-size: 0.7em;">&#9660;</span> ' . $_SESSION["PATRON_FIRST_NAME"] . " " . $_SESSION["PATRON_LAST_NAME"]  . '</button>
                    <div class="dropdown-content">
                        <a href="#">'.$_SESSION["USER_NAME"].'</a>
                        <a href="/landing/">My Accounts</a>
                        <a href="/landing/transfer-balance/">Transfer Money</a>
                        <a href="/landing/deposit-check/">Deposit A Check</a>
                        <a href="/landing/#TRANSACTIONS_SECTION">Transaction History</a>
                        <a href="/logout/">Log Out</a>
                    </div>
                </div>
                <!--li><a href="/landing/transfer-balance/">Transfer Money</a></li>
                <li><a href="/landing/deposit-check/">Deposit A Check</a></li-->
                <li><a href="/atm/">Visit ATM</a></li>
                <li style="float: left !important;"><a href="/">Big Bank Corp.</a></li>
            </ul>
        </div>
        <div class="footer">
            <div class="main-footer">
                    <div class="elem1">
                        <h2>Navigation</h2>
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="/landing/">My Accounts and Transactions</a></li>
                            <li><a href="/atm/">Visit the ATM</a></li>
                            <li><a href="#">My Profile</a></li>
                            <li><a href="/logout/">Log Out</a></li>
                        </ul>
                    </div>
                    <div class="elem2">
                        <h2>Our Address</h2>
                        <p>1234 Banking Blvd.<br>Brokersville, BA 51352</p>
                    </div>
                    <div class="elem3">
                        <h2>Support and Credits</h2>
                        <ul>
                            <li><a href="#">Web Support</a></li>
                            <li><a href="#">Web Source Credits</a></li>
                        </ul>
                    </div>
                </div>
                <br>
                <div class="sub-footer">
                    <span>Software Engineering 1 Fall 2019 | Group 1 | Richard Arcangel, Jarod Coquioco, Francis Cunanan, 
                    Brian Eappen, Andrew Fong, Gregory Galvan, Melody Gilani, Rui Zhu</span>
                </div>
            </div>
        </div>
    ';
?>