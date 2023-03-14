<?php
function db(): ?PDO
{
    static $db = null;
    if (null === $db)
        $db = new PDO('mysql:host=localhost;dbname=' . $_SESSION["config"]['db_name'], $_SESSION["config"]['db_username'], $_SESSION["config"]['db_password']);
    return $db;
}