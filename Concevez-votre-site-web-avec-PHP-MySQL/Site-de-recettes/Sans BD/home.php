<?php session_start();
// $_SESSION
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page d'accueil</title>
    <link
        href="bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- Navigation -->
    <?php include_once 'header.php'; ?>


    <!-- Inclusion du formulaire de connexion -->
    <?php
// include_once 'login.php';
?>
        

        <!-- Si l'utilisateur existe, on affiche les recettes -->
        <?php if (isset($_SESSION['LOGGED_USER'])): ?>
            <div class="alert alert-success" role="alert">
                Bonjour <?php echo $_SESSION[
                    'LOGGED_USER'
                ]; ?> et bienvenue sur le site !
            </div>
            <h1>Site de Recettes !</h1>
            <?php foreach (getRecipes($recipes) as $recipe): ?>                
                <article>
                    <h3><?php echo $recipe['title']; ?></h3>
                    <div><?php echo $recipe['recipe']; ?></div>
                    <i><?php echo displayAuthor(
                        $recipe['author'],
                        $users
                    ); ?></i>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                Il faut être connecté pour voir les recettes.
            </div>
        <?php endif; ?>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>