<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>FTP Sender</title>
</head>

<?php
session_start();
if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) {
    header('Location: /');
}
?>

<body>

<div class="file_input">
    <h1>Envoi vers FTP</h1>

    <h3>
        Choisir un ou des fichier(s) :
    </h3>
    <form action="" enctype="multipart/form-data" method="POST">
        <input class="custom-file-input" name="upload[]" type="file" multiple="multiple" accept="application/pdf"/>
        <br/><br/>
        <button type="submit" name="file_sender">
            <span class="button__text">Envoyer</span>
            <i class="button__icon fas fa-chevron-right"></i>
        </button>
    </form>
</div>
</body>
</html>

<?php
if (isset($_POST['file_sender'])) {
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, 'signature@focus.immo', 'signatureDU13');
        ftp_pasv($ftp, true);
        $total = count($_FILES['upload']['name']);
        for ($i = 0; $i < $total; $i++) {
            $file = $_FILES['upload']['tmp_name'][$i];
            $ret = ftp_nb_put($ftp, $_SESSION["code"] . "/toSign/" . $_FILES['upload']['name'][$i], $file, FTP_BINARY, FTP_AUTORESUME);
            while (FTP_MOREDATA == $ret) {
                echo ">";
                $ret = ftp_nb_continue($ftp);
            }
        }
        ftp_close($ftp);
    } catch (Exception $e) {
        echo "Connexion échouée: " . $e->getMessage();
    }
}