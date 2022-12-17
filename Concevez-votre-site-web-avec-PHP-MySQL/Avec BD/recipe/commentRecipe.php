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
    <title>Site de Recettes - Les avis</title>
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
    <?php
    include_once $rootPath . 'header.php';

    // Récupération de la valeur envoyée et traitement pour retirer d'éventuelles balises HTML
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
    if (isset($getData['id'])) {
        $dataId = htmlspecialchars(strip_tags($getData['id']));
    } else {
        echo '<div class="alert alert-danger" role="alert">L\'identifiant de la recette est manquant ou invalide.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Contrôle si la recette existe
    if (!getvalidIdRecipe($dataId, $recipes)) {
        echo '<div class="alert alert-danger" role="alert">Cette recette n\'existe pas ou n\'a pas été trouvée.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Filtres anti balise html
    $dataId = strip_tags($dataId);
    $dataId = htmlspecialchars($dataId);

    // Récupération des information de la recette
    // et des commentaires pour cette recette
    $dataRecipe = getDataRecipe($dataId, $recipes);
    $dataComments = getDataComments($dataId, $comments);
    $nbAvis = sizeof($dataComments);
    $note = calcNote($dataId, $comments);
    $starNote = getStarNote($nbAvis, $note);
    $starNoteColor = getStarNoteColor($nbAvis, $note);
    $noteTotal = 0;
    if ($nbAvis >= 1) {
        $noteTotal = $note / $nbAvis;
    }

// echo $getData . " " . $recipes[$getData];
?>
        <h1>Les avis</h1>
        <hr>
        <div class="container-recipe">
            <ul class="navbar-nav recipe-nav">                                             
                <li>
                <a class="link-dark text-decoration-none" href="addCommentRecipe.php?recipe_id=<?php echo $dataRecipe[
                    'recipe_id'
                ] .
                    $addOn1; ?>"><i class="far fa-plus-square"></i> Ecrire un commentaire</a>
                </li>
            </ul>
        </div> 
        <div class="recipe">
            <?php echo '<h3>' . $dataRecipe['title'] . '</h3>'; ?> 
            <div class="text-dark d-sm-flex flex-row justify-content-sm-start">
                <!-- <div class="text-warning me-sm-3"> -->
                    <?php echo $starNoteColor; ?>
                <!-- </div> -->
                <div class="text-primary me-sm-3"><?php echo $nbAvis; ?> avis.</div>
            </div>
               
            <?php foreach ($comments as $comment): ?>
                <?php if (
                    $comment['recipe_id'] == $dataRecipe['recipe_id']
                ): ?>                
                <!-- // Si un pseudo existe on utilise le pseudo, si non on affiche l'adresse email -->
                    <?php
                    if (!empty($comment['user_id'])) {
                        // Récupération de l'utilisateur
                        $dataUser = getDataUser($comment['user_id'], $users);
                        if (isset($dataUser['pseudo'])) {
                            $userFrom = $dataUser['pseudo'];
                        } else {
                            $userFrom = $dataUser['email'];
                        }
                    } else {
                        $userFrom = 'Utilisateur inconnu';
                        $dataUser = [];
                    }
                    $nbAvis = 1;
                    $note = $comment['ranking'];
                    $starNote = getStarNote('1', $note);
                    $starNoteColor = getStarNoteColor('1', $note);
                    ?>
                    <article class="recipe border-secondary">
                        <?php echo 'Avis : ' . $comment['comment']; ?> 
                        <!-- <div class="text-dark d-sm-flex flex-row justify-content-sm-start container-comment"> -->
                        <div class="text-dark container-comment">
                        <!-- // echo '<div class="text-dark d-sm-flex flex-row justify-content-sm-end">'; -->
                        <!-- // echo '<div class="me-sm-3">'; -->
                        <?php echo $starNoteColor; ?> 
                        <!-- // echo '</div>'; -->
                        <div class="me-sm-3">
                            <!-- // echo 'Le : ' . $comment['created_at']; -->
                            <?php echo 'Le : ' . $comment['comment_date']; ?> 
                        </div>
                        <div class="me-sm-3">
                            <?php echo 'De : ' . $userFrom; ?> 
                        </div>
                        <div class="container-btn-comment">
                            <ul class="navbar-nav recipe-nav"> 
                                <?php
                                if (
                                    !empty($_SESSION['USER_EMAIL']) &&
                                    !empty($dataUser)
                                ) {
                                    if (
                                        $dataUser['email'] ===
                                        $_SESSION['USER_EMAIL']
                                    ) {
                                        echo '<li>';
                                        echo '<a class="link-success text-decoration-none" href="updateCommentRecipe.php?recipe_id=' .
                                            $dataRecipe['recipe_id'] .
                                            '&comment_id=' .
                                            $comment['comment_id'] .
                                            $addOn1 .
                                            '"';
                                        echo '<i class="fas fa-edit"></i> Modifier</a>';
                                        echo '</li>';
                                    }
                                }
                                if (isset($_SESSION['USER_NAME'])): ?>
                                    <?php if ($_SESSION['USER_LEVEL'] >= 2): ?>
                                        <li>
                                            <a class="link-danger text-decoration-none" href="deleteCommentRecipe.php?recipe_id=<?php echo $dataRecipe[
                                                'recipe_id'
                                            ]; ?>&comment_id=<?php echo $comment[
    'comment_id'
] . $addOn1; ?>">
                                            <i class="fas fa-trash-alt"></i> Supprimer</a>
                                        </li>
                                    <?php endif; ?>  
                                <?php endif;
                                ?> 
                            </ul> 
                        </div>                 
                    </div>
                    </article>
                
                <?php endif; ?> 
                <?php endforeach; ?>

        <br />
        </div>
        <br>
        <div class="container-recipe">
            <ul class="navbar-nav recipe-nav">                                             
                <li>
                    <a class="link-dark text-decoration-none" href="addCommentRecipe.php?recipe_id=<?php echo $dataRecipe[
                        'recipe_id'
                    ] .
                        $addOn1; ?>"><i class="far fa-plus-square"></i> Ecrire un commentaire</a>
                </li>
            </ul>
        </div>  
        
        <hr>
    </div>
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>