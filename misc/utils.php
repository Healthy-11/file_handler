<?php

function extractFileName($fileNameInfo) {
    $name = "";
    for ($i = 8; $i < sizeof($fileNameInfo); $i++) {
        if ($i > 8) {
            $name = $name . " " . $fileNameInfo[$i];
        } else {
            $name = $fileNameInfo[$i];
        }
    }
    return $name;
}

function displayDate($month, $day, $hour) {
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

function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}
