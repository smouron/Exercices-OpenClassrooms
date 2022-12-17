<?php
header('Content-type: text/html; charset=UTF-8');
const MYSQL_HOST = 'localhost';
const MYSQL_PORT = 3306;
// const MYSQL_NAME = 'partage_de_recettes';
// const MYSQL_USER = 'root';
// const MYSQL_PASSWORD = '';
const MYSQL_NAME = 'fgaa_partage_de_recettes';
const MYSQL_USER = 'fgaa_sanoe';
const MYSQL_PASSWORD = 'QD4k-8rv0OfC4';

// try : essaye d'executer le code qui suit
// si ERREUR il execute catch
// ici cath arrête le code et affiche un message indiquant l'erreur
try {
    $db = new PDO(
        //'mysql:host=localhost;dbname=partage_de_recettes;charset=utf8';port=3306,
        sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=utf8',
            MYSQL_HOST,
            MYSQL_NAME,
            MYSQL_PORT
        ),
        MYSQL_USER,
        MYSQL_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
// [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
// ==> fait afficher les erreurs Sql en clair
?>
