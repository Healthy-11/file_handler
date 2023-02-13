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

if (isset($_POST['file_sender'])) {
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
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
        //echo "Connexion échouée: " . $e->getMessage();
    }
}
if (isset($_POST['download']) && isset($_POST['dlfile'])) {
    $file_name = $_POST['dlfile'];
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $file = "tets.pdf";
        $fp = fopen($file, 'w');
        if (ftp_nb_fget($ftp, $fp, $_SESSION["code"] . "/signed/" . $file_name, FTP_BINARY)) {
            echo "Successfully written to $file\n";
        } else {
            echo "There was a problem\n";
        }
        ftp_close($ftp);
    } catch (Exception $e) {
        //echo "Connexion échouée: " . $e->getMessage();
    }
}
?>

<body>
<div>
    <h1>Envoi vers FTP</h1>

    <h3>
        Choisir un ou des fichier(s) :
    </h3>
    <form action="" enctype="multipart/form-data" method="POST">
        <input name="upload[]" type="file" multiple="multiple" accept="application/pdf"/>
        <br/><br/>
        <button type="submit">
            <span>Envoyer</span>
        </button>
    </form>
</div>
<br>
<form method="post">
    <?php
    $ftp = ftp_connect("focus.immo", 21);
    ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
    ftp_pasv($ftp, true);
    $buff = ftp_rawlist($ftp, $_SESSION["code"] . "/signed/");
    ftp_close($ftp);
    foreach ($buff as $key): ?>
        <?php $info = explode(" ", preg_replace('/\s+/', ' ', $key));
        if ($info[8] == "." || $info[8] == "..") {
            continue;
        }
        ?>
        <div class="tile">
            <h3 class="list-h3"><?= $info[8] ?></h3>
            <p class="list-p"><?= $info[5] . " " . $info[6] . " " . $info[7] ?></p>
            <p class="list-p"><?= $info[4] . " B" ?></p>
            <input type="hidden" name="dlfile" value="<?= $info[8] ?>"/>
            <input type="submit" name="download" value="Download"/>
        </div>
    <?php endforeach; ?>
    <form>
</body>
</html>