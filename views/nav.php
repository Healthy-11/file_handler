<nav>
    <h2>Signature sender</h2>
    <ul>
        <li><a href="to_sign">A signer</a></li>
        <li><a href="signed">Signé</a></li>
        <?php
        session_start();
        if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) { ?>
            <li><a href="login">Se connecter</a></li>
        <?php } else { ?>
            <li><a href="login">Bonjour, <?= $_SESSION["username"] ?></a></li>
        <?php } ?>
    </ul>
</nav>
<?php
if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) {
    header('Location: /');
}
?>