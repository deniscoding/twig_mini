Author : Denis Ma

Installation de Twig pour PHP
Documentation: https://twig.symfony.com/ <== a lire pour comprendre pourquoi un moteur de template est cool.

Premierement, installer **composer**.  
_Composer est un installeur de package/lib pour php, un peu comme brew pour mac ou apt pour debian._  
D'apres la doc de composer : https://getcomposer.org/download/ ==> Se rendre dans le repertoire du projet

    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    sudo php composer-setup.php  # J'ai du le faire en sudo, mais peut etre pas pour tout le monde
    php -r "unlink('composer-setup.php');"

Ceci va creer un script composer.phar qui va permettre d'installer des librairies php dont twig.

**Installation de twig v2**

    ./composer.phar require twig/twig:~2.0
    
Une fois l'installation faite, le repertoire vendor contenant twig a ete cree, et un fichier composer.json et composer.lock aussi. (Ce sont des fichiers qui groupe tout les lib installees)  
Il se peut qu'il manque des libs essentiels pour utiliser twig, (composer affichera en erreur quels sont les dependances non respectes)  
J'ai du par exemple installer avec apt-get : php-xml et php-mbstring


**Utilisation de twig**  
- Le but est de separer les codes php (controleur) du code html (vue)  

Dans le fichier php qui est appele (ex: index.php):   <== controller

    <?php
     require_once 'vendor/autoload.php'; // Charge les librairies qui se trouvent dans vendor (installe par composer)
     
     
     // CONTROLEUR
     
     $loader = new Twig_Loader_Filesystem('./templates/'); // On considere que nos fichier html se trouvent dans templates/
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
     
     
     
Le contoleur va appeler un fichier html avec twig avec les variables necessaires,  (ex : templates/index.html):  

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Moteur de template TWIG</title>
    </head>
    <body>

    <!-- A la place d'ecrire <?php while etc etc ?>, on va utiliser twig pour avoir un meilleur visuel -->
    <!-- la variables students est un tableau avec plusieurs valeurs, donc on va boucler  -->
    <p><h1>Code avec Twig</h1></p>
    <p>
        <ul>
        {% for student in students %} <!-- foreach version twig -->
            <li>
                {% if student.name == "Tibo" %}
                    <strong>Mochi Mochi</strong> {{ student.name }} qui a {{ student.age }} ans.
                {% else %}
                    Hello {{ student.name }} qui a {{ student.age }} ans.
                {% endif %}

            </li>
        {% endfor %}                   <!-- fin du for -->
        </ul>
    </p>


    <!-- Ce que ca aurait donner avec du pure PHP :) -->
    <!--	<p><h1>Code avec php</h1></p>
        <p>
            <ul>
                <?php foreach($students as $student) { ?>
                    <li>
                        <?php if($student["name"] == "Tibo" ?>
                            <strong>Mochi Mochi</strong> <?= $student["name"] ?> qui a <?= $student["age"] ?> ans.
                        <?php else: ?>
                            Hello <?= $student["name"] ?> qui a <?= $student["age"] ?> ans.
                        <?php endif ?>
                    </li>
                <?php } ?>
            </ul>
        </p>-->

    </body>
    </html>

