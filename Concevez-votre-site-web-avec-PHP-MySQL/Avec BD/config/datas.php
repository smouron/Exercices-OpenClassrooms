<?php

if (isset($_GET['sens'])) {
    $sens = $_GET['sens'];
    // Controle si on recoit une demande de tri
    if ($sens != 'DESC' && $sens != 'ASC') {
        $sens = '';
    }
} else {
    $sens = '';
}

// On récupère tout le contenu de la table users
// On rentre la commande Sql dans une variable
$sqlQuery = 'SELECT * FROM users';

// on execute la commande Sql
$usersStatement = $db->prepare($sqlQuery);
$usersStatement->execute();

// "Fetch" en anglais signifie « va chercher »
$users = $usersStatement->fetchAll();

// Encodage en UTF-8 pour afficher les caractères accentués
// quand option charset=UTF-8 manquante
// dans la commnande sql de connexion à la table
//
// $users = mb_convert_encoding($users, 'UTF-8', 'ISO-8859-1');
// On récupère tout le contenu de la table recipes
// $sqlQuery = 'SELECT * FROM recipes WHERE is_enabled = TRUE';
$sqlQuery = 'SELECT * FROM recipes';
$recipesStatement = $db->prepare($sqlQuery);
$recipesStatement->execute();
$recipes = $recipesStatement->fetchAll();

// Réalisation du tri si demandé
$data = $recipes;
$title = array_column($recipes, 'title');
if ($sens == 'DESC') {
    // echo 'Tri en ordre décroissant';
    array_multisort($title, SORT_DESC, SORT_REGULAR, $recipes);
} elseif ($sens == 'ASC') {
    // echo 'Tri en ordre croissant';
    array_multisort($title, SORT_ASC, SORT_REGULAR, $recipes);
}

return $sens;
?>
