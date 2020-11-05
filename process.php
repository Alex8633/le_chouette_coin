<?php
require 'includes/header.php';

// Verouiller acces a la page process
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<div class='alert alert-danger'> La page à laquelle vous tentez d'accéder n'existe pas</div>";
} elseif (isset($_POST['product_submit'])) {
    echo "<div class='alert alert-success'>Vous tentez d'ajouter un produit à la base de donné</div>";
    if (!empty($_POST['product_name']) && !empty($_POST['product_description']) && !empty($_POST['product_price']) && !empty($_POST['product_city']) && !empty($_POST['product_category'])) {
        $name = strip_tags(($_POST['product_name']));
        $description = strip_tags(($_POST['product_description']));
        $price = floatval(strip_tags(($_POST['product_price'])));
        $city = strip_tags(($_POST['product_city']));
        $category = strip_tags(($_POST['product_category']));
        $user_id = strip_tags(($_SESSION['id']));
       ajoutProduits($name, $description, $price, $city, $category, $user_id);
    }
}


require 'includes/footer.php';