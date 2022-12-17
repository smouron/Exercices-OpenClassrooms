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
$sqlQuery = 'SELECT *, DATE_FORMAT(created_at, "%d/%m/%Y à %H:%i") AS comment_date FROM comments 
ORDER BY created_at DESC';

$commentsStatement = $db->prepare($sqlQuery);
$commentsStatement->execute();
$comments = $commentsStatement->fetchAll();

// Test de jointures externes avec la table recette
// 3 tables réunies
$sqlQuery = 'SELECT u.full_name, c.comment, r.title 
    FROM users u
    JOIN comments c
        ON u.user_id = c.user_id
    JOIN recipes r
        ON c.recipe_id = r.recipe_id';

$comments2Statement = $db->prepare($sqlQuery);
$comments2Statement->execute();
$comments2 = $comments2Statement->fetchAll();

// Test de jointures externes avec la table recette
$sqlQuery = 'SELECT r.recipe_id, r.title, r.recipe, r.is_enabled, c.comment, c.ranking, u.full_name, u.email, u.pseudo, u.level
    FROM recipes r
    JOIN comments c
        ON r.recipe_id = c.recipe_id
    JOIN users u       
        ON c.user_id  = u.user_id';

$comments3Statement = $db->prepare($sqlQuery);
$comments3Statement->execute();
$comments3 = $comments3Statement->fetchAll();


// Test de calcule par SQL
$sqlQuery =
    'SELECT ROUND(AVG(ranking),1) AS rating, recipe_id FROM comments GROUP BY recipe_id';

$rankingsStatement = $db->prepare($sqlQuery);
$rankingsStatement->execute();
$rankings = $rankingsStatement->fetchAll();

return $sens;
?>
