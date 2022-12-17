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
    <title>Site de recettes - Suppresion du commentaire en base de données</title>
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

     // Contrôle si on a bien reçu une donnée
     if (isset($getData['recipe_id']) || isset($postData['comment_id'])) {
         $recipeId = htmlspecialchars(strip_tags($getData['recipe_id']));
         $commentId = htmlspecialchars(strip_tags($postData['comment_id']));
     } else {
         echo '<div class="alert alert-danger" role="alert">Données manquantes ou invalides.</div>';
         header('Refresh:2; url=' . $pageRetour);
         exit();
     }

     // Contrôle si le commentiare existe
     // et qu'il est bien associé à la recette indiquée
     if (!getvalidIdComment($recipeId, $commentId, $comments)) {
         echo '<div class="alert alert-danger" role="alert">Cet avis n\'existe pas ou n\'a pas été trouvée.</div>';
         header('Refresh:2; url=' . $pageRetour);
         exit();
     }

     $sqlQuery = 'DELETE FROM comments WHERE comment_id = :id';
     $deleteCommentsStatement = $db->prepare($sqlQuery);

     $deleteCommentsStatement->execute(['id' => $commentId]);
     ?>   
	<div class="card">
		<div class="card-body">
		<h4>Avis supprimé avec succès !</h4>
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