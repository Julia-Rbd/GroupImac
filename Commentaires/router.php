<?php
require_once('controller.php');

$chemin = explode('/', $_SERVER['REQUEST_URI']);
$method = $_SERVER['REQUEST_METHOD'];

// NOTE: Il faudra chager l'offset ajoute a $i selon la taille du prefixe dans l'url
$page = function ($i) use ($chemin) {
  $id = $i + 4;
  if (isset($chemin[$id])) {
    return $chemin[$id];
  } else {
    return null;
  }
};

switch($page(0)) {
case 'commentaires' : 
  $com_id = $page(1);
  if (is_null($com_id)) {
    switch($method) {
    case 'GET':
      $parametres = parse_str($_SERVER['QUERY_STRING']);
      if (isset($parametres['projet'])) {
        echo afficherCommentairesDuProjet($parametres['projet']);
      } else {
        http_response_code('400');
      }
      break;

    case 'POST':
      $commentaire = file_get_contents('php://input');
      echo ajouterCommentaire($commentaire);
      break;

    default:
      http_response_code('405');
      header('Allow', 'GET,POST');
    }
  } else {
    switch ($method) {
    case 'DELETE':
      if (!supprimerCommentaire($com_id)) {
        http_response_code();
      }
      break;
    case 'PATCH':
      $contenu = file_get_contents('php://input');
      if (!modifierCommentaire($com_id, $contenu)) {
        http_response_code('500');
      }
      break;
    default:
      http_response_code('405');
      header('Allow', 'DELETE,PATH');
    }
  }
  break;
default: 
  http_response_code('404');
  break;
}



?>
