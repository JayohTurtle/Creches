document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message")
    const formInputs = document.querySelectorAll("input, textarea, select")
    const choixCreche = document.getElementById("choixCreche")
    const choixGroup = document.getElementById("choixGroup")
    const inputChoixCreche = document.getElementById("inputChoixCreche")
    const inputChoixGroup = document.getElementById("inputChoixGroup")

    if (successMessage) {
        formInputs.forEach(input => {
            input.addEventListener("focus", function () {
                successMessage.classList.add("hidden")
                setTimeout(() => successMessage.style.display = "none", 500)
            })
        })
    }

    let counters = {
        location: 0,
        interestVille: 0,
        interestDept: 0,
        interestRegion: 0
    }

    const elements = {
        crecheSizeChoice: document.getElementById("crecheSizeChoice"),
        villeInterest: document.getElementById("villeInterestDiv"),
        departementInterest: document.getElementById("departementInterestDiv"),
        regionInterest: document.getElementById("regionInterestDiv"),
        addLocation: document.getElementById("add-location"),
        addInterestVille: document.getElementById("add-interestVille"),
        addInterestDepartement: document.getElementById("add-interestDepartement"),
        addInterestRegion: document.getElementById("add-interestRegion"),
    }

     // 🔹 Fonction générique d'ajout d'élément
     function addNewRow(container, type, template) {
        counters[type]++
        const newRow = document.createElement("div")
        newRow.classList.add("row", "form-row", "mt-3")
        newRow.id = `${type}-row-${counters[type]}`
        newRow.innerHTML = template(counters[type])
        container.appendChild(newRow)
    }

    // 🔹 Fonction générique de suppression
    document.addEventListener("click", (event) => {
        const target = event.target.closest(".remove-item")
        if (target) {
            document.getElementById(target.dataset.id)?.remove()
        }
    })

    elements.addLocation.addEventListener("click", () => {
        let newId = Date.now(); // Génère un ID unique
    
        addNewRow(document.getElementById("location"), "location", (id) => `
            <div class="form-group col-md-2">
                <label>Ville</label>
                <input class="form-control ville-input" list="villes-${newId}" name="ville[]" id="ville-${newId}" autocomplete="off">
                <datalist id="villes-${newId}"></datalist>
            </div>
            <div class="form-group col-md-1">
                <label>Code postal</label>
                <input class="form-control" name="codePostal[]" list="codePostaux-${newId}" id="codePostal-${newId}" autocomplete="off">
                <datalist id="codePostaux-${newId}"></datalist>
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
        `)
    

        // 🔹 Appelle l'autocomplétion pour la nouvelle ligne
        if (typeof setupVilleAutocomplete === "function") {
            setupVilleAutocomplete(`ville-${newId}`, `codePostal-${newId}`, `villes-${newId}`, `codePostaux-${newId}`);
        } else {
            console.error("setupVilleAutocomplete n'est pas défini. Vérifie l'ordre des fichiers JS.");
        }
    })

    elements.addInterestVille.addEventListener("click", () => {
        let newId = Date.now(); // Génère un ID unique
        addNewRow(elements.villeInterest, "interestVille", (id) => `
            <div class="form-group col-md-4">
                <label>Ville</label>
                <input class="form-control" list="villesInterest-${newId}" name="villeInterest[]" id="villeInterest-${newId}" autocomplete="off">
                <datalist id="villesInterest-${newId}"></datalist>
            </div>
            <div class="form-group col-md-2">
                <label>Code postal</label>
                <input class="form-control" name="codePostalInterest[]" list="codePostauxInterest-${newId}" id="codePostalInterest-${newId}" autocomplete="off">
                <datalist id="codePostauxInterest-${newId}"></datalist>
            </div>
            <div class="form-group col-md-2">
                <label>Rayon</label>
                <input class="form-control" name="rayonInterest[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="interestVille-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `)

        // 🔹 Appelle l'autocomplétion pour la nouvelle ligne
        if (typeof setupVilleAutocomplete === "function") {
            setupVilleAutocomplete(`villeInterest-${newId}`, `codePostalInterest-${newId}`, `villesInterest-${newId}`, `codePostauxInterest-${newId}`);
        } else {
            console.error("setupVilleAutocomplete n'est pas défini. Vérifie l'ordre des fichiers JS.");
        }
    })

    elements.addInterestDepartement.addEventListener("click", () => {
        addNewRow(elements.departementInterest, "interestDept", (id) => `
            <div class="form-group col-md-7">
                <label>Département</label>
                <input class="form-control" list="departementsInterest" name="departementInterest[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="interestDept-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `)
    })

    elements.addInterestRegion.addEventListener("click", () => {
        addNewRow(elements.regionInterest, "interestRegion", (id) => `
            <div class="form-group col-md-7">
                <label>Région</label>
                <input class="form-control" list="regionsInterest" name="regionInterest[]">
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-item" data-id="interestRegion-row-${id}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `)
    })

    // 🔹 Gestion des recherches par crèches ou groupes
    const radioButtonsCrecheGroup = document.querySelectorAll('input[name="crecheGroup"]')
    

    function updateVisibleInputCrecheGroup() {
        if (choixCreche.checked) {
            inputChoixCreche.classList.remove("d-none")
            inputChoixGroup.classList.add("d-none")
        } else if (choixGroup.checked) {
            inputChoixCreche.classList.add("d-none")
            inputChoixGroup.classList.remove("d-none")
        }
    }

    radioButtonsCrecheGroup.forEach(radio => 
        radio.addEventListener("change", updateVisibleInputCrecheGroup)
    )
    // Ajout des écouteurs d'événements
    choixCreche.addEventListener("change", updateVisibleInputCrecheGroup)
    choixGroup.addEventListener("change", updateVisibleInputCrecheGroup)
    
    updateVisibleInputCrecheGroup() 
});


