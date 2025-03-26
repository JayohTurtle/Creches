document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message")
    const formInputs = document.querySelectorAll("input, textarea, select")

    if (successMessage) {
        formInputs.forEach(input => {
            input.addEventListener("focus", function () {
                successMessage.classList.add("hidden")
                setTimeout(() => successMessage.style.display = "none", 500)
            })
        })
    }

    let counters = {
        location: 0
    }

    const elements = {
        addLocation: document.getElementById("add-location")
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

    let currentId = 2; // Démarre à 2

    elements.addLocation.addEventListener("click", () => {
        let newId = currentId++;

        addNewRow(document.getElementById("location"), "location", (id) => `
            <div class="form-group col-md-1 d-flex pt-4 justify-content-end" id="solo">
                <input type="checkbox" id="solo-${newId}" name="solo[]" value="${newId}">
            </div>
            <div class="form-group col-md-2">
                <label for="villeVendeur">Ville</label>
                <input class="form-control" list="villesVendeur-${newId}" id="villeVendeur-${newId}"  name="villeVendeur[]" autocomplete="off">
                <datalist id="villesVendeur-${newId}"></datalist>
            </div>
            <div class="form-group col-md-1">
                <label for="codePostalVendeur">Code postal</label>
                <input class="form-control" type="text" id="codePostalVendeur-${newId}" list="codePostauxVendeur-${newId}" name="codePostalVendeur[]" autocomplete="off">
                <datalist id="codePostauxVendeur-${newId}"></datalist>
            </div>
            <div class="form-group col-md-3">
                <label for="adresse">Adresse</label>
                <input class="form-control" id="adresse" name="adresse[]">
            </div>
            <div class="form-group col-md-2">
                <label for="taille">Taille</label>
                <select class="form-control" name="taille[]" id="taille">
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
            setupVilleAutocomplete(`villeVendeur-${newId}`, `codePostalVendeur-${newId}`, `villesVendeur-${newId}`, `codePostauxVendeur-${newId}`);
        } else {
            console.error("setupVilleAutocomplete n'est pas défini. Vérifie l'ordre des fichiers JS.");
        }
    })

    const groupeCheckbox = document.getElementById("groupe");

    function toggleSoloCheckboxes() {
        const isChecked = groupeCheckbox.checked;
        document.querySelectorAll('input[name="solo[]"]').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    }

    // Vérifie la case solo au chargement si groupe est déjà coché
    toggleSoloCheckboxes();

    // Ajoute un écouteur d'événement pour basculer toutes les cases "solo"
    groupeCheckbox.addEventListener("change", toggleSoloCheckboxes);

    // Si une nouvelle ligne est ajoutée, coche automatiquement la case solo si groupe est coché
    document.addEventListener("click", function (event) {
        if (event.target.id === "add-location") {
            setTimeout(toggleSoloCheckboxes, 100); // Petit délai pour s'assurer que la ligne est bien ajoutée
        }
    });

    // Écouteur d'événement pour décocher "groupe" si une case solo est décochée
    document.addEventListener("change", function (event) {
        if (event.target.name === "solo[]") {
            if (!event.target.checked) {
                groupeCheckbox.checked = false;
            }
        }
});


});
    
