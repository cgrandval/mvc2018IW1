<?php

function myAutoloader($class)
{
    $classname = substr($class, strpos($class, '\\' +1));
    $classPath = 'core/'.$classname.'.class.php';
    $classModel = 'models/'.$classname.'.class.php';
    $classVO = 'VO/'.$classname.'.php';

    if (file_exists($classPath)) {
        include $classPath;
    } elseif (file_exists($classModel)) {
        include $classModel;
    } elseif (file_exists($classVO)) {
        include $classVO;
    }
}

//Cela veut dire que si j'essaye d'instancier une class qui n'existe pas
//La fonction myAutoloader va être lancée
spl_autoload_register('myAutoloader');

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

$routes = \Core\Routing::getRoute($slug);
extract($routes);

$container = [];
$container['config'] = require 'config/global.php';
$container += require 'config/di.global.php';

//vérifier l'existence du fichier et de la class controller
if (file_exists($cPath)) {
    include $cPath;
    if (class_exists('\\Controller\\' . $c)) {
        //instancier dynamiquement le controller
        $cObject = $container['Controller\\' . $c]($container);

        //vérifier que la méthode (l'action) existe
        if (method_exists($cObject, $a)) {
            //appel dynamique de la méthode
            $cObject->$a();
        } else {
            die('La methode '.$a." n'existe pas");
        }
    } else {
        die('La class controller '.$c." n'existe pas");
    }
} else {
    die('Le fichier controller '.$c." n'existe pas");
}
