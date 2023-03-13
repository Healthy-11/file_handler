<!doctype html>
<html lang="fr">
<?php require("header.php");

?>
<body>
<?php
$page = "to_sign";
require("nav.php");

?>
<div class="sticky">
    <div class="centered">
        <h2 class="whited">Envoi vers FTP</h2>
        <h3 class="whited">
            Choisir un ou des fichier(s) :
        </h3>
        <form action="/views/upload_file.php" enctype="multipart/form-data" method="POST">
            <input class="file_dl" name="upload[]" type="file" multiple="multiple"/>
            <button class="dl" name="file_sender" type="submit">Envoyer</button>
        </form>
    </div>
</div>
<div class="wrapper">
    <div class="box">
        <?php
        foreach ($files as $file):
            $ext = explode(".", $file->getName());
            $end_ext = end($ext);
            ?>
            <div class="tile <?= $end_ext ?>">
                <h3 class="list-h3"><?= preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->getName()); ?></h3>
                <p class="list-p"><?= $file->getDate() ?></p>
                <form class="form_download" method="POST" action="/views/download_file.php">
                    <input type="hidden" name="dlfileToSign" value="<?= $file->getName() ?>"/>
                    <button class="dl" name="download">Télécharger</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>

<?php
if (isset($_GET)) {
    if (isset($_GET["error"])) {
        $error = json_decode($_GET["error"]);
        notifyErrors($error);
    }
    echo '<script>window.history.replaceState({}, document.title, "/" + "to_sign");</script>';
    unset($_GET);
}