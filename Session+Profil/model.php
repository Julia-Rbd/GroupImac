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

function getMember($login,$pwd) {
    $cnx = connection();
    $rqt = $cnx->prepare('SELECT * FROM utilisateur WHERE prenom=? AND mdp=?');
    $rqt->execute(array($login,md5($pwd)));
    $nbrep=$rqt->rowCount();
    if ($nbrep==0) {
        return false;
    } else {
        return $rqt->fetch(PDO::FETCH_ASSOC);
    }
}

function addMember($nom, $prenom, $mdp, $promo) {
    $cnx = connection();
    $rqt = $cnx->prepare('INSERT into utilisateur(nom,prenom,mdp,promo) values(?,?,?,?)');
    $rqt->execute(array($nom, $prenom, md5($mdp), $promo));
    return $rqt;
}
?>
