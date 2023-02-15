<?php
session_start();
if (isset($_POST['download']) && isset($_POST['dlfile'])) {
    $file_name = $_POST['dlfile'];
    try {
        $ftp = ftp_connect("focus.immo", 21);
        ftp_login($ftp, $_SESSION["config"]['ftp_username'], $_SESSION["config"]['ftp_password']);
        ftp_pasv($ftp, true);
        $local_file = "downloaded.pdf";
        if (ftp_get($ftp, $local_file, $_SESSION["code"] . "/signed/" . $file_name, FTP_BINARY)) {
            $file_new_name = $file_name;
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename=\"" . $file_new_name . '"');
            readfile($local_file);
        }
        ftp_close($ftp);

    } catch (Exception $e) {
        //echo "Connexion échouée: " . $e->getMessage();
    }
}
?>

<body>
<?php require("nav.php") ?>
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
    $name = "";
    for ($i = 8; $i < sizeof($info); $i++) {
        if ($i > 8) {
            $name = $name . " " . $info[$i];
        } else {
            $name = $info[$i];
        }
    }
    ?>
    <div class="tile">
        <h3 class="list-h3"><?= $name ?></h3>
        <p class="list-p"><?= $info[5] . " " . $info[6] . " " . $info[7] ?></p>
        <p class="list-p"><?= $info[4] . " B" ?></p>
        <form method="POST" action="">
            <input type="hidden" name="dlfile" value="<?= $name ?>"/>
            <input type="submit" name="download" value="Download"/>
        </form>
    </div>
<?php endforeach; ?>

</body>