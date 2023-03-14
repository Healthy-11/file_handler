<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

session_start();
$_SESSION["config"] = json_decode(file_get_contents(".config.json"), true);

require_once(__DIR__ . "/../utils/db.php");
require_once(__DIR__ . "/../utils/responses.php");
require_once(__DIR__ . "/../utils/functions.php");
require_once("routing.php");
require_once("user.php");

$app->get('/', function () {
    header('Location: /login');
});

$app->get('/root', function (Request $request, Response $response) {
    return getResponse($response, "Root", 200);
});

$app->run();