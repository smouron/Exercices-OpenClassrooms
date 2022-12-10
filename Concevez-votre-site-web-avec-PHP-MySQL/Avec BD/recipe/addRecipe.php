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
    <title>Site de Recettes - Ajout d'une recette</title>
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
    ?>

        <h1>Nouvelle recette</h1>
        <hr>     
            <form method="POST" action="<?php echo $rootUrl .
                'recipe/submit_addRecipe.php' .
                $addOn2; ?>" enctype="multipart/form-data">                
                <div class="mb-3">
                    <label for="title" class="form-label">Nom de la recette <em>*</em></label>
                    <input type="text" class="form-control" id="title" name="title" required="required" aria-describedby="demande du nom de la recette">
                </div>
                <div class="mb-3">
                    <label for="recipe" class="form-label">Composition de la recette <em>*</em></label>
                    <textarea class="form-control" id="recipe" name="recipe" required="required" aria-describedby="compositon de la recette"></textarea>                
                    <div id="email-help" class="form-text">Seulement du contenu vous appartenant ou libre de droits.</div>
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