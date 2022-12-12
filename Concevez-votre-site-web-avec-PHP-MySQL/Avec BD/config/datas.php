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

// On rentre la des commentaires et
// les associations avec les autres tables pour faire les correspondances
$sqlQuery = 'SELECT * FROM comments';

$commentsStatement = $db->prepare($sqlQuery);
$commentsStatement->execute();
$comments = $commentsStatement->fetchAll();

// tri par ordre de date décroissante
$date = array_column($comments, 'created_at');
array_multisort($date, SORT_DESC, SORT_REGULAR, $comments);

// On rentre la des commentaires et
// les associations avec les autres tables pour faire les correspondances
$sqlQuery = 'SELECT u.full_name, c.comment, r.title 
    FROM users u
    JOIN comments c
        ON u.user_id = c.user_id
    JOIN recipes r
        ON c.recipe_id = r.recipe_id';

$comments2Statement = $db->prepare($sqlQuery);
$comments2Statement->execute();
$comments2 = $comments2Statement->fetchAll();

// On rentre la des commentaires et
// les associations avec les autres tables pour faire les correspondances
$sqlQuery = 'SELECT u.full_name, c.comment
FROM users u
INNER JOIN comments c
ON u.user_id = c.user_id';

$comments3Statement = $db->prepare($sqlQuery);
$comments3Statement->execute();
$comments3 = $comments3Statement->fetchAll();

return $sens;
?>
