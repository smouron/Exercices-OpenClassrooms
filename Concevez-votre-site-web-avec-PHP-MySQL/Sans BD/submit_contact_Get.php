<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- inclusion de l'entête du site -->
    <?php include_once 'header.php'; ?>
        <h1>Site de recettes</h1>

        <!-- inclusion des variables et fonctions -->
        <?php
        include_once 'variables.php';
        include_once 'functions.php';
        ?>
		
		<h1>Message bien reçu !</h1>
        
<div class="card">
    
    <div class="card-body">
        <h5 class="card-title">Rappel de vos informations</h5>
		<?php
  // isset($_GET['']) => contrôle de l'on reçoit la variable
  if (isset($_GET['nom'])) {
      //  htmlspecialchars : modifie les balises HTML pour qu'elles ne soient pas traitées comme balises
      //  strip_tags : retire les balaises HTML
      echo '<p class="card-text"><b>Nom</b> : ' .
          htmlspecialchars($_GET['nom']) .
          '</p>';
  }

  if (isset($_GET['prenom'])) {
      echo '<p class="card-text"><b>Prenom</b> : ' .
          htmlspecialchars($_GET['prenom']) .
          '</p>';
  }

  if (!isset($_GET['email'])) {
      echo '<p class="card-text"> Votre adresse mail est manquante !!!</p>';
  } elseif (
      !filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) ||
      empty($_GET['email'])
  ) {
      // Contrôle que l'adresse mail est valide et pas vide
      echo '<p class="card-text"> Votre adresse mail est invalide ou manquante !!!</p>';
  } else {
      echo '<p class="card-text"><b>Email</b> : ' .
          htmlspecialchars($_GET['email']) .
          '</p>';
  }

  if (!isset($_GET['message']) || empty($_GET['message'])) {
      // Contrôle que le message n'est pas vide
      echo '<p class="card-text">Le message est manquant.</p>';
  } else {
      //  htmlspecialchars : modifie les balises HTML pour qu'elles ne soient pas traitées comme balises
      //  strip_tags : retire les balaises HTML
      echo '<p class="card-text"><b>Message</b> : ' .
          strip_tags($_GET['message']) .
          '</p>';
  } 
  
  if (isset($_GET['screenshot'])) {
	  if (!empty($_GET['screenshot'])) {
	  echo '<p class="card-text">Image "'. $_GET['screenshot'] . '" bien reçue.</p>'; 
	  } else {
		  echo '<p class="card-text">Il n\'y a pas de fichier image.</p>';
	  }
  }
  ?>
    </div>
	<br />
	<hr>
	<div>
		<h3>htmlspecialchars</h3>
		<p>Modifie les balises HTML pour qu'elles ne soient pas traitées comme balises</p>
		<br />
		<h3>strip_tags</h3>
		<p>Retire les balaises HTML</p>
		<br />
		<h3>!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)</h3>
		<p>Contrôle que l'adresse mail est valide</p>
		<br />
		<h3>isset($_POST['nom'])</h3>
		<p>Contrôle de la donnée indiquée a été reçue</p>
		<br />
		<h3>empty($_POST['email'])</h3>
		<p>Contrôle que la donnée reçue n'est pas vide</p>
		<br />
	</div>
</div>
    <!-- inclusion du bas de page du site -->
    <?php include_once 'footer.php'; ?> 
</body>
</html>