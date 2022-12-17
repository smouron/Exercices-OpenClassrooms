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
    <title>Site de recettes - Ajout du commentaire en base de données</title>
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

  //   Contrôle si des données ont bien été renseignées
  if ($postData['comment'] == '' || !isset($postData['comment'])) {
      echo '<div class="alert alert-danger" role="alert">L\'avis est manquant. On ne peut pas l\'enregister.</div>';
      header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  $recipe_id = $getData['recipe_id'];
  if (!isset($recipe_id) || empty($recipe_id)) {
      echo '<div class="alert alert-danger" role="alert">Le numéro de la recette a été perdu.</div>';
      //   header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  // Filtres anti balise html
  $newComment = strip_tags($postData['comment']);
  $newComment = htmlspecialchars($newComment);
  $newComment = trim($newComment);
  $newRanking = strip_tags($postData['ranking']);
  $newRanking = htmlspecialchars($newRanking);
  $newRanking = trim($newRanking);
  $recipe_id = strip_tags($recipe_id);
  $recipe_id = htmlspecialchars($recipe_id);

  // Contrôle si un utilisateur est connecté
  // pour récupérer son identifiant
  $author = '';
  if (isset($_SESSION['USER_NAME'])) {
      $authorEmail = $_SESSION['USER_EMAIL'];
      $dataUser = getDataUserEmail($authorEmail, $users);
      $authorId = $dataUser['user_id'];
  }

  // Contrôle si la recette existe
  if (!getvalidIdRecipe($recipe_id, $recipes)) {
      echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
      // header('Refresh:2; url=' . $pageRetour);
      exit();
  }

  // Recupération du nom de la recette
  $dataRecipe = getDataRecipe($recipe_id, $recipes);
  $titleRecipe = $dataRecipe['title'];

  // Création du format de la date pour la base de données
  $created_at = date('Y-m-d H:i:s');
  $date = date('d/m/Y à H:i:s');

  $insertComment = $db->prepare(
      'INSERT INTO comments(comment, recipe_id, user_id, ranking, created_at) VALUES (:comment, :recipe_id, :user_id, :ranking, :created_at)'
  );
  $insertComment->execute([
      'comment' => $newComment,
      'recipe_id' => $recipe_id,
      'user_id' => $authorId,
      'ranking' => $newRanking,
      'created_at' => $created_at,
  ]);
  ?>
  <h4>Avis ajouté avec succès !</h4>  
    </div>    
    <div class="card">             
        <div class="card-body">
            <h5 class="card-title"><?php echo $titleRecipe; ?></h5>
            <p class="card-text"><b>Avis</b> : <?php echo $newComment; ?></p>
            <p class="card-text"><b>Auteur</b> : <?php echo $_SESSION[
                'USER_NAME'
            ]; ?></p> 
            <p class="card-text"><b>Note</b> : <?php echo $newRanking; ?> /5</p>           
            <p class="card-text"><b>Le</b> : <?php echo $date; ?></p>
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