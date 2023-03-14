<!doctype html>
<html lang="fr">
<?php
require("header.php");
$page = "signed";
?>

<body>
<?php
require("nav.php") ?>
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
                <form class="form_download" method="POST" action="/controllers/download_file.php">
                    <input type="hidden" name="dlfileSigned" value="<?= $file->getName() ?>"/>
                    <button class="dl" name="download">Télécharger</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>