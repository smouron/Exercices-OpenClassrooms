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
    <title>Site de recettes - Ajout de la recette en base de données</title>
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
  if (!isset($postData) || !is_numeric($postData['recipe_id'])) {
      echo '<div class="alert alert-danger" role="alert">L\'identifiant de la recette est manquant ou invalide.</div>';
      header('Refresh:3; url=' . $pageRetour);
      return;
  }

  // Contrôle si la recette existe
  if (!getvalidIdRecipe($postData['recipe_id'], $recipes)) {
      echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
      header('Refresh:3; url=' . $pageRetour);
      return;
  }

  //   Contrôle si des données ont bien été renseignées
  if ($postData['title'] == '' && $postData['recipe'] == '') {
      echo '<div class="alert alert-danger" role="alert">Les données sont incomplètes. On ne peut pas enregister cette recette.</div>';
      header('Refresh:3; url=' . $pageRetour);
      return;
  } elseif ($postData['title'] == '') {
      echo '<div class="alert alert-danger" role="alert">Le titre est manquant. On ne peut pas enregister cette recette.</div>';
      header('Refresh:3; url=' . $pageRetour);
      return;
  } elseif ($postData['recipe'] == '') {
      echo '<div class="alert alert-danger" role="alert">Il n\'y a pas de recette. On ne peut pas enregister cette recette.</div>';
      header('Refresh:3; url=' . $pageRetour);
      return;
  }

  $recipe_id = strip_tags($postData['recipe_id']);
  $recipe_id = htmlspecialchars($recipe_id);
  //  strip_tags() retire les balises HTML
  $newTitle = strip_tags($postData['title']);
  // htmlspecialchars() modifie les balises HTML pour qu'elles ne soient pas traitées comme des balises
  $newTitle = htmlspecialchars($newTitle);
  // trim() supprime les caractères invisibles en début et fin de chaîne
  $newTitle = trim($newTitle);
  $newRecipe = $postData['recipe'];
  $newRecipe = strip_tags($postData['recipe']);
  $newRecipe = htmlspecialchars($newRecipe);
  $newRecipe = trim($newRecipe);
  $author = $_SESSION['USER_EMAIL'];
  $original_author = $postData['original_author'];

  $majRecipe = $db->prepare(
      'UPDATE recipes SET title = :title, recipe = :recipe, author = :author, original_author = :original_author, is_enabled = :is_enabled WHERE recipe_id = :recipe_id'
  );
  $majRecipe->execute([
      'title' => $newTitle,
      'recipe' => $newRecipe,
      'author' => $author,
      'original_author' => $original_author,
      'is_enabled' => 1,
      'recipe_id' => $recipe_id,
  ]);
  ?>
  <h4>Recette ajoutée avec succès !</h4>  
</div>    
<div class="card">             
    <div class="card-body">
        <h5 class="card-title"><?php echo $newTitle; ?></h5>
        <p class="card-text"><b>Recette</b> : <?php echo $newRecipe; ?></p>
        <p class="card-text"><b>Auteur</b> : <?php echo $author; ?></p>
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