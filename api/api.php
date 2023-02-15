<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();


session_start();
$_SESSION["config"] = json_decode(file_get_contents(".config.json"), true);
function db()
{
    static $db = null;
    if (null === $db)
        $db = new PDO('mysql:host=localhost;dbname=' . $_SESSION["config"]['db_name'], $_SESSION["config"]['db_username'], $_SESSION["config"]['db_password']);
    return $db;
}

require_once("utils.php");

$app->get('/root', function (Request $request, Response $response) {
    return getResponse($response, "Root", 200);
});

$app->get('/check_user', function (Request $request, Response $response, $args) {
    $auth = $request->getHeader('Authorization');
    $basic = explode(":", base64_decode(explode(" ", $auth[0])[1]));
    $username = $basic[0];
    $password = $basic[1];
    $stmt = db()->query("SELECT password FROM users WHERE username = '" . $username . "'");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($res) {
        if (password_verify($password, $res["password"])) {
            return getResponse($response, "ok", 200);
        } else {
            return getUserNotFoundKO($response);
        }
    } else {
        return getUserNotFoundKO($response);
    }
});

$app->get('/login', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/views/');
    var_dump($renderer);
    return $renderer->render($response, "login.php");
});

$app->run();