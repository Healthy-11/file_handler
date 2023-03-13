<?php
function displayDate($month, $day, $hour): string
{
    switch ($month) {
        case ("Jan"):
            $month = "janvier";
            break;
        case ("Feb"):
            $month = "février";
            break;
        case ("Mar"):
            $month = "mars";
            break;
        case ("Avr"):
            $month = "avril";
            break;
        case ("May"):
            $month = "mai";
            break;
        case ("Jun"):
            $month = "juin";
            break;
        case ("Jul"):
            $month = "juillet";
            break;
        case ("Aug"):
            $month = "août";
            break;
        case ("Sep"):
            $month = "septembre";
            break;
        case ("Oct"):
            $month = "octobre";
            break;
        case ("Nov"):
            $month = "novembre";
            break;
        case ("Dec"):
            $month = "décembre";
            break;
    }
    return $day . " " . $month . " à " . $hour;
}

function stripAccents($str): string
{
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function fetchListFromFTP($folder)
{
    $ftp = ftp_connect("focus.immo", 21);
    ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
    ftp_pasv($ftp, true);
    $buff = ftp_rawlist($ftp, $_SESSION["code"] . "/" . $folder . "/");
    ftp_close($ftp);
    return $buff;
}

function filesFromList($buff): array
{
    $files = [];
    foreach ($buff as $key):
        $info = explode(" ", preg_replace('/\s+/', ' ', $key));
        if ($info[8] == "." || $info[8] == "..") {
            continue;
        }
        $name = "";
        for ($i = 8; $i < sizeof($info); $i++) {
            if ($i > 8) {
                $name = $name . " " . $info[$i];
            } else {
                $name = $info[$i];
            }
        }
        $date = displayDate($info[5], $info[6], $info[7]);
        $ext = explode(".", $name);
        $type = end($ext);

        $file_object = new FileObject($name, $type, $date);
        $files[] = $file_object;
    endforeach;
    return $files;
}

function notifyErrors($error)
{
    $done = 0;
    $type = 0;
    $exception = 0;
    $name = 0;
    for ($i = 0; $i < sizeof($error); $i++) {
        if ($error[$i] == SUCCESS) {
            $done++;
        } else if ($error[$i] == WRONG_TYPE) {
            $type++;
        } else if ($error[$i] == EXCEPTION) {
            $exception++;
        } else if ($error[$i] == ALREADY_EXISTS) {
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