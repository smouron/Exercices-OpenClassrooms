
<?php
// Initialisation de la session.
// Si vous utilisez un autre nom
// session_name("autrenom")
session_start();

//Chargement des variables
include_once './variables.php';

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

// Détruit toutes les variables de session
$_SESSION = [];

// Si vous voulez détruire complètement la session, effacez également
// le cookie de session.
// Note : cela détruira la session et pas seulement les données de session !
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Finalement, on détruit la session.
session_destroy();

header('Location: ' . $pageRetour);
exit();


?>
