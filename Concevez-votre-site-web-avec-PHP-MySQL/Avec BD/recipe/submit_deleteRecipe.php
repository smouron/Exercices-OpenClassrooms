<?php
// $_SESSION
session_start();

//Chargement des variables
include_once './variables.php';
?>

<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Suppresion de la recette en base de données</title>
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

	<!-- suppression de la recette -->
    <!-- Controle si on a bien reçu une donnée et qu'elle est bien numérique -->
     <?php
     $postData = $_POST;
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
     if (isset($postData['id'])) {
         $dataId = htmlspecialchars(strip_tags($postData['id']));
         if (!is_numeric($dataId)) {
             echo '<div class="alert alert-danger" role="alert">L\'identifiant de la recette est manquant ou invalide.</div>';
             header('Refresh:2; url=' . $pageRetour);
             exit();
         }
     }

     // Contrôle si la recette existe
     if (!getvalidIdRecipe($dataId, $recipes)) {
         echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
         header('Refresh:2; url=' . $pageRetour);
         exit();
     }

     $sqlQuery = 'DELETE FROM recipes WHERE recipe_id = :id';
     $deleteRecipeStatement = $db->prepare($sqlQuery);
     $deleteRecipeStatement->execute(['id' => $dataId]);
     ?>   
	<div class="card">
		<div class="card-body">
		<h4>Recette supprimée avec succès !</h4>
        
        <?php
        $message = 'Aucun avis n\' a été détecté pour cette recette';
        $count = 0;
        // Contrôle s'il y a des commentaires sur cett e recette
        foreach ($comments as $comment) {
            if ($comment['recipe_id'] === $dataId) {
                $count++;
                $commentId = $comment['comment_id'];
                $message =
                    'Il y avait ' . $count . ' avis pour cette recette. ';
                $sqlQuery = 'DELETE FROM comments WHERE comment_id = :id';
                $deleteCommentsStatement = $db->prepare($sqlQuery);
                $deleteCommentsStatement->execute(['id' => $commentId]);
            }
        }

        if ($count == 1) {
            $message = $message . 'Il a également été suprimé.';
        } elseif ($count > 1) {
            $message = $message . 'Ils ont également été suprimé.';
        }
        echo '<p>' . $message . '</p>';
        ?>
        <p>Cela va retourner automatiquement à la page d'accueil.</p> 
    </div>
	
    <!-- footer -->
    <?php
    include_once $rootPath . 'footer.php';
    // redirection var la page home
    // header('Location: ./../home.php');
    header('Refresh:2; url=' . $pageRetour);
    ?>
</body>
</html>