Document.prototype.ready = callback => {
    if (callback && typeof callback === 'function') {
        document.addEventListener("DOMContentLoaded", () => {
            if (document.readyState === "interactive" || document.readyState === "complete") {
                return callback();
            }
        });
    }
};

document.ready(() => {
    document.querySelector("#addForm").style.display = 'none';
    document.getElementById("upProfil").style.display = 'none';
    console.log("test");
    fetch("./router.php/profils", { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            DisplayAll(data);
        })
        .catch(error => { console.log(error) });
});

function DisplayAll(profils) {
    let contents = "<ul>";
    profils.forEach(function(profil) {
        contents += "<li>" + profil.nom + " " + profil.prenom + " <button onclick='voirProfil(\"" + profil.idUser + "\")'>Voir ce profil</button></li>"
    });
    contents += "</ul>";
    document.querySelector("#ListProfils").innerHTML = contents;
}

/* ============== Ajout profil ============== */

document.getElementById('ajouter').onclick = event => {
    event.preventDefault();

    form = recupForm('add');

    fetch('./router.php/profils', { method: 'POST', body: JSON.stringify(form) })
        .then(response => response.json())
        .then(data => {
            DisplayAll(data);

            reinitialiseForm('add');

        })
        .catch(error => { console.log(error) });
    document.querySelector("#addForm").style.display = 'none';
    window.alert("Profil ajouté");
}

/* ============== VOIR UN PROFIL ============== */

function voirProfil(id) {
    fetch("./router.php/profil/" + id, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            displayProfil(data);
            reinitialiseForm("update");
        })
        .catch(error => { console.log(error) });
}

function displayProfil(Profil) {
    document.getElementById('NomPrenomProfil').innerHTML = Profil.nom + " " + Profil.prenom;
    document.getElementById('info').innerHTML = "<p>" + Profil.presentation + "</p>";

    let modif = "<button id='modifier' onclick='recupProfilToUpdate(\"" + Profil.idUser + "\")'>Modifier</button>";
    let suppr = "<button onclick='removeProfil(\"" + Profil.idUser + "\")'>Supprimer</button>";
    document.getElementById('boutons').innerHTML = modif + suppr;
}

/* ============== MODIFIER UN Profil ============== */

function recupProfilToUpdate(id) {
    showDiv("upProfil");

    fetch("./router.php/profil/" + id, { method: 'GET' })
        .then(response => response.json())
        .then(data => {
            displayProfilToUpdate(data);
        })
        .catch(error => { console.log(error) });

}

function displayProfilToUpdate(Profil) {
    document.getElementById('update-prenom').value = Profil.prenom;
    document.getElementById('update-nom').value = Profil.nom;
    document.getElementById('update-presentation').value = Profil.presentation;
    document.getElementById("update-promo").options.selectedIndex = Profil.promo.charAt(4);
    document.getElementById('update-discord').value = Profil.discord;

    document.getElementById('boutonModifier').innerHTML = "<button onclick='modifProfil(\"" + Profil.idUser + "\")' id='enreg-modif'>Enregistrer les modifications</button>";
}

function modifProfil(id) {
    event.preventDefault();
    form = recupForm('update');

    fetch('./router.php/profil/' + id, { method: 'UPDATE', body: JSON.stringify(form) })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            displayProfil(data);

            reinitialiseForm("update");
            document.getElementById('upProfil').style.display = 'none';

        })
        .catch(error => { console.log(error) });
    window.alert("Profil modifié");
}

/* ============== SUPPRIMER PROFIL ============== */

function removeProfil(id) {
    event.preventDefault();

    fetch("./router.php/profil/" + id, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            DisplayAll(data);
            document.getElementById('profil').style.display = 'none';
        })
        .catch(error => { console.log(error) });
    window.alert("Profil supprimé");
}


/* ============== FONCTIONS ANNEXES ============== */

function showDiv(id) {
    document.getElementById(id).style.display = 'contents';
}

function recupForm(string) {
    const form = {};
    form.nom = document.getElementById(string + '-nom').value;
    form.prenom = document.getElementById(string + '-prenom').value;
    form.promo = document.getElementById(string + '-promo').value;
    form.discord = document.getElementById(string + '-discord').value;
    form.presentation = document.getElementById(string + '-presentation').value;
    return form;
}

function reinitialiseForm(string) {
    document.getElementById(string + '-nom').value = "";
    document.getElementById(string + '-prenom').value = "";
    document.getElementById(string + '-promo').value = "";
    document.getElementById(string + '-discord').value = "";
    document.getElementById(string + '-presentation').value = "";
}