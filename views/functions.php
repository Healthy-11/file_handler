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