<?php
require_once("api/api.php");
session_start();
$_SESSION["config"] = json_decode(file_get_contents(".config.json"), true);
//header('Location: /views/login.php');
/* REDIRECT TO PAGES IF CONNECTED
if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) {
    header('Location: /views/login.php');
} else {
    header('location: /views/to_sign.php');
}*/