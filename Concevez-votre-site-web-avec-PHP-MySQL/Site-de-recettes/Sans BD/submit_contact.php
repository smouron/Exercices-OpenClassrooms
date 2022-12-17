<?php session_start(); ?>

<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link
        href="bootstrap.min.css" 
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
  // isset($_POST['']) => contrôle de l'on reçoit la variable
  if (isset($_POST['nom'])) {
      //  htmlspecialchars : modifie les balises HTML pour qu'elles ne soient pas traitées comme balises
      //  strip_tags : retire les balaises HTML
      echo '<p class="card-text"><b>Nom</b> : ' .
          htmlspecialchars($_POST['nom']) .
          '</p>';
  }

  if (isset($_POST['prenom'])) {
      echo '<p class="card-text"><b>Prenom</b> : ' .
          htmlspecialchars($_POST['prenom']) .
          '</p>';
  }

  if (!isset($_POST['email'])) {
      echo '<p class="card-text"> Votre adresse mail est manquante !!!</p>';
  } elseif (
      !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
      empty($_POST['email'])
  ) {
      // Contrôle que l'adresse mail est valide et pas vide
      echo '<p class="card-text"> Votre adresse mail est invalide ou manquante !!!</p>';
  } else {
      echo '<p class="card-text"><b>Email</b> : ' .
          htmlspecialchars($_POST['email']) .
          '</p>';
  }

  if (!isset($_POST['message']) || empty($_POST['message'])) {
      // Contrôle que le message n'est pas vide
      echo '<p class="card-text">Le message est manquant.</p>';
  } else {
      //  htmlspecialchars : modifie les balises HTML pour qu'elles ne soient pas traitées comme balises
      //  strip_tags : retire les balaises HTML
      echo '<p class="card-text"><b>Message</b> : ' .
          strip_tags($_POST['message']) .
          '</p>';
  }

  if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
      $fileInfo = pathinfo($_FILES['screenshot']['name']);
      $extension = $fileInfo['extension'];
      $taille = $_FILES['screenshot']['size'] / 1000;
      // pathinfo renvoi un tableau (array) contenant entre autres l'extension du fichier
      echo '<p class="card-text"><b>pathinfo</b> : ' .
          print_r($fileInfo) .
          '</p>';
      echo '<p class="card-text"><b>$_FILES</b> : ' . print_r($_FILES) . '</p>';

      echo '<p class="card-text">';
      echo 'Nom du fichier : ' . $_FILES['screenshot']['name'] . ' <br />';
      echo 'Type de fichier : ' .
          $_FILES['screenshot']['type'] .
          ' (' .
          $extension .
          ') <br />';
      echo 'Taille du fichier  : ' .
          $_FILES['screenshot']['size'] .
          ' octets (' .
          $taille .
          ' Ko).<br />';
      echo 'Emplacement temporaire : ' .
          $_FILES['screenshot']['tmp_name'] .
          '<br />';
      echo 'Code erreur : ' . $_FILES['screenshot']['error'] . '<br />';
      echo '</p>';

      // Testons si le fichier n'est pas trop gros
      if ($_FILES['screenshot']['size'] <= 1000000) {
          // Testons si l'extension est autorisée
          $fileInfo = pathinfo($_FILES['screenshot']['name']);
          $extension = $fileInfo['extension'];
          $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png', 'ico'];
          if (in_array($extension, $allowedExtensions)) {
              // On peut valider le fichier et le stocker définitivement
              //
              // Comme $_FILES['screenshot']['name'] contient le chemin entier vers le fichier d'origine ( C:\dossier\fichier.png  , par exemple),
              // il nous faudra extraire le nom du fichier.
              // On peut utiliser pour cela la fonction basename qui renverra juste « fichier.png ».
              move_uploaded_file(
                  $_FILES['screenshot']['tmp_name'],
                  'uploads/' . basename($_FILES['screenshot']['name'])
              );
              // $fileInfo['basename'] <==> basename($_FILES['screenshot']['name'])
              echo 'L\'envoi du fichier "' .
                  $fileInfo['basename'] .
                  '" a bien été effectué !';
          } else {
              echo 'Le fichier n\'est pas une image.';
          }
      } else {
          echo 'Le fichier est trop gros.';
      }
  } else {
      echo '<p class="card-text">Il n\'y a pas de fichier image.</p>';
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
		<h3>$_FILES['nom_du_champ']['name'] </h3>
		<p>Contient le nom du fichier envoyé par le visiteur. </p>
		<br />
		<h3>$_FILES['nom_du_champ']['type'] </h3>
		<p>Indique le type du fichier envoyé. Si c'est une image gif par exemple, le type sera image/gif </p>
		<br />
		<h3>$_FILES['nom_du_champ']['size'] </h3>
		<p>Indique la taille du fichier envoyé. </p>
		<p>Cette taille est en octets. Il faut environ 1 000 octets pour faire 1 Ko, et 1 000 000 d'octets pour faire 1 Mo.
        La taille de l'envoi est limitée par PHP. Par défaut, impossible d'uploader des fichiers de plus de 8 Mo.</p>
		<br />
		<h3>$_FILES['nom_du_champ']['tmp_name'] </h3>
		<p>Juste après l'envoi, le fichier est placé dans un répertoire temporaire sur le serveur en attendant que votre script PHP décide si oui ou non il accepte de le stocker pour de bon. Cette variable contient l'emplacement temporaire du fichier (c'est PHP qui gère ça). </p>
		<br />
		<h3>$_FILES['nom_du_champ']['error'] </h3>
		<p>Contient un code d'erreur permettant de savoir si l'envoi s'est bien effectué ou s'il y a eu un problème et si oui, lequel. La variable vaut 0 s'il n'y a pas eu d'erreur. </p>
		<br />
		<h3>$fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = $fileInfo['extension']; </h3>
		<p>La fonction pathinfo renvoie un tableau (array) contenant entre autres l'extension du fichier dans  $fileInfo['extension'] </p>
		<br />
		<h3> basename($_FILES['screenshot']['name'])</h3>
		<p>Comme $_FILES['screenshot']['name'] contient le chemin entier vers le fichier d'origine ( C:\dossier\fichier.png  , par exemple), il nous faudra extraire le nom du fichier.
        On peut utiliser pour cela la fonction basename qui renverra juste « fichier.png » </p>
		<br />
		<h3>move_uploaded_file($_FILES['screenshot']['tmp_name'], 'uploads/' . basename($_FILES['screenshot']['name']))</h3>
		<p>Cette fonction prend deux paramètres : 
            <ol>
                <li>Le nom temporaire du fichier (on l'a avec $_FILES['screenshot']['tmp_name']  ).</li>
                <li>Le chemin qui est le nom sous lequel sera stocké le fichier de façon définitive. On peut utiliser le nom d'origine du fichier $_FILES['screenshot']['name']  ou générer un nom au hasard.</li>
            </ol>
        </p>
		<br />
		<h3> </h3>
		<p> </p>
		<br />
	</div>
</div>
    <!-- inclusion du bas de page du site -->
    <?php include_once 'footer.php'; ?> 
</body>
</html>