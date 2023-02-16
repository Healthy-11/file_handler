<?php
function getResponse($response, $data, $code) {
    $response = $response->withStatus($code);
    $response->getBody()->write($data);
    return $response;
}

function getUserNotFound($response) {
    return getResponse($response, "User not found", 401);
}

function getUserNotFoundKO($response) {
    return getResponse($response, "ko", 401);
}

function getUnauthorized($response) {
    return getResponse($response, "Unauthorized", 401);
}