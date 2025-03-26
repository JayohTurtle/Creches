document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("form").addEventListener("submit", function(event) {
        event.preventDefault() // Bloque l'envoi du formulaire
        
        if (validateFormContact()) {
            this.submit() // Envoie le formulaire seulement si tout est valide
        }
    })
})

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

    let nomValue = nom.value.trim()
    let contactValue = contact.value.trim()
    let emailValue = email.value.trim()
    let telephoneValue = telephone.value.trim()

    // Vérification des champs "contact" et "nom"
    if (nomValue === "" && contactValue === "") {
        let message = "Nom OU contact doivent être renseignés"
        fieldError(nom, message)
        fieldError(contact, message)
        isValid = false
    } else {
        clearFieldError(nom)
        clearFieldError(contact)
    }

    // Vérification de l'email
    if (emailValue !== "") {
        let emailRegExp = /^[a-z0-9._-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i
        if (!emailRegExp.test(emailValue)) {
            let message = "Format email invalide"
            fieldError(email, message)
            isValid = false
        } else {
            clearFieldError(email)
        }
    }

    // Vérification du téléphone
    if (telephoneValue !== "") {
        let telephoneRegExp = /^(?:\+?\d{1,3}[\s-]?)?(0[1-9])(?:[\s.-]?\d{2}){4}$/
        if (!telephoneRegExp.test(telephoneValue)) {
            let message = "Numéro de téléphone invalide"
            fieldError(telephone, message)
            isValid = false
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
    elem.classList.add('error') // Ajoute la bordure rouge
    elem.setAttribute("placeholder", message) // Affiche le message dans l'input
    elem.value = "" // Efface la valeur incorrecte
}

/**
 * Fonction qui supprime l'erreur et restaure l'état normal du champ
 * @param {HTMLElement} elem 
 */
function clearFieldError(elem) {
    elem.classList.remove('error') // Supprime la bordure rouge
    elem.setAttribute("placeholder", "") // Efface le message d'erreur
}

document.addEventListener("DOMContentLoaded", function () {
    // Sélectionne tous les champs input
    document.querySelectorAll("input").forEach(input => {
        input.addEventListener("focus", function () {
            clearFieldError(this); // Efface l'erreur du champ cliqué
        });
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const errorMessage = document.getElementById("error-message");

    if (errorMessage) {
        document.querySelectorAll("input").forEach(input => {
            input.addEventListener("focus", function () {
                errorMessage.style.display = "none"; // Cache le message d'erreur
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message");

    if (successMessage) {
        document.querySelectorAll("input").forEach(input => {
            input.addEventListener("focus", function () {
                successMessage.style.display = "none"; // Cache le message d'erreur
            });
        });
    }
});

