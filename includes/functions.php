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
                header('location: index.php');
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

function affichageProduits()
{
    global $conn;
    $sth = $conn->prepare('SELECT p.*, c.categories_name, u.username 
                                    FROM products AS p 
                                    LEFT JOIN categories AS c 
                                    ON p.category_id = c.categories_id   
                                    LEFT JOIN users AS u 
                                    ON p.user_id = u.id');
    $sth->execute();
    $products = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        ?>
        <tr>
            <th scope="row"><?php echo $product['products_id']; ?>
            </th>
            <td><?php echo $product['name']; ?>
            </td>
            <td><?php echo $product['description']; ?>
            </td>
            <td><?php echo $product['ville']; ?>
            </td>
            <td><?php echo $product['price']; ?>
            </td>
            <td><?php echo $product['categories_name']; ?>
            </td>
            <td><?php echo $product['username']; ?>
            </td>
            <td>
                <a
                        href="product.php/?id=<?php echo $product['products_id']; ?>">Afficher
                    article</a>
            </td>
        </tr>
        <?php
    }
}

function ajoutProduits($name, $description, $price, $city, $category, $user_id)
{
    global $conn;
    if (is_float($price) && $price > 0 && $price < 1000000) {
        try {
            $sth = $conn->prepare('INSERT INTO products (name, description, price, ville, category_id, user_id) 
                            VALUES (:product_name, :description, :price, :ville, :category_id, :user_id)');
            $sth->bindValue(':product_name', $name, PDO::PARAM_STR);
            $sth->bindValue(':description', $description, PDO::PARAM_STR);
            $sth->bindValue(':price', $price);
            $sth->bindValue(':ville', $city, PDO::PARAM_STR);
            $sth->bindValue(':category_id', $category, PDO::PARAM_INT);
            $sth->bindValue(':user_id', $user_id, PDO::PARAM_INT);

            if ($sth->execute()) {
                echo "<div class='alert alert-succes'>Votre article a bien été ajouter</div>";
                header('location: products.php');
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

function affichageProduit($id)
{
    global $conn;
    $sth = $conn->prepare("SELECT p.*, c.categories_name, u.username 
                                    FROM products AS p 
                                    LEFT JOIN categories AS c 
                                    ON p.category_id = c.categories_id 
                                    LEFT JOIN users AS u 
                                    ON p.user_id = u.id 
                                    WHERE p.products_id = {$id}");
    if ($sth->execute()) {
        
    };

    $product = $sth->fetch(PDO::FETCH_ASSOC); ?>
    <div class="row">
        <div class="col-12">
            <h1><?php echo $product['name']; ?>
            </h1>
            <p><?php echo $product['description']; ?>
            </p>
            <p><?php echo $product['ville']; ?>
            </p>
            <button class="btn btn-danger"><?php echo $product['price']; ?> </button>
        </div>
    </div>
    <?php
}
