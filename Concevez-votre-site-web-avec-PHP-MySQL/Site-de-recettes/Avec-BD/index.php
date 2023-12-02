<?php session_start(); ?>

<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Stephane Mouron">
	<meta name="date.created" content="2022-09-17">
	<meta name="date.updated" content="2023-12-02"> 
    
	<!-- Pour empêcher tous les moteurs de recherche compatibles -->
	<meta name="robots" content="noindex">
	<!-- Pour empêcher que les robots d'exploration Google d'indexer une page -->
	<meta name="googlebot" content="noindex">

    <title>Site de recettes - Page d'accueil</title>
    <link
        href="./css/bootstrap.min.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <!-- redirection var la page home -->
    <?php header('Location: ./home.php'); ?>
</body>
</html>