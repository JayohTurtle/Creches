

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("form").addEventListener("submit", function(event) {
        event.preventDefault(); // Bloque l'envoi du formulaire
        
        if (validateFormContact()) {
            this.submit(); // Envoie le formulaire seulement si tout est valide
        }
    });
});


/**
 * Fonction qui vérifie la validité des champs du formulaire
 */
function validateFormContact() {
    let isValid = true

    // Sélection des champs
    const nom = document.getElementById('nom')
    const contact = document.getElementById('contact')
    const telephone = document.getElementById('telephone')
    const email = document.getElementById('email')
    const ville = document.getElementById('ville')
    const adresse = document.getElementById('adresse')
    const codePostal = document.getElementById('codePostal')
    const villeInterest = document.getElementById('villeInterest')
    const codePostalInterest = document.getElementById('codePostalInterest')
    const niveau = document.getElementById('niveau')
    const identifiant = document.getElementById('identifiantInterest')
    const groupe = document.getElementById('groupeInterest')

    let nomValue = nom.value.trim();
    let contactValue = contact.value.trim();
    let emailValue = email.value.trim();
    let telephoneValue = telephone.value.trim();
    let villeValue = ville.value.trim();
    let adresseValue = adresse.value.trim();
    let codePostalValue = codePostal.value.trim();
    let villeInterestValue = villeInterest.value.trim();
    let codePostalInterestValue = codePostalInterest.value.trim();
    let niveauValue = niveau.value.trim();
    let identifiantValue = identifiant.value.trim();
    let groupeValue = groupe.value.trim();

    //Vérification du remplissage de creche ou groupe si niveau est renseigné
    if (niveauValue !== "") {
        if (identifiantValue === "" && groupeValue === "") {
            let message = "Crèche ou groupe doit être renseigné";
            fieldError(identifiant, message);
            fieldError(groupe, message);
            isValid = false;
        } else {
            clearFieldError(identifiant);
            clearFieldError(groupe);
        }
    }

    //Vérification du remplissage des champs code postal et adresse si ville n'est pas vide
    if (villeValue !== "") {
        if (codePostalValue === "" || adresseValue === "") {
            let message = "Code postal et adresse doivent être renseignés";
            fieldError(codePostal, message);
            fieldError(adresse, message);
            isValid = false;
        } else {
            clearFieldError(codePostal);
            clearFieldError(adresse);
        }
    }

    //Vérification du remplissage du champs code Posta Interest si ville Interest n'est pas vide
    if (villeInterestValue !== "") {
        if (codePostalInterestValue === "") {
            let message = "Code postal doit être renseigné";
            fieldError(codePostalInterest, message);
            isValid = false;
        } else {
            clearFieldError(codePostalInterest);
        }
    }

    // Vérification des champs "contact" et "nom"
    if (nomValue === "" && contactValue === "") {
        let message = "Nom OU contact doivent être renseignés";
        fieldError(nom, message);
        fieldError(contact, message);
        isValid = false;
    } else {
        clearFieldError(nom);
        clearFieldError(contact);
    }

    // Vérification de l'email
    if (emailValue !== "") {
        let emailRegExp = /^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i;
        if (!emailRegExp.test(emailValue)) {
            let message = "Format email invalide";
            fieldError(email, message);
            isValid = false;
        } else {
            clearFieldError(email);
        }
    }

    // Vérification du téléphone
    if (telephoneValue !== "") {
        let telephoneRegExp = /^(?:\+?\d{1,3}[\s-]?)?(0[1-9])(?:[\s.-]?\d{2}){4}$/;
        if (!telephoneRegExp.test(telephoneValue)) {
            let message = "Numéro de téléphone invalide";
            fieldError(telephone, message);
            isValid = false;
        } else {
            clearFieldError(telephone)
        }
    }

    return isValid
}

/**
 * Fonction qui affiche l'erreur directement dans l'input (placeholder)
 * @param {HTMLElement} elem 
 * @param {string} message 
 */
function fieldError(elem, message) {
    elem.classList.add('error'); // Ajoute la bordure rouge
    elem.setAttribute("placeholder", message); // Affiche le message dans l'input
    elem.value = ""; // Efface la valeur incorrecte
}

/**
 * Fonction qui supprime l'erreur et restaure l'état normal du champ
 * @param {HTMLElement} elem 
 */
function clearFieldError(elem) {
    elem.classList.remove('error'); // Supprime la bordure rouge
    elem.setAttribute("placeholder", ""); // Efface le message d'erreur
}

