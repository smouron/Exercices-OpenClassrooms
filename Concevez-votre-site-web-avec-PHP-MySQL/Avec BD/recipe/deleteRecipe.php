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

    // Contrôle si on a bien reçu une donnée et qu'elle est bien numérique
    if (isset($getData['id'])) {
        $dataId = htmlspecialchars(strip_tags($getData['id']));
        if (!is_numeric($dataId)) {
            echo '<div class="alert alert-danger" role="alert">L\'identifiant de la recette est manquant ou invalide.</div>';
            header('Refresh:2; url=' . $pageRetour);
            exit();
        }
    }

    if (!isset($getData['title'])) {
        echo '<div class="alert alert-danger" role="alert">Le nom de de la recette est manquant ou invalide.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    } else {
        $dataTitle = htmlspecialchars(strip_tags($getData['title']));
    }

    // Contrôle si la recette existe
    if (!getvalidIdRecipe($dataId, $recipes)) {
        echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
        header('Refresh:2; url=' . $pageRetour);
        // header('Refresh:2; url=' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    ?>

        <h1>Suppression d'une recette</h1>
        <hr>     
        <h3>Recette "<?php echo $getData['title']; ?>"</h3>
        <p><em>ATTENTION !!!</em> Toute suppression est définitive.</p>
            <form method="POST" action="<?php echo $rootUrl .
                'recipe/submit_deleteRecipe.php' .
                $addOn2; ?>">  
                <div class="mb-3 visually-hidden">
                    <label for="id" class="form-label">Identifiant de la recette</label>
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $dataId; ?>">
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