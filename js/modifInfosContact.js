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

function afficherMessageErreur(message) {
    console.error("Erreur : " + message)
    alert("❌ Erreur : " + message)
}

function modifIdentiteFormulaires() {
    document.querySelectorAll(".infoContactForm").forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page

            let formData = new FormData(this)
            console.log("🔍 Vérification du formulaire :", this.innerHTML)
            let idContact = this.querySelector("[name='idContact']").value 
            let champ = this.querySelector("[name='champ']").value 
            let valeur = this.querySelector("[name='valeur']").value 

            console.log("📩 Données envoyées :", { idContact, champ, valeur })

            fetch("index.php?action=ajoutInfoContact", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())  // Récupère la réponse en texte brut
                .then(text => {
                    console.log("🔍 Réponse brute du serveur :", text) // Affiche la réponse brute
                    return JSON.parse(text) // Ensuite, essaie de la parser en JSON
                })
                .then(data => {
                    console.log("🔍 Réponse brute du serveur :", data) 
                    
                    if (data.status === "confirm_required") {
                        afficherPopupConfirmation(data.ancien, data.nouveau, idContact, data.champ)
                    } else if (data.status === "success") {
                        let idPopup // Déclaration en dehors du if/else if

                        if (data.champ === 'telephone') {
                            idPopup = 'popupModifTelephone'
                        } else if (data.champ === 'email') {
                            idPopup = 'popupModifEmail'
                        } else if (data.champ === 'siren') {
                            idPopup = 'popupModifSIREN'
                        } else if (data.champ === 'siteInternet') {
                            idPopup = 'popupModifSite'
                        } else {
                            idPopup = 'popupModifSens'
                        }

                        fermerPopup(idPopup) // Maintenant, idPopup est défini
                        location.reload()
                    } else {
                        console.error("⚠ Erreur serveur :", data.message)
                    }
                })
                .catch(error => console.error("Erreur JS :", error))
                })
            })
        }

// Attacher les événements après l'affichage de la popup
document.addEventListener("DOMContentLoaded", () => {
    modifIdentiteFormulaires()
})

/**
 * Affiche la popup de confirmation pour un champ spécifique.
 */
function afficherPopupConfirmation(ancien, nouveau, idContact, champ) {
    let popup = document.querySelector("#popupConfirmation")

    if (!popup) {  
        console.error("❌ Erreur : la popup de confirmation est introuvable !")
        return
    }

    let popupContent = document.getElementById("popupConfirmationInfoContactContent")

    popupContent.innerHTML = `
        <h3>Confirmer la modification</h3>
        <p>"${ancien}" → "${nouveau}"</p>
        <input type="hidden" id="popupIdContact" value="${idContact}">
        <input type="hidden" id="popupChamp" value="${champ}">
        <input type="hidden" id="popupValeur" value="${nouveau}">
        <div class="d-flex justify-content-center mt-3" style="gap: 20px">
            <button class="btn btn-info" onclick="confirmerModification()">Confirmer</button>
            <button class="btn btn-danger" onclick="fermerPopup('popupConfirmation')">Annuler</button>
        </div>
    `

    popup.style.display = "block"
}

/**
 * Envoie la confirmation au serveur
 */
function confirmerModification() {
    let formData = new FormData();
    let idContact = document.getElementById("popupIdContact").value;
    let champ = document.getElementById("popupChamp").value;
    let valeur = document.getElementById("popupValeur").value;

    console.log("📩 Données envoyées :", { idContact, champ, valeur }); // Debug

    formData.append("idContact", idContact);
    formData.append("champ", champ);
    formData.append("valeur", valeur);

    let url = (champ === "taille") 
        ? "index.php?action=confirmerModifInteretTaille"
        : "index.php?action=confirmerModificationContact";

    fetch(url, {
        method: "POST",
        body: formData
    })

    .then(response => response.text())  // Récupère la réponse en texte brut
        .then(text => {
            console.log("🔍 Réponse brute du serveur :", text) // Affiche la réponse brute
            return JSON.parse(text) // Ensuite, essaie de la parser en JSON
        })
        .then(data => {
        console.log("📩 Réponse serveur :", data) // Vérifier la réponse

        if (data.status === "success") {
            fermerPopup('popupConfirmation')
            location.reload()
        } else {
            console.error("⚠ Erreur serveur :", data.message)
        }
    })
    .catch(error => console.error("❌ Erreur JS :", error))
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
function ajoutInteretCrecheFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formAjoutInteretCreche = document.getElementById("addInterestCrecheForm")
    
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
}

