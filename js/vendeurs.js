document.querySelectorAll("[id^='boutonListe-']").forEach(button => {
    button.addEventListener('click', function() {
        // Extraire le statut depuis l'ID du bouton
        const statut = this.id.split('-')[1];

        // Afficher dans la console pour tester
        console.log("Statut du client sélectionné :", statut);

        // Tu peux ajouter ici ton traitement spécifique
    });
})
document.addEventListener("DOMContentLoaded", function () {
    // Gestion des recherches par contact
    const radioButtonsClient = document.querySelectorAll('input[name="clientResearch"]')
    const inputGroupsClient = {
        contact: "inputContact",
        nom: "inputNomGroupe",
        siren: "inputSIREN",
        email: "inputEmail",
        telephone: "inputTelephone",
    }

    function updateVisibleInputClient() {
        const selectedValue = document.querySelector('input[name="clientResearch"]:checked').value;
    
        // Vider tous les champs de saisie
        document.querySelectorAll('.client-input').forEach(input => input.value = "");
        // Cacher tous les inputs
        Object.values(inputGroupsClient).forEach(id => document.getElementById(id).classList.add('d-none'));
    
        // Afficher l'input sélectionné
        document.getElementById(inputGroupsClient[selectedValue]).classList.remove('d-none');
        
    }

    radioButtonsClient.forEach(radio => radio.addEventListener("change", updateVisibleInputClient))
    updateVisibleInputClient() // Exécuter au chargement

    // Gestion des recherches de crèches par zone
    const radioButtonsLocal = document.querySelectorAll('input[name="localResearch"]')
    const inputGroupsLocal = {
        researchVille: "inputVille",
        researchDepartement: "inputDepartement",
        researchRegion: "inputRegion",
    }

    function updateVisibleInputLocal() {
        const selectedValue = document.querySelector('input[name="localResearch"]:checked').value;
        document.querySelectorAll('.vente-input').forEach(input => input.value = "")
        Object.values(inputGroupsLocal).forEach(id => document.getElementById(id).classList.add('d-none'));
        document.getElementById(inputGroupsLocal[selectedValue]).classList.remove('d-none')
    }

    radioButtonsLocal.forEach(radio => radio.addEventListener("change", updateVisibleInputLocal))
    updateVisibleInputLocal() // Exécuter au chargement
})


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
