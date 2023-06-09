<!doctype html>
<html lang="fr">
<?php require("header.php"); ?>
<body>
<?php
session_start();
$error = false;
$session_username = $_SESSION["username"] ?? "";
$session_password = $_SESSION["password"] ?? "";

if (isset($_GET)) {
    if (isset($_GET["error"])) {
        $error = $_GET["error"];
        echo '<script>$.notify("Utilisateur ou mot de passe incorrect", "error");</script>';
    }
    if (isset($_GET["logout"])) {
        $session_username = "";
        $session_password = "";
        $_SESSION = [];
        echo '<script>$.notify("Déconnecté", "warn");</script>';
    }
    echo '<script>window.history.replaceState({}, document.title, "/" + "login");</script>';
    unset($_GET);
}
?>
<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form class="login" method="POST" action="get_login">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <label>
                        <input name="username" type="text" class="login__input" placeholder="Nom d'utilisateur"
                               value="<?php echo $session_username; ?>">
                    </label>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <label>
                        <input name="password" type="password" class="login__input" placeholder="Mot de passe"
                               value="<?php echo $session_password; ?>">
                    </label>
                </div>
                <div class="error">
                    <?php
                    if ($error) {
                        echo "Utilisateur ou mot de passe incorrect";
                    }
                    $error = false;
                    ?>
                </div>
                <button type="submit" name="submit" class="button login__submit">
                    <span class="button__text">Se connecter</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
</div>
</body>