function modifTailleFormulaire() {
    const formModifTaille = document.getElementById("modifTailleForm")

    if (formModifTaille) {

        formModifTaille.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)

            fetch("index.php?action=modifInteretTaille", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())  // Récupère la réponse en texte brut
                .then(text => {
                    console.log("🔍 Réponse brute du serveur :", text) // Affiche la réponse brute
                    return JSON.parse(text)
                })
                .then(data => {
                    console.log("🔍 Réponse brute du serveur2 :", data) 
                    
                    if (data.status === "confirm_required") {
                        afficherPopupConfirmation(data.ancien, data.nouveau, data.idContact, data.champ)
                    } else if (data.status === "success") {
                        fermerPopup("popupModifTaille")
                        location.reload()
                    } else {
                        console.error("⚠ Erreur serveur :", data.message)
                    }
                })
                .catch(error => console.error("Erreur JS :", error))
            })
        }
    }
            
// Attacher les événements après l'affichage de la popup
document.addEventListener("DOMContentLoaded", () => {
    modifTailleFormulaire()
})

function ajoutLocalisationFormulaire() {
    const formAjoutNewLocalisation = document.getElementById("addNewLocalisationForm")

    if (formAjoutNewLocalisation) {

        formAjoutNewLocalisation.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)

            fetch("index.php?action=ajoutNewLocalisation", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())  // Récupère la réponse en texte brut
                .then(text => {
                    console.log("🔍 Réponse brute du serveur :", text) // Affiche la réponse brute
                    return JSON.parse(text)
                })
                .then(data => {
                    if (data.status === "success") {
                        fermerPopup("popupAjoutLocalisation")
                        afficherMessageSucces("Localisation ajoutée avec succès !")
                        window.location.reload(false)  // Rafraîchir la page
                    } else {
                        console.error("❌ Erreur serveur :", data.message)
                        afficherMessageErreur(data.message)
                    }
                })
                .catch(error => console.error("Erreur JS :", error))
            })
        }
    }
            
// Attacher les événements après l'affichage de la popup
document.addEventListener("DOMContentLoaded", () => {
    ajoutLocalisationFormulaire()
})

