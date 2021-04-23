<?php
require_once ("model.php");
if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion') {
    if ((isset($_POST['login']) && !empty($_POST['login'])) && (isset($_POST['pwd']) && !empty($_POST['pwd']))) {
            if (getMember($_POST['login'],$_POST['pwd'])!=false) {
                session_start();
                $_SESSION['infoMembre'] = getMember($_POST['login'],$_POST['pwd']);
                header('Location: espace-membre.php');
            }else {
            $erreur = 'Login ou mot de passe non reconnu !';
            echo $erreur; 
            echo"<br/><a href=\"index.html\">Accueil</a>";
            }
        }else {
$erreur = 'Errreur de saisie !<br/>Au moins un des champs est vide !'; 
echo $erreur; 
echo"<br/><a href=\"index.html\">Accueil</a>";
}
}
