<?php
// $_SESSION
session_start();

//Chargement des variables
include_once './variables.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page d'accueil</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link
        href= "<?php echo $rootUrl . 'css/bootstrap.min.css'; ?>"
        rel="stylesheet"
    >
    <link
        href= "<?php echo $rootUrl . 'css/style.css'; ?>"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- Navigation -->
    <?php
    include_once $rootPath . 'header.php';

    $addOn1 = '';
    $addOn2 = '';
    $pageRetour = $rootUrl . 'home.php';

    if (isset($_GET['sens'])) {
        $sens = $_GET['sens'];
        // Controle si on recoit une demande de tri
        if ($sens != 'DESC' && $sens != 'ASC') {
            $sens = '';
        } else {
            $addOn1 = '&sens=' . $sens;
            $addOn2 = '?sens=' . $sens;
            $pageRetour = $pageRetour . $addOn2;
        }
    } else {
        $sens = '';
    }
    ?>

        <h1>Gestion des recettes</h1>
        <?php if (!isset($_SESSION['USER_NAME'])) {
            echo '<div class="alert alert-danger" role="alert">Vous n\'avez pas accès à cette partie.</div>';
            header('Refresh:2; url=' . $pageRetour);
            return;
        } elseif ($_SESSION['USER_LEVEL'] < 4) {
            echo '<div class="alert alert-danger" role="alert">Vous n\'avez pas le niveau pour accéder à cette partie. <br/> Si vous avez vraiment besoin, demandez à un administrateur.</div>';
            header('Refresh:2; url=' . $pageRetour);
            return;
        } ?>  
        <div class="container-recipe">
        <?php if ($sens == 'DESC'): ?>
            <ul class="navbar-nav recipe-nav">
                <li>
                    <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                        'recipe/allRecipe.php?sens=ASC'; ?>" ><i class="fas fa-sort-alpha-down"></i> Croissant</a>
                    </li>
                <li>                      
            </ul>
        <?php elseif ($sens == 'ASC'): ?>
            <ul class="navbar-nav recipe-nav">               
                <li>
                    <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                        'recipe/allRecipe.php?sens=DESC'; ?>" ><i class="fas fa-sort-alpha-up"></i> Décroissant</a>
                </li>                        
            </ul>
        <?php else: ?>
            <ul class="navbar-nav recipe-nav">
                <li>
                    <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                        'recipe/allRecipe.php?sens=ASC'; ?>" ><i class="fas fa-sort-alpha-down"></i> Croissant</a>
                    </li>
                <li>
                <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                    'recipe/allRecipe.php?sens=DESC'; ?>" ><i class="fas fa-sort-alpha-up"></i> Décroissant</a>
                </li>                        
            </ul>
            <?php endif; ?>
        </div>
    
        <?php foreach ($recipes as $recipe): ?>                
            <article class="recipe">
                <h3>
                    <?php echo $recipe['title'];
            // echo 'n° ' . $recipe['recipe_id'] . ' - ';
            ?>
                </h3>
                <div><?php echo $recipe['recipe']; ?></div>
                <em><?php echo displayAuthor($recipe['author'], $users); ?></em>
                
                <div class="container-recipe">
                    <ul class="navbar-nav recipe-nav">
                        <?php if ($recipe['is_enabled'] == 1): ?>
                            <li>
                            <a class="link-success" href="<?php echo $rootUrl .
                                'recipe/enabledRecipe.php?id=' .
                                $recipe['recipe_id'] .
                                '&is_enabled=0' .
                                $addOn1; ?>"><i class="fas fa-toggle-on"> Visible</i></a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a class="link-danger" href="<?php echo $rootUrl .
                                    'recipe/enabledRecipe.php?id=' .
                                    $recipe['recipe_id'] .
                                    '&is_enabled=1' .
                                    $addOn1; ?>"><i class="fas fa-toggle-off"> Pas visible</i></a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <!-- link-success / link-info / link-warning / link-dark / link-danger / link-primaire  / link-secondaire -->
                            <a class="link-primaire" href="<?php echo $rootUrl .
                                'recipe/updateRecipe.php?id=' .
                                $recipe['recipe_id'] .
                                $addOn1; ?>"><i class="fas fa-edit"> Editer</i></a>
                        </li>
                        <?php if ($_SESSION['USER_LEVEL'] >= 4): ?>
                            <li>
                                <a class="link-danger" href="<?php echo $rootUrl .
                                    'recipe/deleteRecipe.php?id=' .
                                    $recipe['recipe_id'] .
                                    $addOn1; ?>"><i class="fas fa-trash-alt"> Supprimer</i></a>
                            </li>
                        <?php endif; ?>                            
                    </ul>
                    </div>  
            </article>
        <?php endforeach; ?>
    </div> 
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>