function ajoutCommentaireFormulaire() {
    const formAjoutComment = document.getElementById("addCommentForm");
    
    if (formAjoutComment) {
        let isSubmitting = false; // 🔒 Verrou pour éviter plusieurs requêtes

        formAjoutComment.addEventListener("submit", function (e) {
            e.preventDefault(); // Empêcher le rechargement de la page
            
            if (isSubmitting) return; // Si déjà en cours, on bloque
            isSubmitting = true;

            let formData = new FormData(this);

            fetch("index.php?action=ajoutNewComment", {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP : ${response.status}`);
                }
                return response.text(); 
            })
            .then(text => {
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error("La réponse du serveur n'est pas un JSON valide : " + text);
                }
            })
            .then(data => {
                if (data.status === "success") {
                    fermerPopup("popupAjoutComment");
                    afficherMessageSucces("Commentaire ajouté avec succès !");
                    window.location.reload(false);
                } else {
                    console.error("❌ Erreur serveur :", data.message);
                    afficherMessageErreur(data.message);
                }
            })
            .catch(error => {
                console.error("❌ Problème avec la requête fetch :", error);
                afficherMessageErreur("Une erreur est survenue. Veuillez réessayer.");
            })
            .finally(() => {
                isSubmitting = false; // 🔓 Déverrouillage après la réponse
            });
        }, { once: true }); // ✅ Ajoute l'événement une seule fois
    }
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function ajoutInteretVilleFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formAjoutInteretVille = document.getElementById("addInterestVilleForm")
    
    if (formAjoutInteretVille) {
        formAjoutInteretVille.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
        
            fetch("index.php?action=ajoutInteretVille", {
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
                    fermerPopup("popupAjoutInteretVille")
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
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function ajoutInteretDepartementFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formAjoutInteretDepartement = document.getElementById("addInterestDepartementForm")
    
    if (formAjoutInteretDepartement) {
        formAjoutInteretDepartement.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
        
            fetch("index.php?action=ajoutInteretDepartement", {
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
                    fermerPopup("popupAjoutInteretDepartement")
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
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function ajoutInteretRegionFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formAjoutInteretRegion = document.getElementById("addInterestRegionForm")
    
    if (formAjoutInteretRegion) {
        formAjoutInteretRegion.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
        
            fetch("index.php?action=ajoutInteretRegion", {
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
                    fermerPopup("popupAjoutInteretRegion")
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
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function ajoutInteretFranceFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formAjoutInteretFrance = document.getElementById("addInterestFranceForm")
    
    if (formAjoutInteretFrance) {
        formAjoutInteretFrance.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
        
            fetch("index.php?action=ajoutInteretFrance", {
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
                    fermerPopup("popupAjoutInteretFrance")
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
}


// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function modifCommissionFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formModifCommission = document.getElementById("addCommissionForm")
    
    if (formModifCommission) {
        formModifCommission.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
        
            fetch("index.php?action=modifCommission", {
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
                    fermerPopup("popupModifCommission")
                    afficherMessageSucces("Commission ajoutée avec succès !")
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
}

// 🔹 Événement sur le bouton d'ouverture du popup ajoutInteretCreche
function modifValorisationFormulaire() {
    
    //fermeture de la popup et envoi des données
    const formModifValorisation = document.getElementById("addValorisationForm")
    
    if (formModifValorisation) {
        formModifValorisation.addEventListener("submit", function (e) {
            e.preventDefault() // Empêcher le rechargement de la page par défaut
        
            // Récupérer les données du formulaire
            let formData = new FormData(this)
        
            fetch("index.php?action=modifValorisation", {
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
                    fermerPopup("popupModifValorisation")
                    afficherMessageSucces("Valorisation ajoutée avec succès !")
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
}

/**
* Fonction pour fermer une popup donnée par son ID.
*/
function fermerPopup(idPopup) {
    let popup = document.getElementById(idPopup)
    popup.style.display = "none" 
    popupActive = null // Réinitialiser la variable
}
    
let popupActive = null // Stocke l'ID de la popup ouverte

function ouvrirPopup(idPopup) {

    let popup = document.getElementById(idPopup)
    popup.style.display = "block" 

    // Mettre à jour la variable de popup active
    popupActive = idPopup

    setTimeout(() => {
        appelerFonctionPopup(idPopup)
    }, 300)
}

function appelerFonctionPopup(idPopup) {
    switch (idPopup) {

        case "popupAjoutInteretCreche":
            ajoutInteretCrecheFormulaire()
            break

        case "popupAjoutInteretVille":
            ajoutInteretVilleFormulaire()
            break

        case "popupAjoutInteretDepartement":
            ajoutInteretDepartementFormulaire()
            break

        case "popupAjoutInteretRegion":
            ajoutInteretRegionFormulaire()
            break

        case "popupAjoutInteretFrance":
            ajoutInteretFranceFormulaire()
            break

        case "popupAjoutLocalisation":
            ajoutLocalisationFormulaire()
            break

        case "popupAjoutComment":
            ajoutCommentaireFormulaire()
            break

        case "popupModifTaille":
            modifTailleFormulaire()
            break

        case "popupModifCommission":
            modifCommissionFormulaire()
            break
        
        case "popupModifValorisation":
            modifValorisationFormulaire()
            break

        default:
            modifIdentiteFormulaires()
    }
}


    
