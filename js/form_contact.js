//suppression du success lorsqu'on clique sur un nouvel input
document.addEventListener("DOMContentLoaded", function () {
    const successMessage = document.getElementById("success-message");
    const formInputs = document.querySelectorAll("input, textarea, select");

    if (successMessage) {
        formInputs.forEach(input => {
            input.addEventListener("focus", function () {
                successMessage.classList.add("hidden"); // Ajoute la classe qui active la transition
                setTimeout(() => {
                    successMessage.style.display = "none"; // Supprime après l'animation
                }, 500); // Correspond au temps de transition (0.5s)
            });
        });
    }
});

let nombreClic = 0;
let nombreClicInterest = 0
const choiceBuyer = document.getElementById('buyer')
const choiceSeller = document.getElementById('seller')
const statutVendeur = document.getElementById('statutVendeur')
const valoVendeur = document.getElementById('valoVendeur')
const commVendeur = document.getElementById('commVendeur')
const buyerTitle = document.getElementById('buyer-title')
const crecheSizeChoice = document.getElementById('crecheSizeChoice')
const addLocation = document.getElementById('add-location')
const addInterest = document.getElementById('add-interest')
const interest = document.getElementById('interest')
const interestGeneral = document.getElementById('interestGeneral')

//gestion de l'affichage en fonction du choix acheteur/vendeur
choiceSeller.addEventListener('click', () => {

    statutVendeur.classList.remove('d-none')
    commVendeur.classList.remove('d-none')
    valoVendeur.classList.remove('d-none')

    for (let i = 1; i <= nombreClic; i++) {
        const existingElement = document.getElementById(`new-row${i}`)
        if (existingElement) {
            existingElement.classList.add('d-none');
        }
    }
    interest.classList.add('d-none')
    buyerTitle.classList.add('d-none')
    crecheSizeChoice.classList.add('d-none')
    addInterest.classList.add('d-none')

})

choiceBuyer.addEventListener('click', () => {

    statutVendeur.classList.add('d-none')
    commVendeur.classList.add('d-none')
    valoVendeur.classList.add('d-none')
    for (let i = 1; i <= nombreClic; i++) {
        const existingElement = document.getElementById(`seller-choice${i}`)
        if (existingElement) {
            existingElement.classList.add('d-none')
            existingElement.nextElementSibling.remove()
        }
    }
    interest.classList.remove('d-none')
    buyerTitle.classList.remove('d-none')
    crecheSizeChoice.classList.remove('d-none')
    addInterest.classList.remove('d-none')

})

document.addEventListener('DOMContentLoaded', () => {          
    addLocation.addEventListener('click', () => {
    nombreClic++;

        const location = document.getElementById('location');

        // Création d'une nouvelle ligne avec un ID unique
        const newRow = document.createElement('div');
        newRow.classList.add('row', 'form-row', 'mt-3');
        newRow.setAttribute('id', 'location-row-' + nombreClic);

        newRow.innerHTML = `
            <div class="form-group col-md-3">
                <label for="ville">Ville</label>
                <input class="form-control" list="villes" name="ville[]">
            </div>
            <div class="form-group col-md-2">
                <label for="codePostal">Code postal</label>
                <input class="form-control" name="codePostal[]">
            </div>
            <div class="form-group col-md-3">
                <label for="adresse">Adresse</label>
                <input class="form-control" name="adresse[]">
            </div>
            <div class="form-group col-md-2">
                <label for="taille">Taille</label>
                <select class="form-control" name="taille[]">
                    <option value="Micro-crèche">Micro-crèche</option>
                    <option value="Crèche">Crèche</option>
                </select>
            </div>
            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-location" data-id="location-row-${nombreClic}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;

        location.appendChild(newRow);
    });

    // Gestion de la suppression des lignes ajoutées dynamiquement
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-location') || event.target.closest('.remove-location')) {
            const rowId = event.target.closest('.remove-location').getAttribute('data-id');
            document.getElementById(rowId).remove();
        }
    });
});


document.addEventListener('DOMContentLoaded', () => {
    addInterest.addEventListener('click', () => {
        nombreClicInterest++;
    
        // Création d'une nouvelle ligne avec un ID unique
        const newRowInterest = document.createElement('div');
        newRowInterest.classList.add('row', 'form-row', 'mt-3');
        newRowInterest.setAttribute('id', 'interest-row-' + nombreClicInterest);

        newRowInterest.innerHTML = `
            <div class="form-group col-md-2">
                <label for="villeInterest">Ville</label>
                <input class="form-control" list="villesInterest" name="villeInterest[]">
            </div>
            <div class="form-group col-md-2">
                <label for="codePostalInterest">Code postal</label>
                <input class="form-control" name="codePostalInterest[]">
            </div>
            <div class="form-group col-md-1">
                <label for="rayonInterest">Rayon</label>
                <input class="form-control" name="rayon[]">
            </div>
            <div class="form-group col-md-3">
                <label for="departementInterest">Département</label>
                <input class="form-control" list="departementsInterest" name="departementInterest[]">
            </div>
            <div class="form-group col-md-3">
                <label for="regionInterest">Région</label>
                <input class="form-control" list="regionsInterest" name="regionInterest[]">
            </div>

            <div class="form-group col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-interest" data-id="interest-row-${nombreClicInterest}">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;

        interestGeneral.appendChild(newRowInterest);
    });

    // Gestion de la suppression des lignes ajoutées dynamiquement
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-interest') || event.target.closest('.remove-interest')) {
            const rowInterestId = event.target.closest('.remove-interest').getAttribute('data-id');
            document.getElementById(rowInterestId).remove();
        }
    });
});

 //Gestion des recherches par crèches ou groupes
 const radioButtonsCrecheGroup = document.querySelectorAll('input[name="crecheGroup"]')
 const inputCrecheGroup = {
    choixCreche: "inputChoixCreche",
    choixGroup: "inputChoixGroup",
 }

 function updateVisibleInputCrecheGroup() {
     const selectedValue = document.querySelector('input[name="crecheGroup"]:checked').value;
     Object.values(inputCrecheGroup).forEach(id => document.getElementById(id).classList.add('d-none'));
     document.getElementById(inputCrecheGroup[selectedValue]).classList.remove('d-none');
 }

 radioButtonsCrecheGroup.forEach(radio => radio.addEventListener("change", updateVisibleInputCrecheGroup));
 updateVisibleInputCrecheGroup(); // Exécuter au chargement
