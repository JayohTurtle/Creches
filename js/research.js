document.addEventListener("DOMContentLoaded", function () {
    // Gestion des recherches par contact
    const radioButtonsContact = document.querySelectorAll('input[name="contactResearch"]');
    const inputGroupsContact = {
        contact: "inputContact",
        nom: "inputNomGroupe",
        siren: "inputSIREN",
        email: "inputEmail",
        telephone: "inputTelephone",
    };

    function updateVisibleInputContact() {
        const selectedValue = document.querySelector('input[name="contactResearch"]:checked').value;
    
        // Vider tous les champs de saisie
        document.querySelectorAll('.contact-input').forEach(input => input.value = "");
        // Cacher tous les inputs
        Object.values(inputGroupsContact).forEach(id => document.getElementById(id).classList.add('d-none'));
    
        // Afficher l'input sélectionné
        document.getElementById(inputGroupsContact[selectedValue]).classList.remove('d-none');
        
    }

    radioButtonsContact.forEach(radio => radio.addEventListener("change", updateVisibleInputContact));
    updateVisibleInputContact() // Exécuter au chargement

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

    radioButtonsLocal.forEach(radio => radio.addEventListener("change", updateVisibleInputLocal));
    updateVisibleInputLocal(); // Exécuter au chargement

    //Gestion des recherches d'acheteurs
    const radioButtonsLocalAchat = document.querySelectorAll('input[name="localResearchAchat"]');
    const inputGroupsLocalAchat = {
        researchVilleAchat: "inputVilleAchat",
        researchDepartementAchat: "inputDepartementAchat",
        researchRegionAchat: "inputRegionAchat",
    };

    function updateVisibleInputLocalAchat() {
        const selectedValue = document.querySelector('input[name="localResearchAchat"]:checked').value;
        document.querySelectorAll('.achat-input').forEach(input => input.value = "")
        Object.values(inputGroupsLocalAchat).forEach(id => document.getElementById(id).classList.add('d-none'));
        document.getElementById(inputGroupsLocalAchat[selectedValue]).classList.remove('d-none');
        
    
    }

    radioButtonsLocalAchat.forEach(radio => radio.addEventListener("change", updateVisibleInputLocalAchat));
    updateVisibleInputLocalAchat(); // Exécuter au chargement

});


