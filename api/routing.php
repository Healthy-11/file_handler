<?php

use Slim\Views\PhpRenderer;

include(__DIR__ . "/../models/file_object.php");

$app->get('/login', function ($request, $response) {
    $renderer = new PhpRenderer(__DIR__ . '/../views/');
    return $renderer->render($response, "login.php");
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

$app->get('/download_file', function ($request, $response) {
    if (isset($args['download'])) {
        if (isset($args['dlfileSigned'])) {
            $file_name = $args['dlfileSigned'];
            $remote_folder = "/signed/";
        }
        if (isset($args['dlfileToSign'])) {
            $file_name = $args['dlfileToSign'];
            $remote_folder = "/toSign/";
        }
        if (isset($file_name) && isset($remote_folder)) {
            try {
                $ftp = ftp_connect("focus.immo", 21);
                ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
                ftp_pasv($ftp, true);
                $local_file = "downloaded.pdf";
                if (ftp_get($ftp, $local_file, $_SESSION["code"] . $remote_folder . $file_name, FTP_BINARY)) {
                    $file_new_name = stripAccents(trim($file_name));
                    header("Content-Disposition: attachment; filename=\"" . $file_new_name . '"');
                    readfile($local_file);
                    unlink($local_file);
                }
                ftp_close($ftp);
            } catch (Exception $e) {
                //echo "Connexion échouée: " . $e->getMessage();
            }
        }
    }

    $buff = fetchListFromFTP("signed");
    $files = filesFromList($buff);

    $renderer = new PhpRenderer(__DIR__ . '/../views/', [
        'files' => $files
    ]);
    return $renderer->render($response, "signed.php");
});