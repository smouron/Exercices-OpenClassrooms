<?php
// $_SESSION
session_start();

//Chargement des variables
include_once './variables.php';
?>

<!-- contact.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Formulaire de Contact</title>
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

        <h1>Contactez nous</h1>
        <hr>        
        <!-- 
            Dès l'instant où votre formulaire propose aux visiteurs d'envoyer un fichier, 
            il faut ajouter l'attribut enctype="multipart/form-data" 
        -->
            <form method="POST" action="<?php echo $rootUrl .
                'submit_contact.php' .
                $addOn2; ?>" enctype="multipart/form-data">
                <div class="mb-3 container-form-demi">
                    <div class="mb-3 form-48">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom"  aria-describedby="demande du nom">
                    </div>
                    <div class="mb-3 form-48">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" aria-describedby="demande du prénom">
                    </div>
                </div>
                <div class="mb-3 container-form-demi">
                    <div class="mb-3 form-48">
                        <label for="email" class="form-label">Email <em>*</em></label>
                        <input type="email" class="form-control" id="email" name="email" required="required" aria-describedby="demande de l'adresse mail">
                        <div id="email-help" class="form-text">Nous ne revendrons pas ces informations.</div>
                    </div>
                    
                    <div class="mb-3 form-48">
                        <label for="tel" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="tel" name="tel" maxlength="20" minlength="6" aria-describedby="demande le numéro de téléphone">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Votre message <em>*</em></label>
                    <textarea class="form-control" placeholder="Exprimez vous" id="message" name="message" required="required"></textarea>
                </div>
                <!-- Ajout champ d'upload ! -->
                <div class="mb-3">
                    <label for="screenshot" class="form-label">Votre capture d'écran</label>
                    <input type="file" class="form-control" id="screenshot" name="screenshot" />
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                    <input type="button" onclick="window.location.href='<?php echo $pageRetour; ?>'" class="btn btn-primary" value="Annuler" >
                </div>
                <p>Les champs indiqués par une <em>*</em> sont obligatoires</p>
            </form>     
        <br />
        <hr>
    </div>
    
    <!-- footer -->
    <?php include_once $rootPath . 'footer.php'; ?>
</body>
</html>
