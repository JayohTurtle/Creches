/**
* Fonction pour afficher un message de succès à l'utilisateur.
*/
function afficherMessageSucces(message) {
let messageBox = document.createElement("div")
messageBox.textContent = message
messageBox.style.position = "fixed"
messageBox.style.top = "20px"
messageBox.style.right = "20px"
messageBox.style.backgroundColor = "#4CAF50"
messageBox.style.color = "white"
messageBox.style.padding = "10px 20px"
messageBox.style.borderRadius = "5px"
messageBox.style.zIndex = "1000"
document.body.appendChild(messageBox)

setTimeout(() => {
    messageBox.remove()
}, 3000)
}

// Ajout de la gestion du formulaire d'ajout de commentaire
const formAjoutComment = document.querySelector("#addCommentForm")

if (formAjoutComment) {
formAjoutComment.addEventListener("submit", function (e) {
    e.preventDefault() // Empêcher le rechargement de la page par défaut

    // Récupérer les données du formulaire
    let formData = new FormData(this)

    fetch("index.php?action=ajoutComment", {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`)
        }
        return response.text()  // Récupérer la réponse brute
    })
    .then(text => {
        try {
            return JSON.parse(text)  // Tenter de parser en JSON
        } catch (error) {
            throw new Error("La réponse du serveur n'est pas un JSON valide : " + text)
        }
    })
    .then(data => {
        if (data.status === "success") {
            fermerPopup("popupAjoutComment")
            afficherMessageSucces("Commentaire ajouté avec succès !")
            window.location.reload(false)  // Rafraîchir la page
        } else {
            console.error("❌ Erreur serveur :", data.message)
            afficherMessageErreur(data.message)
        }
    })
    .catch(error => {
        console.error("❌ Problème avec la requête fetch :", error)
        afficherMessageErreur("Une erreur est survenue. Veuillez réessayer.")
    })
})
}

//Ajout de la gestion du popUp ajoutInteretPrecis

// 🔹 Fonction pour mettre à jour la visibilité des inputs
function updateVisibleInputChoixInteretPrecis() {
const inputChoixInteretCreche = document.getElementById("inputChoixInteretCreche")
const inputChoixInteretGroupe = document.getElementById("inputChoixInteretGroupe")
const choixInteretCreche = document.getElementById("choixInteretCreche")
const choixInteretGroupe = document.getElementById("choixInteretGroupe")

if (choixInteretCreche.checked) {
    inputChoixInteretCreche.classList.remove("d-none")
    inputChoixInteretGroupe.classList.add("d-none")
} else if (choixInteretGroupe.checked) {
    inputChoixInteretCreche.classList.add("d-none")
    inputChoixInteretGroupe.classList.remove("d-none")
}
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
document.getElementById("boutonAjoutInteretCreche").addEventListener("click", function() {
setTimeout(() => {
    let element = document.getElementById("popupAjoutInteretCreche")
    if (element) {
        updateVisibleInputChoixInteretPrecis()
    } else {
        console.warn("L'élément n'est pas encore disponible !")
    }
}, 100) // Petit délai pour s'assurer que le DOM est mis à jour

// Sélection des boutons radio
const radioButtonsChoixInteretPrecis = document.querySelectorAll('input[name="choixInteretPrecis"]')
const choixInteretCreche = document.getElementById("choixInteretCreche")
const choixInteretGroupe = document.getElementById("choixInteretGroupe")

// Ajout des écouteurs d'événements
radioButtonsChoixInteretPrecis.forEach(radio => 
    radio.addEventListener("change", updateVisibleInputChoixInteretPrecis)
)
choixInteretCreche.addEventListener("change", updateVisibleInputChoixInteretPrecis)
choixInteretGroupe.addEventListener("change", updateVisibleInputChoixInteretPrecis)

updateVisibleInputChoixInteretPrecis() 
})

//fermeture de la popup et envoi des données
const formAjoutInteretCreche = document.querySelector("#addInterestCrecheForm")

if (formAjoutInteretCreche) {
formAjoutInteretCreche.addEventListener("submit", function (e) {
    e.preventDefault() // Empêcher le rechargement de la page par défaut

    // Récupérer les données du formulaire
    let formData = new FormData(this)

    fetch("index.php?action=ajoutInteretCreche", {
        method: "POST",
        body: formData
    })
    .then(response => {
        console.log("Réponse brute :", response)
    
        if (!response.ok) {
            throw new Error(`Erreur HTTP : ${response.status}`)
        }
        return response.text()  // 🔥 Récupérer la réponse brute
    })
    .then(text => {
        console.log("Texte brut reçu :", text)
    
        try {
            let jsonData = JSON.parse(text)
            console.log("JSON parsé :", jsonData)
            return jsonData
        } catch (error) {
            console.error("❌ Erreur de parsing JSON :", error)
            throw new Error("La réponse du serveur n'est pas un JSON valide : " + text)
        }
    })
    .then(data => {
        console.log("🟢 Réponse du serveur :", data) // Debug
        if (data.status === "success") {
            fermerPopup("popupAjoutInteretCreche")
            afficherMessageSucces("Interet ajouté avec succès !")
            window.location.reload(false)  // Rafraîchir la page
        } else {
            console.error("❌ Erreur serveur :", data.message)
            afficherMessageErreur(data.message)
        }
    })
    .catch(error => {
        console.error("❌ Problème avec la requête fetch :", error)
        afficherMessageErreur("Une erreur est survenue. Veuillez réessayer.")
    })
})
}

function afficherMessageErreur(message) {
console.error("Erreur : " + message)
alert("❌ Erreur : " + message)
}

//Ajout de la gestion du pop up ajoutInteretGeneral
//Événement sur le bouton d'ouverture du popup ajoutInteretGeneral
document.getElementById("boutonAjoutInteretGeneral").addEventListener("click", function() {
setTimeout(() => {
    let element = document.getElementById("popupAjoutInteretGeneral")
    if (element) {
        updateVisibleInputChoixInteretGeneral()
    } else {
        console.warn("L'élément n'est pas encore disponible !")
    }
}, 100) // Petit délai pour s'assurer que le DOM est mis à jour

// Gestion des recherches de crèches par zone
const radioButtonsGeneral = document.querySelectorAll('input[name="choixInteretGeneral"]')
const inputGroupsGeneral = {
    interetVille: "inputChoixInteretVille",
    interetDepartement: "inputChoixInteretDepartement",
    interetRegion: "inputChoixInteretRegion",
}

// 🔹 Fonction pour mettre à jour la visibilité des inputs
function updateVisibleInputChoixInteretGeneral() {
    const selectedValue = document.querySelector('input[name="choixInteretGeneral"]:checked').value
    document.querySelectorAll('.general-input').forEach(input => input.value = "")
    Object.values(inputGroupsGeneral).forEach(id => document.getElementById(id).classList.add('d-none'))
    
    document.getElementById(inputGroupsGeneral[selectedValue]).classList.remove('d-none')
}

radioButtonsGeneral.forEach(radio => radio.addEventListener("change", updateVisibleInputChoixInteretGeneral))
updateVisibleInputChoixInteretGeneral() // Exécuter au chargement
})

//fermeture de la popup interetGeneral et envoi des données
const formAjoutInteretGeneral = document.querySelector("#addInterestGeneralForm")

if (formAjoutInteretGeneral) {
    formAjoutInteretGeneral.addEventListener("submit", function (e) {
        e.preventDefault() // Empêcher le rechargement de la page par défaut

        // Récupérer les données du formulaire
        let formData = new FormData(this)

        fetch("index.php?action=ajoutInteretGeneral", {
            method: "POST",
            body: formData
        })

        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`)
            }
            return response.text()  // Récupérer la réponse brute
        })
        .then(text => {
            try {
                return JSON.parse(text)  // Tenter de parser en JSON
            } catch (error) {
                throw new Error("La réponse du serveur n'est pas un JSON valide : " + text)
            }
        })
        .then(data => {
            if (data.status === "success") {
                fermerPopup("popupAjoutInteretGeneral")
                afficherMessageSucces("Interet ajouté avec succès !")
                window.location.reload(false)  // Rafraîchir la page
            } else {
                console.error("❌ Erreur serveur :", data.message)
                afficherMessageErreur(data.message)
            }
        })
        .catch(error => {
            console.error("❌ Problème avec la requête fetch :", error)
            afficherMessageErreur("Une erreur est survenue. Veuillez réessayer.")
        })
    })
}

