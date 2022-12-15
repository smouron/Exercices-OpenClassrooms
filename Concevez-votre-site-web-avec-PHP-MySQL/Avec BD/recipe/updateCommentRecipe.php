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
    <title>Site de Recettes - Modificaton d'un commentaire</title>
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
        echo '<div class="alert alert-danger" role="alert">Données manquantes ou invalides.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Contrôle si on a bien reçu une donnée
    if (empty($recipeId) || empty($commentId)) {
        echo '<div class="alert alert-danger" role="alert">Données manquantes ou invalides.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Contrôle si le commentaire existe
    // et qu'il est bien associé à la recette indiquée
    if (!getvalidIdComment($recipeId, $commentId, $comments)) {
        echo '<div class="alert alert-danger" role="alert">Cet avis n\'existe pas ou n\'a pas été trouvée.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }
    // Récupération des données du commentaire
    $dataComment = getDataComment($recipeId, $commentId, $comments);
    $emailUser = getDataUser($dataComment['user_id'], $users);

    $commentRanking = trim(
        htmlspecialchars(strip_tags($dataComment['ranking']))
    );
    ?>
        <h1>Modificaton de l'avis</h1>
        <hr>
            <form method="POST" action="<?php echo $rootUrl .
                'recipe/submit_updateCommentRecipe.php?recipe_id=' .
                $recipeId .
                '&user_id=' .
                $dataComment['user_id'] .
                $addOn1; ?>" enctype="multipart/form-data">             
                <div class="container-form-demi">
                    <div class="mb-3 form-48">
                    <label for="comment_id" class="form-label">Numéro de l'avis <em>**</em></label>                    
                    <input type="text" class="form-control" id="comment_id" name="comment_id" required="required" readonly="readonly" value="<?php echo $dataComment[
                        'comment_id'
                    ]; ?>" aria-describedby="numéro de l'avis'">
                    </div>
                    <div class="mb-3 form-48">
                        <label for="ranking" class="form-label">Note de l'avis <em>*</em></label>
                        <input type="text" class="form-control" id="ranking" name="ranking" required="required" maxlength="1" value="<?php echo trim(
                            $commentRanking
                        ); ?> " aria-describedby="note de l'avis'">
                        <div id="ranking-help" class="form-text">Entre 0 (= je n'aime pas) et 5 (= j'adore)</div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipe" class="form-label">Votre avis <em>*</em></label>
                    <textarea class="form-control" id="recipe" name="recipe" required="required" aria-describedby="le commentaire qui a été écrit"><?php echo $dataComment[
                        'comment'
                    ]; ?></textarea>                
                    <div id="email-help" class="form-text">Dans un langage correct et respectueux.</div>
                </div>
                <div class="container-form-demi">              
                    <div class="mb-3 form-48">
                        <label for="author" class="form-label">Auteur <em>**</em></label>                    
                        <input type="text" class="form-control" id="author" name="author" required="required" readonly="readonly" value="<?php echo $emailUser[
                            'email'
                        ]; ?>" aria-describedby="auteur de l'avis'">
                    </div>              
                    <div class="mb-3 form-48">
                        <label for="created_at" class="form-label">Créé le <em>**</em></label>                    
                        <input type="text" class="form-control" id="created_at" name="created_at" required="required" readonly="readonly" value="<?php echo $dataComment[
                            'comment_date'
                        ]; ?>" aria-describedby="date de création du commentaire">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                    <input type="button" onclick="window.location.href='<?php echo $pageRetour; ?>'" class="btn btn-primary" value="Annuler" >
                </div>                
                <p><em>*</em> Champs obligatoire.<br><em>**</em> Champs pas modifiable.</p>
            </form>     
            <?php  ?>
        <br />
        <hr>
    </div>
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>