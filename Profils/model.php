<?php
function connection() {
    try {
        $cnx = new PDO('mysql:host=localhost;dbname=groupimac', 'root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
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

function getAll() {
    $cnx = connection();
    $result = $cnx->query('select * from utilisateur');
    return $result->fetchall();
}

function getMemberById($id) {
    $cnx = connection();
    $rqt = $cnx->prepare('SELECT * FROM utilisateur WHERE idUser=?');
    $rqt->execute(array($id));
    return $rqt->fetch();
}

function getMemberOfProjet($idProjet){
    $cnx = connection();
    $rqt = $cnx->prepare('SELECT * FROM utilisateur INNER JOIN participe ON utilisateur.idUser = participe.RefUser INNER JOIN projet ON projet.idProjet = participe.RefProjet WHERE projet.idProjet = ?');
    $rqt->execute(array($idProjet));
    return $rqt->fetch();
}

function addMember($nom, $prenom, $promo, $discord, $presentation) {
    $cnx = connection();
    $rqt = $cnx->prepare('INSERT into utilisateur(nom,prenom,promo,discord,presentation) values(?,?,?,?,?)');
    $rqt->execute(array($nom, $prenom, $promo, $discord, $presentation));
    return getAll();
}

function deleteMembre($id){
    $cnx = connection();
    $rqt = $cnx->prepare('DELETE FROM utilisateur WHERE idUser=?');
    $rqt->execute(array($id));
    return getAll();
}

function updateMember($id, $nom, $prenom, $promo, $discord, $presentation){
    $cnx = connection();
    $rqt = $cnx->prepare("UPDATE utilisateur SET nom=?, prenom=?, promo=?, discord=?, presentation=? WHERE idUser=?");
    $rqt->execute(array($nom, $prenom, $promo, $discord, $presentation, $id));
    return getMemberByID($id);
}
?>
