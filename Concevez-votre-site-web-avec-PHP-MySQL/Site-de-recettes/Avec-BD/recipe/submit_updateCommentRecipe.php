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
    <title>Site de recettes - Mise à jour du commentaire en base de données</title>
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

        <h1>Rappel de vos informations</h1>
		
        
<div class="card">
    
    <div class="card-body">
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
  if (!isset($postData) || empty($postData)) {
      echo '<div class="alert alert-danger" role="alert">Des informations sont manquantes ou invalides.</div>';
      header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  // Contrôle si on a bien reçu une donnée
  if (
      isset($getData['recipe_id']) ||
      isset($postData['comment_id']) ||
      isset($postData['ranking']) ||
      isset($postData['author']) ||
      isset($postData['recipe']) ||
      isset($getData['user_id'])
  ) {
      $recipeId = htmlspecialchars(strip_tags($getData['recipe_id']));
      $userId = htmlspecialchars(strip_tags($getData['user_id']));
      $commentId = htmlspecialchars(strip_tags($postData['comment_id']));
      $commentRanking = htmlspecialchars(strip_tags($postData['ranking']));
      $commentRecipe = htmlspecialchars(strip_tags($postData['recipe']));
      $commentAuthor = htmlspecialchars(strip_tags($postData['author']));
  } else {
      echo '<div class="alert alert-danger" role="alert">Données manquantes ou invalides.</div>';
      //   header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  // Contrôle si on a bien reçu une donnée
  if (
      empty($recipeId) ||
      empty($userId) ||
      empty($commentId) ||
      empty($commentRanking) ||
      empty($commentRecipe)
  ) {
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

  // Création du format de la date pour la base de données
  $created_at = date('Y-m-d H:i:s');
  $date = date('d/m/Y à H:i:s');

  // Contrôle si un utilisateur est connecté
  if (!isset($_SESSION['USER_EMAIL'])) {
      echo '<div class="alert alert-danger" role="alert">Vous n\'êtes pas connecté. Vous n\'êtes pas autorisé à modifier l\'avis.</div>';
      header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  if ($_SESSION['USER_EMAIL'] != $commentAuthor) {
      echo '<div class="alert alert-danger" role="alert">Ce n\'est pas votre message. Vous n\'êtes pas autorisé à modifier l\'avis.</div>';
      header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  $majComment = $db->prepare(
      'UPDATE comments SET recipe_id = :recipe_id, user_id = :user_id, ranking = :ranking, comment = :comment, created_at = :created_at WHERE recipe_id = :recipe_id'
  );
  $majComment->execute([
      'recipe_id' => $recipeId,
      'user_id' => $userId,
      'ranking' => $commentRanking,
      'comment' => $commentRecipe,
      'created_at' => $created_at,
  ]);
  ?>
  <h4>Avis mis à jour avec succès !</h4>  
</div>    
<div class="card">             
    <div class="card-body">
        <p class="card-text"><b>Avis</b> : <?php echo $commentRecipe; ?></p>
        <p class="card-text"><b>Note</b> : <?php echo $commentRanking; ?></p>
        <p class="card-text"><b>Auteur</b> : <?php echo $commentAuthor; ?></p>
    </div>
</div> 
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