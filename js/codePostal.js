// Fonction générique pour gérer les villes et codes postaux dynamiquement
function setupVilleAutocomplete(villeInputId, codePostalInputId, villesListId, codesListId) {
    let villeInput = document.getElementById(villeInputId);
    let codePostalInput = document.getElementById(codePostalInputId);
    let villesList = document.getElementById(villesListId);
    let codesList = document.getElementById(codesListId);

    villeInput.addEventListener("input", function() {
        let ville = this.value.trim();
        villesList.innerHTML = ""; // Vide la liste des villes
        codesList.innerHTML = ""; // Vide la liste des codes postaux
        codePostalInput.value = ""; // Réinitialise le code postal

        if (ville.length > 2) {
            fetch(`https://geo.api.gouv.fr/communes?nom=${ville}&fields=nom,codesPostaux&limit=10`)
            .then(response => response.json())
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

                        // Si une seule ville et un seul code postal, on garde ce code
                        if (data.length === 1 && commune.codesPostaux.length === 1) {
                            singleCode = commune.codesPostaux[0];
                        }
                    });

                    // Si un seul code postal est trouvé, le remplir automatiquement
                    if (singleCode) {
                        codePostalInput.value = singleCode;
                    } else {
                        // Si plusieurs codes, injecter uniquement le premier code postal dans codePostalInterest
                        if (villeInputId === "villeInterest") {
                            const firstCode = Array.from(codesSet)[0]; // Récupère le premier code postal disponible
                            codePostalInput.value = firstCode; // Injecte uniquement le premier code postal
                        }

                        // Affiche la liste des codes postaux si plusieurs sont trouvés
                        codesList.innerHTML = ""; // Réinitialise la liste des codes
                        codesSet.forEach(code => {
                            let codeOption = document.createElement("option");
                            codeOption.value = code;
                            codesList.appendChild(codeOption);
                        });
                    }
                }
            })
            .catch(error => console.error("Erreur :", error));
        }
    });

    // Lorsque la ville est sélectionnée, on remplit le code postal
    villeInput.addEventListener("change", function() {
        let options = document.querySelectorAll(`#${villesListId} option`);
        let selectedValue = this.value;
        codesList.innerHTML = ""; // Vide la liste des codes postaux

        options.forEach(option => {
            if (option.value === selectedValue) {
                let codes = option.dataset.codes.split(",");

                // Si un seul code postal est trouvé, on le sélectionne automatiquement
                if (codes.length === 1) {
                    codePostalInput.value = codes[0];
                } else {
                    codePostalInput.value = ""; // Réinitialise le code postal
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

document.addEventListener("DOMContentLoaded", function() {
    // Activation du script pour chaque champ de ville et code postal

    // Ville et code postal vendeur
    if (document.getElementById("villeVendeur") && document.getElementById("codePostalVendeur")) {
        setupVilleAutocomplete("villeVendeur", "codePostalVendeur", "villesVendeur", "codePostauxVendeur");
    }

    // Ville et code postal produit
    if (document.getElementById("ville") && document.getElementById("codePostal")) {
        setupVilleAutocomplete("ville", "codePostal", "villes", "codePostaux");
    }

    // Ville et code postal nouvelle ville
    if (document.getElementById("newVille") && document.getElementById("newCodePostal")) {
        setupVilleAutocomplete("newVille", "newCodePostal", "newVilles", "newCodePostaux");
    }

    // Ville et code postal contact
    if (document.getElementById("newVilleContact") && document.getElementById("newCodePostalContact")) {
        setupVilleAutocomplete("newVilleContact", "newCodePostalContact", "newVillesContact", "newCodePostauxContact");
    }
})

document.addEventListener("DOMContentLoaded", function () {
    // Sélectionner tous les liens avec la classe ou ID de ton choix
    const popupVilleLink = document.querySelector("a[onclick=\"ouvrirPopup('popupAjoutInteretVille')\"]");
    
    if (popupVilleLink) {
        popupVilleLink.addEventListener("click", function (event) {
            event.preventDefault(); // Empêche le comportement par défaut du lien

            // Ouvre la popup (garde ton appel à la fonction 'ouvrirPopup' comme tu le fais)
            ouvrirPopup('popupAjoutInteretVille');

            // Attends un court instant pour laisser la popup se rendre
            setTimeout(() => {
                // Vérifie que la datalist est présente
                const villesList = document.getElementById("villesInterest");
                const codePostauxList = document.getElementById("codePostauxInterest");

                if (villesList && codePostauxList) {
                    // Charge l'autocomplétion une fois que la popup est visible
                    setupVilleAutocomplete("villeInterest", "codePostalInterest", "villesInterest", "codePostauxInterest");
                } else {
                    console.error("Les éléments de la datalist n'ont pas été trouvés.");
                }
            }, 100); // Petit délai pour laisser le DOM se mettre à jour
        });
    }
});