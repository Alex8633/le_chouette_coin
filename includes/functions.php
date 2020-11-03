<?php

require 'includes/config.php';

function inscription($email, $username, $password1, $password2, $conn)
{
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