<!doctype html>
<html lang="fr">
<?php require("header.php"); ?>
<body>
<?php
$page = "to_sign";
require("nav.php"); ?>
<div class="sticky">
    <div class="centered">
        <h2 class="whited">Envoi vers FTP</h2>
        <h3 class="whited">
            Choisir un ou des fichier(s) :
        </h3>
        <form action="/controllers/upload_file.php" enctype="multipart/form-data" method="POST">
            <input class="file_dl" name="upload[]" type="file" multiple="multiple"/>
            <button class="dl" name="file_sender" type="submit">Envoyer</button>
        </form>
    </div>
</div>
<div class="wrapper">
    <div class="box">
        <?php
          foreach ($files as $key) {
              $info = explode(" ", preg_replace('/\s+/', ' ', $key));
              if ($info[8] == "." || $info[8] == "..") {
                  continue;
              }
              $name = extractFileName($info);
              $ext = explode(".", $name);
              $end_ext = end($ext);
              ?>
            <div class="tile <?= $end_ext ?>">
                <h3 class="list-h3"><?= preg_replace('/\\.[^.\\s]{3,4}$/', '', $name); ?></h3>
                <p class="list-p"><?= displayDate($info[5], $info[6], $info[7]) ?></p>
                <form class="form_download" method="POST" action="/controllers/download_file.php">
                    <input type="hidden" name="dlfileToSign" value="<?= $name ?>"/>
                    <button class="dl" name="download">Télécharger</button>
                </form>
            </div>
        <?php } ?>
    </div>
</div>
</body>

<?php

if (isset($_GET)) {
    if (isset($_GET["error"])) {
        $error = json_decode($_GET["error"]);
        $done = $type = $exception = $name = 0;
        for ($i = 0; $i < sizeof($error); $i++) {
            if ($error[$i] == $SUCCESS) {
                $done++;
            } else if ($error[$i] == $TYPE_ERROR) {
                $type++;
            } else if ($error[$i] == $ERROR) {
                $exception++;
            } else if ($error[$i] == $NAME_ERROR) {
                $name++;
            }
        }
        if ($done == 1) {
            echo '<script>$.notify("Un fichier téléchargé avec succès", "success");</script>';
        } else if ($done > 1) {
            echo '<script>$.notify("' . $done . ' fichiers téléchargés avec succès", "success");</script>';
        }

        if ($type == 1) {
            echo '<script>$.notify("Type d\'un fichier non supporté", "error");</script>';
        } else if ($type > 1) {
            echo '<script>$.notify("Types de ' . $type . ' fichiers non supportés", "error");</script>';
        }

        if ($exception == 1) {
            echo '<script>$.notify("Téléchargement d\'un fichier échoué", "error");</script>';
        } else if ($exception > 1) {
            echo '<script>$.notify("Téléchargement de ' . $exception . ' fichiers échoué", "error");</script>';
        }

        if ($name == 1) {
            echo '<script>$.notify("Téléchargement d\'un fichier impossible, nom déjà existant", "warn");</script>';
        } else if ($name > 1) {
            echo '<script>$.notify("Téléchargement de ' . $name . ' fichiers impossible, noms déjà existants", "warn");</script>';
        }
    }
    echo '<script>window.history.replaceState({}, document.title, "/" + "to_sign");</script>';
    unset($_GET);
}
