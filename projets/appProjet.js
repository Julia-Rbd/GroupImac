/* ============== NE PAS TOUCHER ============== */ 

Document.prototype.ready = callback => {
	if(callback && typeof callback === 'function') {
		document.addEventListener("DOMContentLoaded", () =>  {
			if(document.readyState === "interactive" || document.readyState === "complete") {
				return callback();
			}
		});
	}
};

/* ============== AFFICHER TOUS LES PROJETS ============== */ 

// Ce qu'on voit au lancement de la page projet  
document.ready( () => {
	// certaines zones sont cachées (activables par bouton)
	document.getElementById('voirProjet').style.display = 'none';
	document.getElementById('upProjet').style.display = 'none';

	// récupération de tous les projets 
	fetch("./router.php/projets", {  method: 'GET'})
		.then( response => response.json() )
		.then( data => {
			// affichage des projets 
			displayProjet(data);
		})
		.catch(error => { console.log(error) });
});

// affiche tous les projets sous forme de table (pour l'instant) : 
// Titre | Bouton "en savoir plus" 
function displayProjet(projets) {
	const list = document.getElementById('allProjets');
	let content = "<table>";
	projets.forEach(function (projet) {
		content += "<tr><td>" + projet.titre + "</td><td><button onclick='voirProjet(\"" + projet.idProjet + "\")'>En savoir plus</button></td></tr>";
	});
	content += "</table>";
	list.innerHTML = content;
}


/* ============== PUBLIER PROJET ============== */ 

document.getElementById('publier').onclick = event => {
	// Empêcher le rechargement de la page 
	event.preventDefault();

	// récupère données du form d'ajout
	form = recupForm('input');

	// POST du projet 
	fetch('./router.php/projets', { method: 'POST', body: JSON.stringify(form)})    
	.then(response => response.json())
    .then (data =>{
			// maj de la liste des projets 
			displayProjet(data);
			
			// réinitialisation des champs du formulaire 
			reinitialiseForm('input');
		
			// A FAIRE (plus tard) : message de vérif type "votre projet a bien été publié. Voir l'annonce."
	})
	.catch(error => { console.log(error) });

}


/* ============== VOIR UN PROJET ============== */ 

// grâce à l'id, récupère le projet à visualiser
function voirProjet(id) {
	// activation de la div "voir projet"
	showDiv("voirProjet");

	// récupération des données du projet associé à l'ID 
	fetch("./router.php/projet/" + id, { method: 'GET'})
	.then(response => response.json())
	.then (data =>{
		// affichage du projet concerné 
		displayOneProject(data);

		// réinitialisation du form de modification (pour le refermer quand on change de projet)
		document.getElementById('upProjet').style.display = 'none';

		// réinitialisation du form de modification 
		reinitialiseForm("update");

	})
	.catch(error => { console.log(error) });
}

// Affiche champs du projet 
function displayOneProject(projet) {

	// remplit les champs de la div "voir projet" par les données du projet voulu 
	document.getElementById('titre').innerHTML = projet.titre;
	document.getElementById('datePubli').innerHTML = projet.datePubli;
	document.getElementById('desc').innerHTML = projet.presentation;
	document.getElementById('deadline').innerHTML = projet.deadline;
	document.getElementById('cadre').innerHTML = projet.cadre;

	// affichage boutons "modifier" et "supprimer" 
	let modif ="<button id='modifier' onclick='recupProjetToUpdate(\""+projet.idProjet +"\")'>Modifier</button>";
	let suppr = "<button onclick='removeProjet(\""+projet.idProjet +"\")'>Supprimer</button>";
	document.getElementById('boutons').innerHTML = modif + suppr;
}


/* ============== MODIFIER UN PROJET ============== */ 

// récupère le projet à modifier
function recupProjetToUpdate(id) {
	// active la div "modifier projet"
	showDiv("upProjet");

	// récupération des données associées au projet à modifier 
	fetch("./router.php/projet/" + id, { method: 'GET'})
	.then(response => response.json())
	.then (data =>{
		// affichage des données actuelles du projet à modifier 
		displayProjetToUpdate(data);

	})
	.catch(error => { console.log(error) });

}

// préremplit le form avec les données actuelles du projet à modifier 
function displayProjetToUpdate(projet) {
	document.getElementById('update-titre').value = projet.titre;
	document.getElementById('update-presentation').value = projet.presentation;	
	document.getElementById('update-deadline').value = projet.deadline;	
	document.getElementById('update-cadre').value = projet.cadre;	

	// crée bouton pour renvoyer l'id du projet à modifier 
	document.getElementById('boutonsUpdate').innerHTML = "<button onclick='modifProjet(\"" + projet.idProjet + "\")' id='enreg-modif'>Enregistrer les modifications</button>";
}

// envoi des modifications du projet (semblable à la fonction pour POST)
function modifProjet(id) {
	event.preventDefault();
    
	// récupère les données du form de modif
	form = recupForm('update');

	// envoi des modifications au serveur 
	fetch('./router.php/projet/' + id, { method: 'UPDATE', body: JSON.stringify(form)})    
	.then(response => response.json())
    .then (data =>{
			// maj de la liste des projets 
			displayProjet(data);

			// réinitialisation du form de modification & cache de la visu du projet
			reinitialiseForm("update");
			document.getElementById('upProjet').style.display = 'none';
			document.getElementById('voirProjet').style.display = 'none';

			// A FAIRE : message de vérif type "votre projet a bien été modifié. Voir l'annonce."

	})
	.catch(error => { console.log(error) });
}

/* ============== SUPPRIMER UN PROJET ============== */ 

function removeProjet(id) {
	event.preventDefault();

	fetch("./router.php/projet/" + id, { method: 'DELETE'})
	.then(response => response.json())
	.then (data =>{
		// maj liste projets 
		displayProjet(data);

		// réinitialisation de la div "voir projet"
		document.getElementById('voirProjet').style.display = 'none';
		document.getElementById('boutons').innerHTML = '';
	})
	.catch(error => { console.log(error) });
}


/* ============== FONCTIONS ANNEXES ============== */ 

// afficher les divs cachées 
function showDiv(id) {
	document.getElementById(id).style.display = 'contents';	
}

function recupForm(string) {
    const form = {};
	
    /* Profil (si pas de session) */ 

    // form.prenom = document.getElementById('input-prenom').value;
	// form.nom = document.getElementById('input-nom').value;
	// form.promo = document.getElementById('input-promo').value;
	// form.discord = document.getElementById('input-discord').value;

    /* Projet */
	form.titre = document.getElementById(string + '-titre').value;
	form.presentation = document.getElementById(string + '-presentation').value;
	form.deadline = document.getElementById(string + '-deadline').value;
	form.cadre = document.getElementById(string + '-cadre').value;
	
	/*  A voir comment on se débrouille avec ça 
		form.jeRecherche = document.getElementById('input-jeRecherche').value;
        form.membres = document.getElementById('input-membres').value; 
	*/

	return form;
}

// réinitialise les formulaires 
function reinitialiseForm(string) {
	document.getElementById(string + '-titre').value = "";
	document.getElementById(string + '-presentation').value = "";
	document.getElementById(string + '-deadline').value = "";
	document.getElementById(string + '-cadre').value = "";
}