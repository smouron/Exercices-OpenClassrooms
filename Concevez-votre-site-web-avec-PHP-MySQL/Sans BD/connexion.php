<?php session_start();
// $_SESSION
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Page de connexion</title>
    <link
        href="bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- Navigation -->
    <?php include_once 'header.php'; ?>

    <!-- inclusion des variables et fonctions -->
    <?php
    include_once 'variables.php';
    include_once 'functions.php';
    ?>

    <!-- Inclusion du formulaire de connexion -->
    <?php include_once 'login.php'; ?>
        <!-- Si l'utilisateur existe, on affiche les recettes -->
        <?php if (isset($_SESSION['LOGGED_USER'])) {
            header('Location: ./home.php');
            exit();
        } ?>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>