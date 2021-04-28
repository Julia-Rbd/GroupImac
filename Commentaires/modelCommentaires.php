<?php
		
	/* Connexion BDD (version améliorée pour avoir description des erreurs SQL) */ 
function connection() {
  try {
    $cnx = new PDO('pgsql:host=localhost;dbname=groupimac', 'postgres','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    /* 
      nom de la base : groupimac
      pseudo : 'root'
      mot de passe : '' 
    */
  } 
  catch (PDOException $e) {
    echo 'Échec de la connexion : ' . $e->getMessage();
    exit;
  }
  if(!$cnx) {
    die('Connection failed');
  }
  return $cnx;
}

// retourne la liste des commentaires d'un projet
// sous forme de tableau associatif
function getCommentsOfProject($id) {
    $cnx = connection();
	$rqt = $cnx->prepare('SELECT * FROM Commentaire WHERE idProjet = ?');
	$rqt->execute(array($id));
    return $rqt->fetchAll();
}

// ajoute un commentaire, retourne false si la requete echoue
function addComment($message, $author_id, $project_id) {
    $cnx = connection();
    $rqt = $cnx->prepare('insert into Commentaire (message, RefUser, RefProjet, dateComment) values (?,?,?, NOW())');
    return $rqt->execute(array($message, $author_id, $project_id));
}

// supprime un commentaire, retourne false si la requete echoue
function deleteComment($comment_id) {
    $cnx = connection();
    $rqt = $cnx->prepare('delete from Commentaire where idCommentaire=?');
	return $rqt->execute(array($comment_id));
}

// modifie un commentaire, retourne false si la requete echoue
function modifComment($comment_id, $new_message) {
  $co = connection();
  $req = $co->prepare("update Commentaire set message = ? where idComment = ?");
  return $req->execute(array($new_message, $comment_id));
}
