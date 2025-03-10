// Événement sur le bouton d'ouverture du popup rechercheContact
document.getElementById("boutonRechercheContact").addEventListener("click", function() {
    setTimeout(() => {
        let element = document.getElementById("popupRechercheContact")
        if (element) {
            updateVisibleInputContact()
        } else {
            console.warn("L'élément n'est pas encore disponible !")
        }
    }, 100) // Petit délai pour s'assurer que le DOM est mis à jour


    // Gestion de l'apparition des input de popupRechercheContact
    const radioButtonsContact = document.querySelectorAll('input[name="contactResearch"]')
    const inputGroupsContact = {
        contact: "inputContact",
        nom: "inputNomGroupe",
        siren: "inputSIREN",
        email: "inputEmail",
        telephone: "inputTelephone",
    }

    function updateVisibleInputContact() {
        const selectedValue = document.querySelector('input[name="contactResearch"]:checked').value;
    
        // Vider tous les champs de saisie
        document.querySelectorAll('.contact-input').forEach(input => input.value = "");
        // Cacher tous les inputs
        Object.values(inputGroupsContact).forEach(id => document.getElementById(id).classList.add('d-none'));
    
        // Afficher l'input sélectionné
        document.getElementById(inputGroupsContact[selectedValue]).classList.remove('d-none');
        
    }

    radioButtonsContact.forEach(radio => radio.addEventListener("change", updateVisibleInputContact))
    updateVisibleInputContact() // Exécuter au chargement
})

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("formResearchContact").addEventListener("submit", function (event) {
        event.preventDefault(); // Empêche le rechargement de la page

        let formData = new FormData(this);

        fetch("index.php?action=researchResultContacts", {
            method: "POST",
            body: formData,
        })
        .then(response => {
            if (response.ok) {
                fermerPopup('popupRechercheContact')
                window.location.href = 'http://localhost/creches/index.php?action=resultContacts';
            } else {
                console.error('Erreur lors de l\'envoi des données');
            }
        })
        .catch(error => console.error('Erreur lors de l\'envoi des données:', error));
    });
});

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