

// Gestion de l'affichage des champs dynamiques en fonction des cases cochées
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[name="choixInfoContact"]')

    const inputInfoContact = {
        contact: "inputInfoContact",
        nom: "inputInfoNomGroupe",
        siren: "inputInfoSIREN",
        email: "inputInfoEmail",
        telephone: "inputInfoTelephone",
        sens: "inputInfoSens",
        site: "inputInfoSite"
    }

    function updateVisibleInputInfoContact() {
        Object.values(inputInfoContact).forEach(id => {
            const element = document.getElementById(id)
            if (element) {
                element.classList.add('d-none') // Cacher tous les champs par défaut
            }
        })

        checkboxes.forEach(checkbox => {
            if (checkbox.checked && inputInfoContact.hasOwnProperty(checkbox.value)) {
                const selectedElement = document.getElementById(inputInfoContact[checkbox.value])
                if (selectedElement) {
                    selectedElement.classList.remove('d-none') // Afficher le champ correspondant
                }
            }
        })
    }

    // Ajout d'un écouteur d'événement à chaque checkbox
    checkboxes.forEach(checkbox => checkbox.addEventListener("change", updateVisibleInputInfoContact))

    updateVisibleInputInfoContact() // Exécuter au chargement
})

    // Ajout de la gestion du formulaire d'ajout de contact
    const formAjoutContact = document.querySelector("#addInfoContact")

    if (formAjoutContact) {
    formAjoutContact.addEventListener("submit", function (e) {
        e.preventDefault() // Empêcher le rechargement de la page

        let formData = new FormData(this)

        fetch("index.php?action=ajoutInfoContact", {
            method: "POST",
            body: formData
        })
        .then(response => response.text()) // ← Affiche la réponse en texte brut
        .then(text => {
            console.log("🔍 Réponse après confirmation :", text); // // <-- AJOUTE CETTE LIGNE
            return JSON.parse(text) // ← Puis convertit en JSON
        })
        .then(data => {
            console.log("Réponse JSON :", data) // ← Vérifie la structure JSON

            if (data.status === "confirm_required") {
                afficherPopupConfirmation(data.modifications, data.idContact)
            } else if (data.status === "success") {
                fermerPopup('popupModifContact') // Ferme le formulaire après confirmation
                location.reload() // Recharge la page pour afficher les nouvelles données
            } else {
                console.error("⚠ Erreur serveur :", data.message)
            }
        })
        .catch(error => console.error("Erreur JS :", error))
    })
}


/**
 * Fonction pour afficher la popup de confirmation avec les modifications à valider.
 */
let modificationsGlobales = null

function afficherPopupConfirmation(modifications, idContact) {
    let popup = document.querySelector("#popupConfirmation"); // Cibler le bon élément

    if (!popup) {  
        console.error("❌ Erreur : le popup de confirmation est introuvable !");
        return;  // On arrête l'exécution pour éviter l'erreur
    }

    // Stocker globalement les modifications
    modificationsGlobales = modifications

    let popupContent = document.getElementById("popupConfirmationInfoContactContent")
    console.log("popupContent trouvé ?", popupContent);
    popupContent.innerHTML = "<h3>Confirmer les modifications ?</h3><ul>"

    for (const champ in modifications) {
        popupContent.innerHTML += `<li><strong>${champ} :</strong> "${modifications[champ].ancien}" → "${modifications[champ].nouveau}"</li>`
    }
    popupContent.innerHTML += "</ul class='mt3'>"

    popupContent.innerHTML += `
        <input type="hidden" id="popupIdContact" value="${idContact}">
        <div class="d-flex justify-content-center mt-3" style="gap: 20px">
            <button class="btn btn-info" onclick="confirmerModifications(${idContact})">Confirmer</button>
            <button class="btn btn-danger" onclick="fermerPopup('popupConfirmationInfoContact')">Annuler</button>
        </div>
        `

        popup.style.display = "block"; // Ou "flex" selon ton CSS

}

/**
 * Fonction pour envoyer la confirmation des modifications.
 */
