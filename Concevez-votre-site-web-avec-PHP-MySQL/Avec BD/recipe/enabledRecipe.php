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
    <title>Site de Recettes - Activer ou désactiver l'affichage des recettes</title>
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
    $pageRetour = $rootUrl . 'recipe/allRecipe.php';

    if (isset($getData['sens'])) {
        $sens = $getData['sens'];
        // Controle si on recoit une demande de tri
        if ($sens != 'DESC' && $sens != 'ASC') {
            $sens = '';
        } else {
            $pageRetour = $pageRetour . '?sens=' . $sens;
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

    if (isset($getData['is_enabled'])) {
        $dataEnabled = htmlspecialchars(strip_tags($getData['is_enabled']));
        // Controle si on recoit une demande de tri
        if (
            !is_numeric($dataEnabled) &&
            is_numeric($dataEnabled) > 0 &&
            is_numeric($dataEnabled) < 1
        ) {
            echo '<div class="alert alert-danger" role="alert">L\'information reçue n\'est pas bonne.</div>';
            header('Refresh:2; url=' . $pageRetour);
            return;
        }
    }

    // Contrôle si la recette existe
    if (!getvalidIdRecipe($dataId, $recipes)) {
        echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
        header('Refresh:2; url=' . $pageRetour);
        return;
    }

    $recipe_id = strip_tags($getData['id']);
    $recipe_id = htmlspecialchars($recipe_id);
    $majRecipe = $db->prepare(
        'UPDATE recipes SET is_enabled = :is_enabled WHERE recipe_id = :recipe_id'
    );
    $majRecipe->execute([
        'is_enabled' => $dataEnabled,
        'recipe_id' => $recipe_id,
    ]);

    header('Location:' . $pageRetour);
    ?>
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>