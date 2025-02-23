

// Gestion de l'affichage des champs dynamiques en fonction des cases cochées
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('input[name="choixInfoContact"]');

    const inputInfoContact = {
        contact: "inputInfoContact",
        nom: "inputInfoNomGroupe",
        siren: "inputInfoSIREN",
        email: "inputInfoEmail",
        telephone: "inputInfoTelephone",
        sens: "inputInfoSens",
        site: "inputInfoSite"
    };

    function updateVisibleInputInfoContact() {
        Object.values(inputInfoContact).forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.classList.add('d-none'); // Cacher tous les champs par défaut
            }
        });

        checkboxes.forEach(checkbox => {
            if (checkbox.checked && inputInfoContact.hasOwnProperty(checkbox.value)) {
                const selectedElement = document.getElementById(inputInfoContact[checkbox.value]);
                if (selectedElement) {
                    selectedElement.classList.remove('d-none'); // Afficher le champ correspondant
                }
            }
        });
    }

    // Ajout d'un écouteur d'événement à chaque checkbox
    checkboxes.forEach(checkbox => checkbox.addEventListener("change", updateVisibleInputInfoContact));

    updateVisibleInputInfoContact(); // Exécuter au chargement
})

    // Ajout de la gestion du formulaire d'ajout de contact
    const formAjoutContact = document.querySelector("#addInfoContact");

    if (formAjoutContact) {
    formAjoutContact.addEventListener("submit", function (e) {
        e.preventDefault(); // Empêcher le rechargement de la page

        let formData = new FormData(this);

        fetch("index.php?action=ajoutInfoContact", {
            method: "POST",
            body: formData
        })
        .then(response => response.text()) // ← Affiche la réponse en texte brut
        .then(text => {
            return JSON.parse(text); // ← Puis convertit en JSON
        })
        .then(data => {
            console.log("Réponse JSON :", data); // ← Vérifie la structure JSON

            if (data.status === "confirm_required") {
                afficherPopupConfirmation(data.modifications, data.idContact);
            } else if (data.status === "success") {
                fermerPopup('popupModifContact'); // Ferme le formulaire après confirmation
                location.reload(); // Recharge la page pour afficher les nouvelles données
            } else {
                console.error("⚠ Erreur serveur :", data.message);
            }
        })
        .catch(error => console.error("Erreur JS :", error));
    });
}


/**
 * Fonction pour afficher la popup de confirmation avec les modifications à valider.
 */
let modificationsGlobales = null;

function afficherPopupConfirmation(modifications, idContact) {

    // Stocker globalement les modifications
    modificationsGlobales = modifications;

    let popupContent = document.getElementById("popupConfirmationInfoContactContent");
    popupContent.innerHTML = "<h3>Confirmer les modifications ?</h3><ul>";

    for (const champ in modifications) {
        popupContent.innerHTML += `<li><strong>${champ} :</strong> "${modifications[champ].ancien}" → "${modifications[champ].nouveau}"</li>`;
    }
    popupContent.innerHTML += "</ul class='mt3'>";

    popupContent.innerHTML += `
        <div class="d-flex justify-content-center mt-3" style="gap: 20px;">
            <button class="btn btn-info" onclick="confirmerModifications(${idContact})">Confirmer</button>
            <button class="btn btn-danger" onclick="fermerPopup('popupConfirmationInfoContact')">Annuler</button>
        </div>
        `;

    document.getElementById("popupConfirmationInfoContact").style.display = "block";
}

/**
 * Fonction pour envoyer la confirmation des modifications.
 */
function confirmerModifications(idContact) {

    if (!modificationsGlobales || Object.keys(modificationsGlobales).length === 0) {
        console.error("❌ Aucune modification détectée !");
        return;
    }

    let formData = new FormData();
    formData.append("confirm", "true");
    formData.append("idContact", idContact);

    for (const [key, value] of Object.entries(modificationsGlobales)) {
        formData.append(key, value.nouveau);
    }

    fetch("index.php?action=ajoutInfoContact", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        return JSON.parse(text);
    })
    .then(data => {
        if (data.status === "success") {
            fermerPopup("popupConfirmationInfoContact");
            fermerPopup("popupModifContact");
            afficherMessageSucces("Mise à jour effectuée !");
            // Rafraîchir la page (rechargement complet)
            window.location.reload(false);
        } else {
            console.error("❌ Erreur serveur :", data.message);
        }
    })
    .catch(error => console.error("❌ Erreur JSON :", error));
}


/**
 * Fonction pour afficher un message de succès à l'utilisateur.
 */
function afficherMessageSucces(message) {
    let messageBox = document.createElement("div");
    messageBox.textContent = message;
    messageBox.style.position = "fixed";
    messageBox.style.top = "20px";
    messageBox.style.right = "20px";
    messageBox.style.backgroundColor = "#4CAF50";
    messageBox.style.color = "white";
    messageBox.style.padding = "10px 20px";
    messageBox.style.borderRadius = "5px";
    messageBox.style.zIndex = "1000";
    document.body.appendChild(messageBox);

    setTimeout(() => {
        messageBox.remove();
    }, 3000);
}

// Ajout de la gestion du formulaire d'ajout de commentaire
const formAjoutComment = document.querySelector("#addCommentForm");

if (formAjoutComment) {
    formAjoutComment.addEventListener("submit", function (e) {
        e.preventDefault(); // Empêcher le rechargement de la page par défaut

        // Récupérer les données du formulaire
        let formData = new FormData(this);

        fetch("index.php?action=ajoutComment", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())  // Utilise .text() pour obtenir la réponse brute
        .then(text => {
            console.log('Réponse du serveur:', text);  // Affiche la réponse pour l'inspecter
            return JSON.parse(text);  // Essaie de parser la réponse JSON
        })
        .then(data => {
            if (data.status === "success") {
                fermerPopup("popupAjoutComment");
                afficherMessageSucces("Commentaire ajouté avec succès !");
                // Rafraîchir la page (rechargement complet)
                window.location.reload(false);
            } else {
                console.error("❌ Erreur serveur :", data.message);
                afficherMessageErreur(data.message);
            }
        })
    })
}



/**
 * Fonction pour fermer une popup donnée par son ID.
 */
function fermerPopup(idPopup) {
    let popup = document.getElementById(idPopup);
    if (popup) {
        popup.style.display = "none";
    }
}

/**
 * Fonction pour ouvrii une popup donnée par son ID.
 */
function ouvrirPopup(idPopup) {
    let popup = document.getElementById(idPopup);
    if (popup) {
        popup.style.display = "block";
    }
}

/**
 * Fonction qui empêche l'avertissement de confirmation
 */
window.onbeforeunload = function() {
    return undefined; 
};




    
    