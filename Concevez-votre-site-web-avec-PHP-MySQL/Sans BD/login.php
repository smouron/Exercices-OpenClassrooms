<?php

$postData = $_POST;

// Validation du formulaire
if (isset($postData['email']) && isset($postData['password'])) {
    foreach ($users as $user) {
        if (
            ($user['email'] === $postData['email'] ||
                $user['pseudo'] === htmlspecialchars($postData['pseudo'])) &&
            $user['password'] === $postData['password']
        ) {
            $loggedUser = [
                'email' => $user['email'],
                'full_name' => $user['full_name'],
            ];

            /**
             * Cookie qui expire dans un an : 365*24*3600
             */
            setcookie('LOGGED_USER', $loggedUser['full_name'], [
                'expires' => time() + 300,
                'secure' => true,
                'httponly' => true,
            ]);

            $_SESSION['LOGGED_USER'] = $loggedUser['full_name'];
        } else {
            $errorMessage = sprintf(
                'Les informations envoyées ne permettent pas de vous identifier : (%s/%s)',
                $postData['email'],
                $postData['password']
            );
        }
    }
}
?>

<!--
   Si utilisateur/trice est non identifié(e), on affiche le formulaire
-->
<?php if (!isset($_SESSION['LOGGED_USER'])): ?>
<form action="connexion.php" method="post">
    <!-- si message d'erreur on l'affiche -->
    <?php if (isset($errorMessage)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo</label>
        <input type="text" class="form-control" id="pseudo" name="pseudo" aria-describedby="pseudo-help" >        
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help" placeholder="you@exemple.com">
        <div id="email-help" class="form-text">L'email utilisé lors de la création de compte.</div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>
<!-- 
    Si utilisateur/trice bien connectée on affiche un message de succès
-->
<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour <?php echo $_SESSION[
            'LOGGED_USER'
        ]; ?> et bienvenue sur le site !
    </div>
<?php endif; ?>
