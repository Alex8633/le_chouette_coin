<?php

require 'includes/config.php';

function inscription($email, $username, $password1, $password2)
{
    global $conn;
    try {
        $sql1 = "SELECT * FROM users WHERE email = '{$email}'";
        $sql2 = "SELECT * FROM users WHERE username = '{$username}'";
        $res1 = $conn->query($sql1);
        $count_email = $res1->fetchColumn();
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
                    $sth->execute();
                    echo '<div class="alert alert-success mt-2" role="alert">utilisateur enregistré</div>';;
                } else {
                    echo '<div class="alert alert-danger" role="alert">les mots de passe ne concorde pas</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Ce non d\'utilisateur est déja pris !</div>';
            }
        } elseif ($count_email > 0) {
            echo '<div class="alert alert-danger" role="alert">Cette adresse mail existe déja !</div>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function connexion($email, $password)
{
    global $conn;
    try {
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $res = $conn->query($sql);
        $user = $res->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $db_password = $user['password'];
            if (password_verify($password, $db_password)) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];
                echo 'Vous êtes connectés !';
                var_dump($_SESSION);
            } else {
                echo '<div class="alert alert-danger" role="alert">Le mot de passe est éronné !</div>';
                unset($_POST);
            }
        } else {
            echo 'Le mail n\'est pas connu !';
            unset($_POST);
        }
    } catch (PDOException $e) {
        echo 'Error ' . $e->getMessage();
    }
}

function affichage()
{
    global $conn;
    $sth = $conn->prepare('SELECT * FROM users');
    $sth->execute();
    $users = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        ?>
        <tr>
            <th scope="row"><?php echo $user['id']; ?>
            </th>
            <td><?php echo $user['email']; ?>
            </td>
            <td><?php echo $user['username']; ?>
            </td>
            <td><?php echo $user['password']; ?>
            </td>
        </tr>
        <?php
    }
}