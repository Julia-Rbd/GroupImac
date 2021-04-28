<?php
	require_once('modelProjet.php');
	
	// récupérer tous les projets
	function getProjetsAsTable() {
		return json_encode(getAll());
	}

	// récupérer un seul projet avec son id
	function getAProjetByID($id) {
		return json_encode(getProjetByID($id));
	}

	// ajouter un projet
	function addAProjet($form) {
		$projet = json_decode($form, true);

		// A FAIRE : RENTRER FORMULAIRE COMPLET 
		return json_encode(addProjet($projet['titre'], $projet['presentation'], $projet['deadline'], $projet['cadre']));
	}

	// supprimer un projet 
	function deleteAProjet($id) {
		return json_encode(deleteProjet($id));
	}

	// modifier un projet 
	function updateAProjet($form, $id) {
		$projet = json_decode($form, true);

		// A FAIRE : RENTRER FORMULAIRE COMPLET 
		return json_encode(updateProjet($id, $projet['titre'], $projet['presentation'], $projet['deadline'], $projet['cadre']));
	}