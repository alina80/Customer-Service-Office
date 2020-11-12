<?php
session_start();
if (!empty($_SESSION)){
    unset($_SESSION['id']);
    unset($_SESSION['login']);
}

header('Location: LoginController.php');
exit;