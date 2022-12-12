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
    <title>Site de Recettes - Page de connexion</title>
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
    <?php
    include_once $rootPath . 'header.php';

    $addOn1 = '';
    $addOn2 = '';
    $pageRetour = $rootUrl . 'home.php';

    if (isset($_GET['sens'])) {
        $sens = $_GET['sens'];
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
    ?>

    <!--
        Si utilisateur/trice est non identifié(e), on affiche le formulaire
    -->
    <?php if (!isset($_SESSION['LOGGED_USER'])): ?>
    <form action="login.php" method="post">
        <!-- si message d'erreur on l'affiche -->
        <?php if (isset($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
            <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
        <input type="button" onclick="window.location.href='<?php echo $pageRetour; ?>'" class="btn btn-primary" value="Annuler" >
    </form>
    <!-- 
        Si utilisateur/trice bien connectée on affiche un message de succès
    -->
    <?php else: ?>
        <div class="alert alert-success" role="alert">
            Bonjour 
            <?php echo $_SESSION['LOGGED_USER']; ?> 
            . Vous êtes déjà connecté.
        </div>
    <?php endif; ?> 
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>