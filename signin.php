<?php

$title = 'Identification - le Chouette Coin';
require 'includes/header.php';

if (!empty($_POST['email_signup']) && !empty($_POST['password1_signup']) && !empty($_POST['username_signup']) && isset($_POST['submit_signup'])) {
    $email = $_POST['email_signup'];
    $password1 = htmlspecialchars($_POST['password1_signup']);
    $password2 = htmlspecialchars($_POST['password2_signup']);
    $username = htmlspecialchars($_POST['username_signup']);
    inscription($email, $username, $password1, $password2);
} elseif (!empty($_POST['email_login']) && !empty($_POST['password_login']) && isset($_POST['submit_login'])) {
    $email = strip_tags($_POST['email_login']);
    $password = strip_tags($_POST['password_login']);

    connexion($email, $password);


} else {
    if (isset($_POST)) {
        unset($_POST);
    }
}

?>
<div class="row">
    <div class="col-6">
        <h3>S'inscrire</h3>
        <form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Adresse mail</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       name="email_signup" required>
                <small id="emailHelp" class="form-text text-muted">Nous ne partagerons jamais votre email avec qui que
                    ce soit.</small>
            </div>
            <div class="form-group">
                <label for="InuputUsername">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="InuputUsername" aria-describedby="emailHelp"
                       name="username_signup" required>
                <small id="userHelp" class="form-text text-muted">Choisissez un nom d'utilisateur, il doit être
                    unique</small>
            </div>
            <div class="form-group">
                <label for="InputPassword1">Choisissez un mot de passe</label>
                <input type="password" class="form-control" id="InputPassword1" name="password1_signup" required>
            </div>
            <div class="form-group">
                <label for="InputPassword2">Entrez votre mot de passe de nouveau</label>
                <input type="password" class="form-control" id="InputPassword2" name="password2_signup">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_signup" value="inscription">S'inscrire</button>
        </form>
    </div>

    <div class="col-6">
        <h3>Se connecter</h3>
        <form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Adresse mail</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       name="email_login">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <label for="InputPassword2">Choisissez un mot de passe</label>
                <input type="password" class="form-control" id="InputPassword1" name="password_login">
            </div>
            <button type="submit" class="btn btn-success" name="submit_login" value="connexion">Se connecter</button>
        </form>
    </div>
</div>
<?php
require 'includes/footer.php';
?>