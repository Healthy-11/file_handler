<nav>
    <h2>Signature sender</h2>
    <ul>
        <li><a href="to_sign.php">A signer</a></li>
        <li><a href="signed.php">Signé</a></li>
        <?php
        session_start();
        if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) { ?>
            <li><a href="login.php">Se connecter</a></li>
        <?php } else { ?>
            <li><a href="login.php">Bonjour, <?= $_SESSION["username"] ?></a></li>
        <?php } ?>
    </ul>
</nav>
<?php
if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) {
    header('Location: /');
}
?>