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
    $addOn1 = '';
    $addOn2 = '';

    if (isset($_GET['sens'])) {
        $sens = $_GET['sens'];
        // Controle si on recoit une demande de tri
        if ($sens != 'DESC' && $sens != 'ASC') {
            $sens = '';
        } else {
            $addOn1 = '&sens=' . $sens;
            $addOn2 = '?sens=' . $sens;
        }
    } else {
        $sens = '';
    }

    include_once $rootPath . 'header.php';
    ?>

    <!-- Inclusion du formulaire de connexion -->
    <?php
// Code pour contrôler des variables
// echo '<br/><br/>';
// print_r($users);
// echo '<br/><br/>';
?> 
        <!-- Si l'utilisateur existe, on affiche les recettes -->
        <?php if (isset($_SESSION['USER_NAME'])): ?>
        <div class="alert alert-success" role="alert">
            Bonjour <?php echo $_SESSION['USER_NAME'] .
                ' (' .
                $_SESSION['USER_EMAIL'] .
                '). Bienvenue sur le site ! '; ?>
        </div>
        <?php else: ?>
        <div class="alert" role="alert">
            Il faut être connecté pour modifier ou ajouter des recettes.
        </div>
        <?php endif; ?>
                
        <h1>Liste des Recettes !</h1>
        <div class="container-recipe">
        <?php if ($sens == 'DESC'): ?>
            <ul class="navbar-nav recipe-nav">
                <li>
                    <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                        'home.php?sens=ASC'; ?>" ><i class="fas fa-sort-alpha-down"></i> Croissant</a>
                    </li>
                <li>                      
            </ul>
        <?php elseif ($sens == 'ASC'): ?>
            <ul class="navbar-nav recipe-nav">               
                <li>
                    <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                        'home.php?sens=DESC'; ?>" ><i class="fas fa-sort-alpha-up"></i> Décroissant</a>
                </li>                        
            </ul>
        <?php else: ?>
            <ul class="navbar-nav recipe-nav">
                <li>
                    <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                        'home.php?sens=ASC'; ?>" ><i class="fas fa-sort-alpha-down"></i> Croissant</a>
                    </li>
                <li>
                <a class="navbar-brand link-dark" href="<?php echo $rootUrl .
                    'home.php?sens=DESC'; ?>" ><i class="fas fa-sort-alpha-up"></i> Décroissant</a>
                </li>                        
            </ul>
            <?php endif; ?>
        </div>
    
        <?php foreach (getValidRecipes($recipes) as $recipe): ?>                
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
                        <!-- Calcule du nombre d'avis pour la recette et de la note moyenne -->
                        <?php
                        $dataComments = getDataComments(
                            $recipe['recipe_id'],
                            $comments
                        );
                        $nbAvis = sizeof($dataComments);
                        $note = calcNote($recipe['recipe_id'], $comments);
                        $starNote = getStarNote($nbAvis, $note);
                        $noteTotal = 0;
                        if ($nbAvis >= 1) {
                            $noteTotal = $note / $nbAvis;
                        }
                        ?>
                        <li>
                            <a class="link-warning text-decoration-none" href="<?php echo $rootUrl .
                                'recipe/commentRecipe.php?id=' .
                                $recipe['recipe_id'] .
                                $addOn1; ?>">
                                    <?php echo $starNote; ?>
                                    <span class="link-primary text-decoration-none"><?php echo $nbAvis; ?> avis</span></a>  
                        </li>
                        <?php if (isset($_SESSION['USER_NAME'])): ?>
                        <?php if ($_SESSION['USER_LEVEL'] >= 2): ?>
                            <li>
                                <!-- link-warning / link-dark / link-danger / link-primaire  / link-secondaire -->
                                <a class="link-success text-decoration-none" href="<?php echo $rootUrl .
                                    'recipe/updateRecipe.php?id=' .
                                    $recipe['recipe_id'] .
                                    $addOn1; ?>"><i class="fas fa-edit"></i> Editer</a>
                            </li>
                        <?php endif; ?>  
                        <?php if ($_SESSION['USER_LEVEL'] >= 4): ?>
                            <li>
                                <a class="link-danger text-decoration-none" href="<?php echo $rootUrl .
                                    'recipe/deleteRecipe.php?id=' .
                                    $recipe['recipe_id'] .
                                    '&title=' .
                                    $recipe['title'] .
                                    $addOn1; ?>"><i class="fas fa-trash-alt"></i> Supprimer</a>
                            </li>
                        <?php endif; ?>                            
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