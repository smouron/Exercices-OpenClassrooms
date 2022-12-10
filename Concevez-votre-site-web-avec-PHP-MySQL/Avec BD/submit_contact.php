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
    <title>Site de recettes - validation du message</title>    
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

    $postData = $_POST;
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
    ?>

    <h1>Rappel de vos informations</h1>	
        
    <div class="card">    
        <div class="card-body">
            <h5 class="card-title">Message bien reçu !</h5>
            <?php
            // Contrôle si on a bien reçu une donnée
            if (!isset($postData)) {
                echo '<div class="alert alert-danger" role="alert">Données manquantes ou invalides.</div>';
                header('Refresh:3; url=' . $pageRetour);
                return;
            }

            // Controle si on a un Nom
            if (isset($postData['nom'])) {
                //  htmlspecialchars : modifie les balises HTML pour qu'elles ne soient pas traitées comme balises
                //  strip_tags : retire les balaises HTML
                $userName = htmlspecialchars(strip_tags($postData['nom']));
                echo '<p class="card-text"><b>Nom</b> : ' . $userName . '</p>';
            }

            // Controle si on a un Prénom
            if (isset($postData['prenom'])) {
                $firstName = htmlspecialchars(strip_tags($postData['prenom']));
                echo '<p class="card-text"><b>Prenom</b> : ' .
                    $firstName .
                    '</p>';
            }

            // Controle si on a un email
            if (!isset($postData['email'])) {
                echo '<div class="alert alert-danger" role="alert">Votre adresse mail est manquante !!!</p></div>';
                header('Refresh:2; url=' . $pageRetour);
                return;
            } elseif (
                !filter_var($postData['email'], FILTER_VALIDATE_EMAIL) ||
                empty($postData['email'])
            ) {
                // Contrôle que l'adresse mail est valide et pas vide
                echo '<div class="alert alert-danger" role="alert">Votre adresse mail est invalide ou manquante !!!</p></div>';
                header('Refresh:2; url=' . $pageRetour);
                return;
            } else {
                echo '<p class="card-text"><b>Email</b> : ' .
                    strip_tags($postData['email']) .
                    '</p>';
            }

            if (!isset($postData['message']) || empty($postData['message'])) {
                // Contrôle que le message n'est pas vide
                echo '<div class="alert alert-danger" role="alert">Le message est manquant.</p></div>';
                header('Refresh:2; url=' . $pageRetour);
                return;
            } else {
                //  htmlspecialchars : modifie les balises HTML pour qu'elles ne soient pas traitées comme balises
                //  strip_tags : retire les balaises HTML
                echo '<p class="card-text"><b>Message</b> : ' .
                    strip_tags($postData['message']) .
                    '</p>';
            }

            if (
                isset($_FILES['screenshot']) &&
                $_FILES['screenshot']['error'] == 0
            ) {
                $fileInfo = pathinfo($_FILES['screenshot']['name']);
                $extension = $fileInfo['extension'];
                $taille = $_FILES['screenshot']['size'] / 1000;
                // pathinfo renvoi un tableau (array) contenant entre autres l'extension du fichier
                // echo '<p class="card-text"><b>pathinfo</b> : ' .
                //     print_r($fileInfo) .
                //     '</p>';
                // echo '<p class="card-text"><b>$_FILES</b> : ' .
                //     print_r($_FILES) .
                //     '</p>';
                echo '<p class="card-text"><b>Caractéristiques du fichier joint</b> : </p>';
                echo '<p class="card-text">';
                echo 'Nom du fichier : ' .
                    $_FILES['screenshot']['name'] .
                    ' <br />';
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
                echo 'Code erreur : ' .
                    $_FILES['screenshot']['error'] .
                    '<br />';
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
                            './uploads/' .
                                basename($_FILES['screenshot']['name'])
                        );

                        echo $rootUrl .
                            'uploads/' .
                            basename($_FILES['screenshot']['name']);
                        // $fileInfo['basename'] <==> basename($_FILES['screenshot']['name'])
                        echo '<div class="alert " role="alert">L\'envoi du fichier image"' .
                            $fileInfo['basename'] .
                            '" a bien été effectué !</div>';

                        header('Refresh:2; url=' . $pageRetour);
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Le fichier n\'est pas une image.</div>';
                        header('Refresh:2; url=' . $pageRetour);
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Le fichier est trop gros.</div>';
                    header('Refresh:2; url=' . $pageRetour);
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Il n\'y a pas de fichier image.</p></div>';
                header('Refresh:2; url=' . $pageRetour);
            }

            return;
            ?>
        </div>
       
    </div>
    
    <!-- footer -->
    <?php
    include_once $rootPath . 'footer.php';

    // redirection var la page home
    // header('Location: ./../home.php');
    header('Refresh:2; url=' . $pageRetour);
    ?>
</body>
</html>