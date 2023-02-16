<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

function userExists(Request $request): bool
{
    $auth = $request->getHeader('Authorization');
    $basic = explode(":", base64_decode(explode(" ", $auth[0])[1]));
    $username = $basic[0];
    $password = $basic[1];
    $stmt = db()->query("SELECT * FROM users WHERE username = '" . $username . "'");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($res) {
        if (password_verify($password, $res["password"])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

$app->get('/api/check_user', function (Request $request, Response $response, $args) {
    if (userExists($request)) {
        return getResponse($response, "ok", 200);
    } else {
        return getUserNotFoundKO($response);
    }
});

$app->post('/api/create_user', function (Request $request, Response $response) {
    if (userExists($request)) {
        $data = $request->getParsedBody();
        $username = $data["username"];
        $checkExist = db()->query("SELECT * FROM users WHERE username='" . $username . "' LIMIT 1");
        if ($checkExist) {
            if (json_encode($checkExist->fetchAll(PDO::FETCH_ASSOC)) == '[]') {
                $encrypted = password_hash($data["password"], PASSWORD_DEFAULT);
                $code = $data["code"];
                $query = "INSERT INTO users (username, password, code) VALUES ('" . $username . "', '" . $encrypted . "', '" . $code . "')";
                $stmt = db()->query($query);
                if ($stmt) {
                    $response = getResponse($response, 'User created', 200);
                } else {
                    $response = getResponse($response, "Problem encountered", 409);
                }
            } else {
                $response = getResponse($response, "Username already exists", 409);
            }
        } else {
            $response = getResponse($response, "Existing check failed", 409);
        }
        return $response;
    } else {
        return getUserNotFound($response);
    }
});