<?php
require_once('model.php');

// récupérer tous les Membres
function getMembersAsTable() {
	return json_encode(getAll());
}

// récupérer un member
function getAMemberById($id) {
    return json_encode(getMemberById($id));
}

function getAMemberByAProjet($idProjet){
    return json_encode(getMemberOfProjet($idProjet));
}

// ajouter un member
function addAMember($form) {
    $member = json_decode($form,true);
    return json_encode(addMember($member['nom'], $member['prenom'], $member['promo'], $member['discord'], $member['presentation']));
}

// modifier un member 
function updateAMember($form, $id) {
	$member = json_decode($form, true);
	return json_encode(updateMember($id, $member['nom'], $member['prenom'], $member['promo'], $member['discord'], $member['presentation']));
}

// supprimer un member
function deleteAMember($id){
    return json_encode(deleteMembre($id));
}
