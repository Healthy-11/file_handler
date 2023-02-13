<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>FTPConnect</title>
</head>
<body>
<?php
session_start();
$error = false;
$session_username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";
$session_password = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        $conn = new PDO("mysql:host=localhost;dbname=" . $_SESSION["config"]['db_name'], $_SESSION["config"]['db_username'], $_SESSION["config"]['db_password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT password, code FROM users WHERE username = '" . $username . "'";
        $query_res = $conn->query($query);
        $res = $query_res->fetch();
        if ($res) {
            $pass = $res[0];
            $code = $res[1];
            if (password_verify($password, $pass)) {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                $_SESSION["code"] = $code;
                header("Location: /views/ftp.php");
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    } catch (PDOException $e) {
        $error = true;
        //echo "Connexion échouée: " . $e->getMessage();
    }
} ?>
<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form class="login" method="POST" action="">
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
</html>