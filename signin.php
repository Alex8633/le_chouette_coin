<?php
$title = 'Identification - le Chouette Coin';
require 'includes/header.php';
require 'includes/config.php';

var_dump($_POST);
if (!empty($_POST['email_signup']) && !empty($_POST['password1_signup']) && !empty($_POST['username_signup']) && isset($_POST['submit_signup'])) {
    $email = $_POST['email_signup'];
    $password1 = $_POST['password1_signup'];
    $password2 = $_POST['password2_signup'];
    $username = $_POST['username_signup'];
    echo 'je suis la';
    try {
        $sql1 = "SELECT * FROM users WHERE email = '{$email}'";
        $sql2 = "SELECT * FROM users WHERE username = '{$username}'";
        $res1 = $conn->query($sql1);
        $count_email = $res1->fetchColumn();
        var_dump($count_email);
        if (!$count_email) {
            $res2 = $conn->query($sql2);
            $count_user = $res2->fetchColumn();
            if (!$count_user) {
                if ($password1 === $password2) {
                    $password1 = password_hash($password1, PASSWORD_DEFAULT);
                    $sth = $conn->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
                    $sth->bindValue(':email', $email);
                    $sth->bindValue(':username', $username);
                    $sth->bindValue(':password', $password1);
                    echo 'utilisateur a bien été enregisté';
                } else {
                    echo 'les mots de passe ne concorde pas';
                }
            } else {
                echo "Ce non d'utilisateur est déja pris !";
            }
        } elseif (!$count_email > 0) {
            echo 'Cette adresse mail existe déja !';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


?>
<div class="row">
    <div class="col-6">

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
        <form method="post" action="<?php $_SERVER['REQUEST_URI'] ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       name="email_signup">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <label for="InputPassword1">Choisissez un mot de passe</label>
                <input type="password" class="form-control" id="InputPassword1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
