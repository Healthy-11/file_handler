<?php
session_start();
$_SESSION["config"] = json_decode(file_get_contents(".config.json"), true);
header('Location: /views/login.php');
/*
if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) {
    header('Location: /views/login.php');
} else {
    header('location: /views/ftp.php');
}*/