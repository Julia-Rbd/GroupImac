<?php
require_once ("model.php");
if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription') {
   if ((isset($_POST['prenom']) && !empty($_POST['prenom'])) && (isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['mdp1']) && !empty($_POST['mdp1'])) && (isset($_POST['mdp2']) && !empty($_POST['mdp2'])) && (isset($_POST['promo']) && !empty($_POST['promo']))) 
   {
      if ($_POST['mdp1'] != $_POST['mdp2']) 
      {
         $erreur = 'Les 2 password sont differents.';
         echo $erreur; 
         echo"<br/><a href=\"index.html\">Accueil</a>";
         exit();
      }else {	
      //si les deux mots de passe sont identiques, on se connecte à la bdd
         if (addMember($_POST['nom'],$_POST['prenom'],$_POST['mdp1'],$_POST['promo'])) {
            session_start();
            $_SESSION['infoMembre'] = getMember($_POST['prenom'],$_POST['mdp1']);
            header('Location: espace-membre.php');
         }else {
            $erreur = 'Echec de l\'inscription !<br/>Un membre possede deja ce login !';
            echo $erreur; 
            echo"<br/><a href=\"index.html\">Accueil</a>";
         }
      }
   //Si au moins un des champs est vide
   }else {
   $erreur = 'Echec de l\'inscription !<br/>Au moins un des champs est vide !';
   echo $erreur; 
   echo"<br/><a href=\"index.html\">Accueil</a>";
   }
}
?>

