<?php session_start();
?>
<nav class="manav">
    <h2>Signature sender</h2>
    <ul class="nav navbar-nav navbar-right">
        <li><a <?php if (isset($page) && $page == "to_sign") echo ' class="active"'; ?> href="to_sign">Non signés</a></li>
        <li><a <?php if (isset($page) && $page == "signed") echo ' class="active"'; ?> href="signed">Signés</a></li>
    </ul>
    <?php
    if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) { ?>
        <a class="right" href="login">Se connecter</a>
    <?php } else { ?>
        <a class="right" href="login?logout=true">Se déconnecter</a>
    <?php } ?>
</nav>
<?php
    if (!isset($_SESSION["password"]) || !isset($_SESSION["username"])) { ?>
    <h1 class="display-message">Déconnecté</h1>
<?php }?>