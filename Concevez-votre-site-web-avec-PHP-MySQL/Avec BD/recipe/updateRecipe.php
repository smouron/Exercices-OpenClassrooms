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
    <title>Site de Recettes - Modificaton d'une recette</title>
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

    // Contrôle si on a bien reçu une donnée et qu'elle est bien numérique
    if (isset($getData['id'])) {
        $dataId = htmlspecialchars(strip_tags($getData['id']));
        if (!is_numeric($dataId)) {
            echo '<div class="alert alert-danger" role="alert">L\'identifiant de la recette est manquant ou invalide.</div>';
            header('Refresh:2; url=' . $pageRetour);
            return;
        }
    }

    // Contrôle si la recette existe
    if (!getvalidIdRecipe($dataId, $recipes)) {
        echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
        header('Refresh:3; url=' . $pageRetour);
        return;
    }

    // CRécupération des données de la recette
    $dataRecipe = getDataRecipe($dataId, $recipes);

// echo $getData . " " . $recipes[$getData];
?>
        <h1>Nouvelle recette</h1>
        <hr>     
            <form method="POST" action="<?php echo $rootUrl .
                'recipe/submit_updateRecipe.php' .
                $addOn; ?>" enctype="multipart/form-data">                
                <div class="container-form-demi">
                    <div class="mb-3 form-24">
                    <label for="recipe_id" class="form-label">Numéro de la recette <em>**</em></label>                    
                    <input type="text" class="form-control" id="recipe_id" name="recipe_id" required="required" readonly="readonly" value="<?php echo $dataRecipe[
                        'recipe_id'
                    ]; ?>" aria-describedby="auteur de la recette">
                    </div>
                    <div class="mb-3 form-74">
                        <label for="title" class="form-label">Nom de la recette <em>*</em></label>
                        <input type="text" class="form-control" id="title" name="title" required="required" value="<?php echo $dataRecipe[
                            'title'
                        ]; ?> " aria-describedby="nom de la recette">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="recipe" class="form-label">Composition de la recette <em>*</em></label>
                    <textarea class="form-control" id="recipe" name="recipe" required="required" aria-describedby="compositon de la recette"><?php echo $dataRecipe[
                        'recipe'
                    ]; ?></textarea>                
                    <div id="email-help" class="form-text">Seulement du contenu vous appartenant ou libre de droits.</div>
                </div>
                <div class="container-form-demi">              
                    <div class="mb-3 form-48">
                        <label for="original_author" class="form-label">Auteur <em>**</em></label>                    
                        <input type="text" class="form-control" id="original_author" name="original_author" required="required" readonly="readonly" value="<?php echo displayAuthor(
                            $dataRecipe['author'],
                            $users
                        ); ?>" aria-describedby="auteur de la recette">
                    </div>              
                    <div class="mb-3 form-48">
                        <label for="correcting_author" class="form-label">Modifié par <em>**</em></label>                    
                        <input type="text" class="form-control" id="correcting_author" name="correcting_author" required="required" readonly="readonly" value="<?php echo $_SESSION[
                            'USER_NAME'
                        ] .
                            ' (' .
                            $_SESSION['USER_EMAIL'] .
                            ')'; ?>" aria-describedby="auteur de la recette">
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                    <input type="button" onclick="window.location.href='<?php echo $pageRetour; ?>'" class="btn btn-primary" value="Annuler" >
                </div>                
                <p><em>*</em> Champs obligatoire.<br><em>**</em> Champs pas modifiable.</p>
            </form>     
        <br />
        <hr>
    </div>
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>