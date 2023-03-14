<?php

use Slim\Views\PhpRenderer;

include(__DIR__ . "/../models/file_object.php");

$app->get('/login', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "login.php");
});

$app->post('/get_login', function ($request, $response) {
    session_start();
    $data = $request->getParsedBody();
    $error = false;
    require_once(__DIR__ . "/../utils/db.php");
    if (isset($data['submit'])) {
        $username = $data['username'];
        $password = $data['password'];
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
                    return $response->withStatus(200)->withHeader('Location', '/to_sign');
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
    }
    return $response->withStatus(200)->withHeader('Location', '/login?error=true');
});

$app->get('/logout', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "logout.php");
});

$app->get('/to_sign', function ($request, $response) {
    $buff = fetchListFromFTP("toSign");
    $files = filesFromList($buff);

    $renderer = new PhpRenderer(__DIR__ . '/../views/', [
        'files' => $files
    ]);
    return $renderer->render($response, "to_sign.php");
});

$app->get('/signed', function ($request, $response) {
    $buff = fetchListFromFTP("signed");
    $files = filesFromList($buff);

    $renderer = new PhpRenderer(__DIR__ . '/../views/', [
        'files' => $files
    ]);
    return $renderer->render($response, "signed.php");
});