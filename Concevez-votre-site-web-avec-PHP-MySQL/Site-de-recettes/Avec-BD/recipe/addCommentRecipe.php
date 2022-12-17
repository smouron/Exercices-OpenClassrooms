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
    <title>Site de Recettes - Ajout d'un commentaire'</title>
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

    //   Contrôle si des données ont bien été renseignées
    if (empty(!$getData['recipe_id']) || !isset($getData['recipe_id'])) {
        $recipe_id = htmlspecialchars(strip_tags($getData['recipe_id']));
    } else {
        echo '<div class="alert alert-danger" role="alert">L\'identifiant de la recette est manquant ou invalide.</div>';
        // header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Contrôle si la recette existe
    if (!getvalidIdRecipe($recipe_id, $recipes)) {
        echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
        // header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Filtres anti balise html
    $recipe_id = strip_tags($recipe_id);
    $recipe_id = htmlspecialchars($recipe_id);

    // Recupération du nom de la recette
    $dataRecipe = getDataRecipe($recipe_id, $recipes);
    $titleRecipe = $dataRecipe['title'];

    // Contrôle si un utilisateur est connecté
    // pour récupérer son identifiant
    $author = '';
    if (isset($_SESSION['USER_NAME'])) {
        $authorEmail = $_SESSION['USER_EMAIL'];
        $dataUser = getDataUserEmail($authorEmail, $users);
        $authorId = $dataUser['user_id'];

        // Si un utilisateur, contrôle si un avis a déjà été écrit
        // si c'est la cas, son avis est affiché pour être modifié
        foreach ($comments as $comment) {
            // echo ' <br>';
            // echo "comment['recipe_id'] : " . $comment['recipe_id'] . '<br>';
            // echo 'recipe_id : ' . $recipe_id . '<br>';
            // echo "comment['user_id'] : " . $comment['user_id'] . '<br>';
            // echo 'authorId : ' . $authorId . '<br>';
            if (
                $comment['recipe_id'] == $recipe_id &&
                $comment['user_id'] == $authorId
            ) {
                echo '<div class="alert alert-danger" role="alert">Vous avez déjà écrit un avis. <br>Cet avis va être affiché pour pouvoir être modifié.</div>';
                $pageNext =
                    $rootUrl .
                    'recipe/updateCommentRecipe.php?comment_id=' .
                    $comment['comment_id'] .
                    '&recipe_id=' .
                    $comment['recipe_id'] .
                    $addOn1;
                header('Refresh:2; url=' . $pageNext);
                exit();
            }
        }
    }
    ?>

        <h1>Recette : <?php echo $titleRecipe; ?></h1>
        <hr>     
            <form method="POST" action="<?php echo $rootUrl .
                'recipe/submit_addCommentRecipe.php?recipe_id=' .
                $dataRecipe['recipe_id'] .
                $addOn1; ?>" enctype="multipart/form-data"> 
                            
                <div class="mb-3">
                    <label for="comment" class="form-label">Votre avis <em>*</em></label>
                    <textarea class="form-control" id="comment" name="comment" required="required" aria-describedby="Avis sur cette recette"></textarea>                
                    <div id="comment-help" class="form-text">Dans un langage correct et respectueux.</div>
                </div>
                <!-- <div class="mb-3">
                    <label for="ranking" class="form-label">Donnez une note<em>*</em></label>
                    <input type="number" class="form-control" min="0" max="5" maxlength="1" value="0" id="ranking" name="ranking" required="required" aria-describedby="demande de la note que l'on donne à cette recette">
                    <div id="ranking-help" class="form-text">Entre 0 (0 = je n'aime pas) et 5 (0 = j'adore)</div>
                </div> -->
                <div class="mb-3">
                    <fieldset>
                        <legend><h5>Donnez une note</h5></legend>
                        <!-- <h5>Donnez une note</h5> -->
                        <div>
                        <input type="radio" id="rank0" name="ranking" value="0">
                        <label for="rank0" class="form-label">- 0 (Je n'aime pas du tout)</label>
                        </div>
                        <div>
                        <input type="radio" id="rank1" name="ranking" value="1">
                        <label for="rank1" class="form-label">- 1 (Je n'aime pas trop) </label>
                        </div>
                        <div>
                        <input type="radio" id="rank2" name="ranking" value="2">
                        <label for="rank2" class="form-label">- 2 (J'aime moyen)</label>
                        </div>
                        <div>
                        <input type="radio" id="rank3" name="ranking" value="3" checked> 
                        <label for="rank3" class="form-label">- 3 (J'aime bien)</label>
                        </div>
                        <div>
                        <input type="radio" id="rank4" name="ranking" value="4">
                        <label for="rank4" class="form-label">- 4 (J'aime beaucoup)</label>
                        </div>
                        <div>
                        <input type="radio" id="rank5" name="ranking" value="5">
                        <label for="rank5" class="form-label">- 5 (J'adore)</label>
                        </div>
                    </fieldset>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                    <input type="button" onclick="window.location.href='<?php echo $pageRetour; ?>'" class="btn btn-primary" value="Annuler" >
                </div>
                <p>Les champs indiqués par une <em>*</em> sont obligatoires</p>
            </form>     
        <br />
        <hr>
    </div>
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>