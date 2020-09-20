<?php
    session_start();
    unset($_SESSION['ATM_USER_ID']);
    header('Location: /atm/');
    exit;
?>