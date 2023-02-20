<?php
use Slim\Views\PhpRenderer;

$app->get('/login', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "login.php");
});

$app->get('/logout', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "logout.php");
});

$app->get('/to_sign', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "to_sign.php");
});

$app->get('/signed', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "signed.php");
});