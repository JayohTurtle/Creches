document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message");
    const formInputs = document.querySelectorAll("input, textarea, select");
    const choixCreche = document.getElementById("choixCreche");
    const choixGroup = document.getElementById("choixGroup");
    const inputChoixCreche = document.getElementById("inputChoixCreche");
    const inputChoixGroup = document.getElementById("inputChoixGroup");

    if (successMessage) {
        formInputs.forEach(input => {
            input.addEventListener("focus", function () {
                successMessage.classList.add("hidden");
                setTimeout(() => successMessage.style.display = "none", 500);
            });
        });
    }

    let counters = {
        location: 0,
        interestVille: 0,
        interestDept: 0,
        interestRegion: 0
    };

    const elements = {
        choiceBuyer: document.getElementById("buyer"),
        choiceSeller: document.getElementById("seller"),
        statutVendeur: document.getElementById("statutVendeur"),
        valoVendeur: document.getElementById("valoVendeur"),
        commVendeur: document.getElementById("commVendeur"),
        buyerTitle: document.getElementById("buyer-title"),
        crecheSizeChoice: document.getElementById("crecheSizeChoice"),
        interest: document.getElementById("interest"),
        villeInterest: document.getElementById("villeInterestDiv"),
        departementInterest: document.getElementById("departementInterestDiv"),
        regionInterest: document.getElementById("regionInterestDiv"),
        addLocation: document.getElementById("add-location"),
        addInterestVille: document.getElementById("add-interestVille"),
        addInterestDepartement: document.getElementById("add-interestDepartement"),
        addInterestRegion: document.getElementById("add-interestRegion"),
    };

    // 🔹 Gestion affichage acheteur/vendeur
    elements.choiceSeller.addEventListener("click", () => toggleSellerBuyer(true));
    elements.choiceBuyer.addEventListener("click", () => toggleSellerBuyer(false));

    function toggleSellerBuyer(isSeller) {
        ["statutVendeur", "valoVendeur", "commVendeur"].forEach(id => 
            elements[id].classList.toggle("d-none", !isSeller)
        );
        ["interest", "buyerTitle", "crecheSizeChoice"].forEach(id => 
            elements[id].classList.toggle("d-none", isSeller)
        );
    
        document.querySelectorAll(`[id^="new-row"], [id^="seller-choice"]`).forEach(el => {
            el.classList.add("d-none");
            if (!isSeller) el.nextElementSibling?.remove();
        });
    
        // Assure que le bouton reste visible
        document.getElementById("contactEnvoi").classList.remove("d-none");
    }

    // 🔹 Fonction générique d'ajout d'élément
    function addNewRow(container, type, template) {
        counters[type]++;
        const newRow = document.createElement("div");
        newRow.classList.add("row", "form-row", "mt-3");
        newRow.id = `${type}-row-${counters[type]}`;
        newRow.innerHTML = template(counters[type]);
        container.appendChild(newRow);
    }

    // 🔹 Fonction générique de suppression
    document.addEventListener("click", (event) => {
        const target = event.target.closest(".remove-item");
        if (target) {
            document.getElementById(target.dataset.id)?.remove();
        }
    });

    // 🔹 Ajout de lignes
    elements.addLocation.addEventListener("click", () => {
        addNewRow(document.getElementById("location"), "location", (id) => `
            <div class="form-group col-md-3">
                <label>Ville</label>
                <input class="form-control" list="villes" name="ville[]">
            </div>
            <div class="form-group col-md-2">
                <label>Code postal</label>
                <input class="form-control" name="codePostal[]">
            </div>
            <div class="form-group col-md-3">
                <label>Adresse</label>
                <input class="form-control" name="adresse[]">
            </div>
            <div class="form-group col-md-2">
                <label>Taille</label>
                <select class="form-control" name="taille[]">
                    <option value="Micro-crèche">Micro-crèche</option>
                    <option value="Crèche">Crèche</option>
                </select>
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="location-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `);
    });

    elements.addInterestVille.addEventListener("click", () => {
        addNewRow(elements.villeInterest, "interestVille", (id) => `
            <div class="form-group col-md-2">
                <label>Ville</label>
                <input class="form-control" list="villesInterest" name="villeInterest[]">
            </div>
            <div class="form-group col-md-2">
                <label>Code postal</label>
                <input class="form-control" name="codePostalInterest[]">
            </div>
            <div class="form-group col-md-1">
                <label>Rayon</label>
                <input class="form-control" name="rayonInterest[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="interestVille-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `);
    });

    elements.addInterestDepartement.addEventListener("click", () => {
        addNewRow(elements.departementInterest, "interestDept", (id) => `
            <div class="form-group col-md-3">
                <label>Département</label>
                <input class="form-control" list="departementsInterest" name="departementInterest[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="interestDept-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `);
    });

    elements.addInterestRegion.addEventListener("click", () => {
        addNewRow(elements.regionInterest, "interestRegion", (id) => `
            <div class="form-group col-md-3">
                <label>Région</label>
                <input class="form-control" list="regionsInterest" name="regionInterest[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="interestRegion-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `);
    });

    // 🔹 Gestion des recherches par crèches ou groupes
    const radioButtonsCrecheGroup = document.querySelectorAll('input[name="crecheGroup"]');
    

    function updateVisibleInputCrecheGroup() {
        if (choixCreche.checked) {
            inputChoixCreche.classList.remove("d-none");
            inputChoixGroup.classList.add("d-none");
        } else if (choixGroup.checked) {
            inputChoixCreche.classList.add("d-none");
            inputChoixGroup.classList.remove("d-none");
        }
    }

    radioButtonsCrecheGroup.forEach(radio => 
        radio.addEventListener("change", updateVisibleInputCrecheGroup)
    );
    // Ajout des écouteurs d'événements
    choixCreche.addEventListener("change", updateVisibleInputCrecheGroup);
    choixGroup.addEventListener("change", updateVisibleInputCrecheGroup);
    
    updateVisibleInputCrecheGroup(); 
});

