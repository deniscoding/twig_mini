<?php
require_once 'vendor/autoload.php'; // Charge les librairies qui se trouvent dans vendor (installe par composer)


// CONTROLEUR

$loader = new Twig_Loader_Filesystem('./templates/'); // On va stocker tout nos html dans le repertoire templates/
$twig = new Twig_Environment($loader);

// on cree un tableau de tableau de student
$students = [
    [
        "name" => "Denis",
        "age" => "21"
    ],
    [
        "name" => "Tibo",
        "age" => "26"
    ]
];

// VUE
try {
    echo $twig->render('index.html', array("students" => $students)); // on charge la page index.html avec un tableau contenant nos tableaux associatifs
} catch (Exception $exception) {
    echo "Page non trouvee";
    die();
}

