<?php session_start(); ?>

<!-- contact.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Formulaire de Contact</title>
    <link
        href="bootstrap.min.css" 
        rel="stylesheet"
    >
    <link
        href="style.css" 
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php include_once 'header.php'; ?>
        <h1>Contactez nous</h1>
        <hr>        
        <!-- 
            Dès l'instant où votre formulaire propose aux visiteurs d'envoyer un fichier, 
            il faut ajouter l'attribut enctype="multipart/form-data" 
        -->
            <form method="POST" action="submit_contact.php" enctype="multipart/form-data">
                <div class="mb-3 container-form-demi">
                    <div class="mb-3 form-demi">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="nom" class="form-control" id="nom" name="nom"  aria-describedby="demande du nom">
                    </div>
                    <div class="mb-3 form-demi">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="prenom" class="form-control" id="prenom" name="prenom" aria-describedby="demande du prénom">
                    </div>
                </div>
                <div class="mb-3 container-form-demi">
                    <div class="mb-3 form-demi">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="demande de l'adresse mail">
                        <div id="email-help" class="form-text">Nous ne revendrons pas ces informations.</div>
                    </div>
                    
                    <div class="mb-3 form-demi">
                        <label for="tel" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="tel" name="tel" maxlength="20" minlength="6" aria-describedby="demande le numéro de téléphone">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Votre message</label>
                    <textarea class="form-control" placeholder="Exprimez vous" id="message" name="message"></textarea>
                </div>
                <!-- Ajout champ d'upload ! -->
                <div class="mb-3">
                    <label for="screenshot" class="form-label">Votre capture d'écran</label>
                    <input type="file" class="form-control" id="screenshot" name="screenshot" />
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>     
        <br />
        <hr>
    </div>

     <?php include_once 'footer.php'; ?>
</body>
</html>
