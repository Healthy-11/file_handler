<?php
session_start();
$error = false;
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $query = "SELECT password, code FROM users WHERE username = '" . $username . "'";
        $query_res = db()->query($query);
        $res = $query_res->fetch();
        if ($res) {
            $pass = $res[0];
            $code = $res[1];
            if (password_verify($password, $pass)) {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                $_SESSION["code"] = $code;
                header("Location: /to_sign");
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    } catch (PDOException $e) {
        $error = true;
        //echo "Connexion échouée: " . $e->getMessage();
    }
} else {
    $error = true;
}

if ($error) {
    $_SESSION["username"] = "";
    $_SESSION["password"] = "";
    $_SESSION["code"] = "";
    header("Location: /login?error=true");
}