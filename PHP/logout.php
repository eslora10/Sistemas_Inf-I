<?php
session_start();
if(isset($_SESSION['nick'])){
    unset($_SESSION['nick']);
    unset($_SESSION['saldo']);
    unset($_SESSION['email']);
    if(isset($_SESSION['from_basket']))
        unset($_SESSION['from_basket']);
    session_destroy();
}
header("Location: login.php");
?>
