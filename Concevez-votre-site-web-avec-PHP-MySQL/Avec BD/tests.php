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
    <title>Site de Recettes - Page d'accueil</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
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

    <div>
    <i class="far fa-star"></i>
    <i class="fas fa-star-half-alt"></i>
    <i class="fas fa-star"></i>
    <i class="fas fa-circle"></i>
    <i class="far fa-circle"></i>
    <i class="far fa-check-circle"></i>
    </div>
    <!-- 
        DEBUT TESTS DE CODE PHP 
    -->
    
    <?php
     
	 
    ?>
</div> 

</body>
</html>