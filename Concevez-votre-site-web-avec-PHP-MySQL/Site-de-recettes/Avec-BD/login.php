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
    <title>Site de recettes - Ajout de la recette en base de données</title>
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

    <?php
    $postData = $_POST;

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

    // Contrôle si on a bien reçu une donnée
    if (!isset($postData)) {
        echo '<div class="alert alert-danger" role="alert">Données manquantes ou invalides.</div>';
        header('Refresh:2; url=' . $pageRetour);
        exit();
    }

    // Validation du formulaire
    if (isset($postData['email']) && isset($postData['password'])) {
        $password = htmlspecialchars(strip_tags($postData['password']));
        $email = htmlspecialchars(strip_tags($postData['email']));
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                if ($user['password'] != $password) {
                    echo '<div class="alert alert-danger" role="alert">Mot de passe incorrect.</div>';
                    header('Refresh:2; url=' . $pageRetour);
                    exit();
                } else {
                    $loggedUser = [
                        'email' => $user['email'],
                        'full_name' => $user['full_name'],
                        'level' => $user['level'],
                    ];

                    /**
                     * Cookie qui expire dans un an : 365*24*3600
                     */
                    setcookie('LOGGED_USER', $loggedUser['email'], [
                        'expires' => time() + 300,
                        'secure' => true,
                        'httponly' => true,
                    ]);
                    setcookie('USER_NAME', $loggedUser['full_name'], [
                        'expires' => time() + 300,
                        'secure' => true,
                        'httponly' => true,
                    ]);
                    setcookie('USER_EMAIL', $loggedUser['email'], [
                        'expires' => time() + 300,
                        'secure' => true,
                        'httponly' => true,
                    ]);
                    setcookie('USER_EMAIL', $loggedUser['level'], [
                        'expires' => time() + 300,
                        'secure' => true,
                        'httponly' => true,
                    ]);

                    $_SESSION['LOGGED_USER'] = $loggedUser['email'];
                    $_SESSION['USER_NAME'] = $loggedUser['full_name'];
                    $_SESSION['USER_EMAIL'] = $loggedUser['email'];
                    $_SESSION['USER_LEVEL'] = $loggedUser['level'];

                    // header('Refresh:2; url=' . $pageRetour);
                    header('Location:' . $pageRetour);
                    exit();
                }
            } else {
                $errorMessage = sprintf(
                    'L\'email <em>%s</em> est inconnu.',
                    $postData['email']
                );
            }
        }
    }

    if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif;

    header('Refresh:3; url=' . $pageRetour);
    exit();
    ?>


