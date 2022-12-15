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
    <title>Site de Recettes - Suppresion d'un commentaire d'une recette</title>
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
    <?php include_once $rootPath . 'header.php'; ?>

    <?php
    // Récupération de la valeur envoyée et traitement pour retirer d'éventuelles balises HTML
    $getData = $_GET;
    $pageRetour = $rootUrl . 'home.php';
    $addOn1 = '';
    $addOn2 = '';

    if (isset($getData['sens'])) {
        $sens = $getData['sens'];
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

    // Contrôle si on a bien reçu une donnée
    if (isset($getData['recipe_id']) || isset($getData['comment_id'])) {
        $recipeId = htmlspecialchars(strip_tags($getData['recipe_id']));
        $commentId = htmlspecialchars(strip_tags($getData['comment_id']));
    } else {
        echo '<div class="alert alert-danger" role="alert">Données 2 manquantes ou invalides.</div>';
        // header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Contrôle si le commentiare existe
    // et qu'il est bien associé à la recette indiquée
    if (!getvalidIdComment($recipeId, $commentId, $comments)) {
        echo '<div class="alert alert-danger" role="alert">Cet avis n\'existe pas ou n\'a pas été trouvée.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }
    ?>
    
    
        <h1>Suppression d'un avis</h1>
        <hr>     
        
        <p><em>ATTENTION !!!</em> Toute suppression est définitive.</p>
            <form method="POST" action="<?php echo $rootUrl .
                'recipe/submit_deleteCommentRecipe.php?recipe_id=' .
                $recipeId .
                $addOn1; ?>">  
                <div class="mb-3 visually-hidden">
                    <label for="id" class="form-label">Identifiant de la recette</label>
                    <input type="hidden" class="form-control" id="comment_id" name="comment_id" value="<?php echo $commentId; ?>">
                </div>              
                <button type="submit" class="btn btn-danger">Confirmer</button>
                <input type="button" onclick="window.location.href='<?php echo $pageRetour; ?>'" class="btn btn-primary" value="Annuler" >
            </form>  
        <br />
        <hr>
    </div>
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>