//fermeture de la popup ajoutLocalisation et envoi des données

function addNewLocalisation(e) {
    e.preventDefault();
    console.log("✅ Événement submit détecté !");

        // Récupérer les données du formulaire
        let formData = new FormData(this)
        console.log(formData)

        fetch("index.php?action=ajoutNewLocalisation", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                console.log(response)
                throw new Error(`Erreur HTTP : ${response.status}`)
            }
            return response.text()  // Récupérer la réponse brute
        })
        .then(text => {
            try {
                return JSON.parse(text)  // Tenter de parser en JSON
            } catch (error) {
                throw new Error("La réponse du serveur n'est pas un JSON valide : " + text)
            }
        })
        .then(data => {
            if (data.status === "success") {
                fermerPopup("popupAjoutLocalisation")
                afficherMessageSucces("Interet ajouté avec succès !")
                window.location.reload(false)  // Rafraîchir la page
            } else {
                console.error("❌ Erreur serveur :", data.message)
                afficherMessageErreur(data.message)
            }
        })
        .catch(error => {
            console.error("❌ Problème avec la requête fetch :", error)
            afficherMessageErreur("Une erreur est survenue. Veuillez réessayer.")
        })
    }


/**
* Fonction pour fermer une popup donnée par son ID.
*/
function fermerPopup(idPopup) {
let popup = document.getElementById(idPopup)
if (popup) {
    popup.style.display = "none"
}
}

