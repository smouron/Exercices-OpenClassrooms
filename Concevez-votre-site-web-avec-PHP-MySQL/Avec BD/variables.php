<?php
// variables.php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
$rootAddr = $_SERVER['SERVER_ADDR'];
$rootFilePath = $_SERVER['SCRIPT_FILENAME'];
$rootFileName = $_SERVER['SCRIPT_NAME'];
$fileName = basename($rootFileName);
// $root = strtr($_SERVER['SCRIPT_NAME'], $trans);
$rootFileUri = $_SERVER['REQUEST_URI'];
$rootFile = $_SERVER['PHP_SELF'];
$rootUrl =
    (!empty($_SERVER['HTTPS']) ? 'https' : 'http') .
    '://' .
    $_SERVER['HTTP_HOST'] .
    '/';

$rootAdd = 'OpenClassRooms/Avec BD/';
$rootUrl = $rootUrl . $rootAdd;
$rootPath = $rootPath . '/' . $rootAdd;

$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

//Array ( [dirname] => /some/path [basename] => toto.test [extension] => test [filename] => toto )
$pathinfo = pathinfo('/some/path/toto.test');
?>