function confirmerModifications(idContact) {

    if (!modificationsGlobales || Object.keys(modificationsGlobales).length === 0) {
        console.error("❌ Aucune modification détectée !")
        return
    }
    console.log("🔍 ID Contact récupéré dans confirmerModifications :", idContact);

    let formData = new FormData()
    formData.append("confirm", "true")
    formData.append("idContact", idContact)

    for (const [key, value] of Object.entries(modificationsGlobales)) {
        formData.append(key, value.nouveau)
    }

    fetch("index.php?action=ajoutInfoContact", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        console.log("🔍 Réponse après confirmation :", text); // ← Vérifie si HTML 
        return JSON.parse(text)
    })
    .then(data => {
        if (data.status === "success") {
            fermerPopup("popupConfirmationInfoContact")
            fermerPopup("popupModifContact")
            afficherMessageSucces("Mise à jour effectuée !")
            // Rafraîchir la page (rechargement complet)
            window.location.reload(false)
        } else {
            console.error("❌ Erreur serveur :", data.message)
        }
    })
    .catch(error => console.error("❌ Erreur JSON :", error))
}


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
            console.log("Réponse brute :", response);
        
            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }
            return response.text();  // 🔥 Récupérer la réponse brute
        })
        .then(text => {
            console.log("Texte brut reçu :", text);
        
            try {
                let jsonData = JSON.parse(text);
                console.log("JSON parsé :", jsonData);
                return jsonData;
            } catch (error) {
                console.error("❌ Erreur de parsing JSON :", error);
                throw new Error("La réponse du serveur n'est pas un JSON valide : " + text);
            }
        })
        .then(data => {
            console.log("🟢 Réponse du serveur :", data); // Debug
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
    console.error("Erreur : " + message);
    alert("❌ Erreur : " + message); // Affiche une alerte (optionnel)
}


//Ajout de la gestion du popUp ajoutInteretGeneral

// 🔹 Fonction pour mettre à jour la visibilité des inputs
function updateVisibleInputChoixInteretGeneral() {
    const inputChoixInteretVille = document.getElementById("inputChoixInteretVille")
    const inputChoixInteretDepartement = document.getElementById("inputChoixInteretDepartement")
    const inputChoixInteretRegion = document.getElementById("inputChoixInteretRegion")
    const choixInteretVille = document.getElementById("choixInteretVille")
    const choixInteretDepartement = document.getElementById("choixInteretDepartement")
    const choixInteretRegion = document.getElementById("choixInteretRegion")

    if (choixInteretVille.checked) {
        inputChoixInteretVille.classList.remove("d-none")
        inputChoixInteretDepartement.classList.add("d-none")
        inputChoixInteretRegion.classList.add("d-none")
    } else if (choixInteretDepartement.checked) {
        inputChoixInteretVille.classList.add("d-none")
        inputChoixInteretDepartement.classList.remove("d-none")
        inputChoixInteretRegion.classList.add("d-none")
    } else if(choixInteretRegion.checked){
        inputChoixInteretVille.classList.add("d-none")
        inputChoixInteretDepartement.classList.add("d-none")
        inputChoixInteretRegion.classList.remove("d-none")
    }
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretGeneral
document.getElementById("boutonAjoutInteretGeneral").addEventListener("click", function() {
    setTimeout(() => {
        let element = document.getElementById("popupAjoutInteretGeneral")
        if (element) {
            updateVisibleInputChoixInteretGeneral()
        } else {
            console.warn("L'élément n'est pas encore disponible !")
        }
    }, 100) // Petit délai pour s'assurer que le DOM est mis à jour

    // Sélection des boutons radio
    const radioButtonsChoixInteretGeneral = document.querySelectorAll('input[name="choixInteretGeneral"]')
    const choixInteretVille = document.getElementById("choixInteretVille")
    const choixInteretDepartement = document.getElementById("choixInteretDepartement")
    const choixInteretRegion = document.getElementById("choixInteretRegion")

    // Ajout des écouteurs d'événements
    radioButtonsChoixInteretGeneral.forEach(radio => 
        radio.addEventListener("change", updateVisibleInputChoixInteretGeneral)
    )
    choixInteretVille.addEventListener("change", updateVisibleInputChoixInteretGeneral)
    choixInteretDepartement.addEventListener("change", updateVisibleInputChoixInteretGeneral)
    choixInteretRegion.addEventListener("change", updateVisibleInputChoixInteretGeneral)

    updateVisibleInputChoixInteretGeneral() 
})

//fermeture de la popup et envoi des données
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

/**
 * Fonction pour fermer une popup donnée par son ID.
 */
function fermerPopup(idPopup) {
    let popup = document.getElementById(idPopup)
    if (popup) {
        popup.style.display = "none"
    }
}

/**
 * Fonction pour ouvrir une popup donnée par son ID.
 */
function ouvrirPopup(idPopup) {
    let popup = document.getElementById(idPopup)
    if (popup) {
        popup.style.display = "block"
    }
}

/**
 * Fonction qui empêche l'avertissement de confirmation
 */
window.onbeforeunload = function() {
    return undefined 
}




    
    