function ouvrirPopup(idPopup, identifiant = '', niveau = '', groupe = '') {
    let popup = document.getElementById(idPopup);

    if (popup) {
        // Vérifie et assigne les valeurs aux champs
        let niveauInteret = document.getElementById("niveauInteret");
        if (niveauInteret) niveauInteret.value = niveau;

        let interetCreche = document.getElementById("interetCreche");
        if (interetCreche) interetCreche.value = identifiant;

        let niveauInteretGroupe = document.getElementById("niveauInteretGroupe");
        if (niveauInteretGroupe) niveauInteretGroupe.value = niveau;

        let interetGroupe = document.getElementById("interetGroupe");
        if (interetGroupe) interetGroupe.value = groupe;

        // Affiche la popup
        popup.style.display = "block";

        setTimeout(() => {

            let villeInput = document.getElementById("newVille");
            let codePostalInput = document.getElementById("newCodePostal");
            let villesList = document.getElementById("newVilles");
            let codesList = document.getElementById("newCodePostaux");

            const formAjoutLocalisation = document.getElementById("addNewLocalisationForm");
        
            if (villeInput && codePostalInput && villesList && codesList) {
                setupVilleAutocomplete(villeInput, codePostalInput, villesList, codesList);
            } else {
                console.error("❌ Problème : Un des éléments d'autocomplétion est introuvable.");
            }

            if (formAjoutLocalisation) {
                formAjoutLocalisation.addEventListener("submit", addNewLocalisation);
            }
        }, 100);
    }
}

// Fonction d'autocomplétion
function setupVilleAutocomplete(villeInput, codePostalInput, villesList, codesList) {

    if (!villeInput || !codePostalInput || !villesList || !codesList) {
        console.error("❌ setupVilleAutocomplete : Un des éléments est introuvable !");
        return;
    }

    villeInput.addEventListener("input", function() {
        let ville = this.value.trim();
        villesList.innerHTML = ""; // Vide la liste des villes
        codesList.innerHTML = "";  // Vide la liste des codes postaux
        codePostalInput.value = ""; // Réinitialise le code postal

        if (ville.length > 2) {

            fetch(`https://geo.api.gouv.fr/communes?nom=${ville}&fields=nom,codesPostaux&limit=10`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {

                if (data.length > 0) {
                    let codesSet = new Set();
                    let singleCode = null;

                    data.forEach(commune => {
                        let option = document.createElement("option");
                        option.value = commune.nom;
                        option.dataset.codes = commune.codesPostaux.join(",");
                        villesList.appendChild(option);

                        commune.codesPostaux.forEach(code => {
                            codesSet.add(code);
                        });

                        if (data.length === 1 && commune.codesPostaux.length === 1) {
                            singleCode = commune.codesPostaux[0];
                        }
                    });

                    if (singleCode) {
                        codePostalInput.value = singleCode;
                    } else {
                        codesList.innerHTML = "";
                        codesSet.forEach(code => {
                            let codeOption = document.createElement("option");
                            codeOption.value = code;
                            codesList.appendChild(codeOption);
                        });
                    }
                } else {
                    console.warn("⚠️ Aucune ville trouvée.");
                }
            })
            .catch(error => console.error("❌ Erreur lors de la requête :", error));
        }
    });

    villeInput.addEventListener("change", function() {
        let options = document.querySelectorAll(`#${villesListId} option`);
        let selectedValue = this.value;
        codesList.innerHTML = "";

        options.forEach(option => {
            if (option.value === selectedValue) {
                let codes = option.dataset.codes.split(",");

                if (codes.length === 1) {
                    codePostalInput.value = codes[0];
                } else {
                    codePostalInput.value = "";
                    codes.forEach(code => {
                        let codeOption = document.createElement("option");
                        codeOption.value = code;
                        codesList.appendChild(codeOption);
                    });
                }
            }
        });
    });
}

/**
* Fonction qui empêche l'avertissement de confirmation
*/
window.onbeforeunload = function() {
return undefined 
}
