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
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

    <?php include_once 'header.php'; ?>
        <h1>Contactez nous</h1>
        <hr>
        <fieldset>
		<legend>Formulaire envoyé avec la méthode <strong>_POST</strong></legend>
            <form method="POST" action="submit_contact_Post.php">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="nom" class="form-control" id="nom" name="nom"  aria-describedby="demande du nom">
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="prenom" class="form-control" id="prenom" name="prenom" aria-describedby="demande du prénom">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="demande de l'adresse mail">
                    <div id="email-help" class="form-text">Nous ne revendrons pas votre email.</div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Votre message</label>
                    <textarea class="form-control" placeholder="Exprimez vous" id="message" name="message"></textarea>
                </div>
                <div class="mb-3">
                <input name="pseudo" value="pseudo Mateo21" />
                </div>
                <button type="submit" class="btn btn-primary" method="post">Envoyer</button>
            </form>
        </fieldset>
        <br />
        <hr>
        <fieldset>
		<legend>Formulaire envoyé avec la méthode <strong>_GET</strong></legend>
            <form method="GET" action="submit_contact_Get.php">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="nom" class="form-control" id="nom" name="nom"  aria-describedby="demande du nom">
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="prenom" class="form-control" id="prenom" name="prenom" aria-describedby="demande du prénom">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="demande de l'adresse mail">
                    <div id="email-help" class="form-text">Nous ne revendrons pas votre email.</div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Votre message</label>
                    <textarea class="form-control" placeholder="Exprimez vous" id="message" name="message"></textarea>
                </div>
                <div class="mb-3">
                <input name="pseudo" value="pseudo Mateo21" />
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </fieldset>
        <br />
        <hr>
    </div>

     <?php include_once 'footer.php'; ?>
</body>
</html>
