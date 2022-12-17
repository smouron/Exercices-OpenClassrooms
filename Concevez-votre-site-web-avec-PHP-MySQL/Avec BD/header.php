<!-- header.php -->
<?php
// $rootUrl : adresse du serveur - Contenu de l'en-tête
$rootUrl =
    (!empty($_SERVER['HTTPS']) ? 'https' : 'http') .
    '://' .
    $_SERVER['HTTP_HOST'] .
    '/';

// $rootPath : La racine sous laquelle le script courant est exécuté
$rootPath = $_SERVER['DOCUMENT_ROOT'];

// $rootAdd : Chemin sur le serveur
$rootAdd = 'OpenClassRooms/Avec BD/';
$rootUrl = $rootUrl . $rootAdd;
$rootPath = $rootPath . '/' . $rootAdd;

// Chargements de ces pages avec le header
include_once $rootPath . 'config/connect.php';
include_once $rootPath . 'config/datas.php';
include_once $rootPath . 'config/functions.php';

$addOn1 = '';
$addOn2 = '';

if (isset($_GET['sens'])) {
    $sens = $_GET['sens'];
    // Controle si on recoit une demande de tri
    if ($sens != 'DESC' && $sens != 'ASC') {
        $sens = '';
    } else {
        $addOn1 = '&sens=' . $sens;
        $addOn2 = '?sens=' . $sens;
    }
} else {
    $sens = '';
}
?>

<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container-fluid">
		<a class="navbar-brand" href="<?php echo $rootUrl .
      'index.php'; ?>">Site de recettes</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
			<li class="nav-item">
			  <a class="nav-link active" aria-current="page" href="<?php echo $rootUrl .
         'home.php' .
         $addOn2; ?>">Home</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="<?php echo $rootUrl .
         'contact.php' .
         $addOn2; ?>">Contact</a>
			</li>
			<?php if (isset($_SESSION['LOGGED_USER'])): ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo $rootUrl .
         'recipe/addRecipe.php' .
         $addOn2; ?>">Nouvelle recette</a>
				</li>
				<?php if ($_SESSION['USER_LEVEL'] >= 4): ?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $rootUrl .
          'recipe/allRecipe.php' .
          $addOn2; ?>">Toutes les recettes</a>
					</li>
				<?php endif; ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo $rootUrl .
         'deconnexion.php' .
         $addOn2; ?> ">Déconnexion</a>
				</li>
				<?php if ($_SESSION['USER_LEVEL'] >= 5): ?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo $rootUrl .
          'affichage_valeurs_tables.php'; ?>" target="_blank">Tests code</a>
					</li>
				<?php endif; ?>				
			<?php else: ?>
				<li class="nav-item ">
				<a class="nav-link" href="<?php echo $rootUrl .
        'connexion.php' .
        $addOn2; ?> ">Connexion</a>
			</li>
			<?php endif; ?>
		  </ul>
		</div>
	  </div>
	</nav>
</header>