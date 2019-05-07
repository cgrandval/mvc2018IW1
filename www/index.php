<?php

use Mvc\Core\Routing;

spl_autoload_register(function ($class) {
    $prefix = 'Mvc\\';
    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

//Récuperer l'url apres le nom de domaine
//Utilisation d'une variable SUPER GLOBALE
//Accessible partout, commenence par $_ et en majuscule
//c'est toujours un tableau
//Elle est créée par le serveur et alimenté par le serveur
//Vous ne pouvez que la consulter

$slug = $_SERVER['REQUEST_URI'];

//pour palier aux paramètres GET
$slugExploded = explode('?', $slug);
$slug = $slugExploded[0];

$routes = Routing::getRoute($slug);
extract($routes);

$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

//instancier dynamiquement le controller
$cObject = $container['Mvc\\Controllers\\' . $c]($container);

//vérifier que la méthode (l'action) existe
if (method_exists($cObject, $a)) {
    //appel dynamique de la méthode
    $cObject->$a();
} else {
    die('La methode '.$a." n'existe pas");
}
