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

    <!-- Inclusion du formulaire de connexion -->
    <?php include_once $rootPath . 'login.php'; ?>
        <!-- Si l'utilisateur existe, on retourne à la page d'accueil -->
        <?php if (isset($_SESSION['LOGGED_USER'])) {
            header('Location: ' . $pageRetour);
            return;
        } ?>
    </div>
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>