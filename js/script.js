

const choiceBuyer = document.getElementById('buyer')
const choiceSeller = document.getElementById('seller')
const sellerChosen = document.getElementById('seller-choice')
const interest = document.getElementById('interest')
const buyerTitle = document.getElementById('buyer-title')

choiceSeller.addEventListener('click', () => {

    sellerChosen.classList.remove('d-none')
    for (let i = 1; i <= nombreClic; i++) {
        const existingElement = document.getElementById(`new-row${i}`);
        if (existingElement) {
            existingElement.classList.add('d-none');
        }
    }
    interest.classList.add('d-none')
    buyerTitle.classList.add('d-none')

})

choiceBuyer.addEventListener('click', () => {

    sellerChosen.classList.add('d-none')
    for (let i = 1; i <= nombreClic; i++) {
        const existingElement = document.getElementById(`seller-choice${i}`);
        if (existingElement) {
            existingElement.classList.add('d-none');
            existingElement.nextElementSibling.remove();
        }
    }
    interest.classList.remove('d-none')
    buyerTitle.classList.remove('d-none')

})

const addLocation = document.getElementById('add-location')
const addInterest = document.getElementById('add-interest')

let nombreClic = 0
let nombreClicInterest = 0

document.addEventListener('DOMContentLoaded', () => {          
    addLocation.addEventListener('click', () => {

        nombreClic ++

        const adresseContainer = document.getElementById('adresse')
        
        const newRow = document.createElement('div')
        newRow.className = 'row form-row mt-3'
        newRow.setAttribute('id', 'new-row' + nombreClic)
        
        const villeDiv = document.createElement('div')
        villeDiv.className = 'form-group col-md-3'
        const villeLabel = document.createElement('label')
        villeLabel.setAttribute('for', 'ville')
        villeLabel.textContent = 'Ville'
        const villeInput = document.createElement('input')
        villeInput.className = 'form-control'
        villeInput.setAttribute('list', 'villes')
        villeInput.setAttribute('name', 'ville' + nombreClic)
        villeInput.setAttribute('id', 'ville'+ nombreClic)
        villeDiv.appendChild(villeLabel)
        villeDiv.appendChild(villeInput)
        
        const postalCodeDiv = document.createElement('div')
        postalCodeDiv.className = 'form-group col-md-2'
        const postalCodeLabel = document.createElement('label')
        postalCodeLabel.setAttribute('for', 'postalCode')
        postalCodeLabel.textContent = 'Code postal'
        const postalCodeInput = document.createElement('input')
        postalCodeInput.className = 'form-control'
        postalCodeInput.setAttribute('list', 'postalCodes')
        postalCodeInput.setAttribute('name', 'postalCode' + nombreClic)
        postalCodeInput.setAttribute('id', 'postalCode' + nombreClic)
        postalCodeDiv.appendChild(postalCodeLabel)
        postalCodeDiv.appendChild(postalCodeInput)
        
        const departementDiv = document.createElement('div')
        departementDiv.className = 'form-group col-md-3'
        const departementLabel = document.createElement('label')
        departementLabel.setAttribute('for', 'departement')
        departementLabel.textContent = 'Département'
        const departementInput = document.createElement('input')
        departementInput.className = 'form-control'
        departementInput.setAttribute('list', 'departements')
        departementInput.setAttribute('name', 'departement' + nombreClic)
        departementInput.setAttribute('id', 'departement' + nombreClic)
        departementDiv.appendChild(departementLabel)
        departementDiv.appendChild(departementInput)

        const statutDiv = document.createElement('div')
        if (choiceSeller.checked){
            
            statutDiv.className = 'form-group col-md-2'
            statutDiv.setAttribute('id', 'seller-choice' + nombreClic)
            const statutLabel = document.createElement('label')
            statutLabel.setAttribute('for', 'statut')
            statutLabel.textContent = 'Statut'
            const statutSelect = document.createElement('select')
            statutSelect.className = 'form-control'
            statutSelect.setAttribute('name', 'statut' + nombreClic)
            statutSelect.setAttribute('id', 'statut' + nombreClic)
            const statutOptions = [
                { value: 'approche', text: 'Approche' },
                { value: 'nego', text: 'Négociation' },
                { value: 'mandatEnvoye', text: 'Mandat envoyé' },
                { value: 'mandatSigne', text: 'Mandat signé' },
                { value: 'vendu', text: 'Vendu' }
              ];

              statutOptions.forEach(function(option) {
                const opt = document.createElement('option');
                opt.value = option.value;
                opt.textContent = option.text;
                statutSelect.appendChild(opt);
              });

              statutLabel.appendChild(statutSelect)
              statutDiv.appendChild(statutLabel)

        }

        const removeDiv = document.createElement('div')
        removeDiv.className = 'form-group col-md-1 d-flex align-items-end'
        const removeButton = document.createElement('button')
        removeButton.className = 'btn btn-danger'
        removeButton.innerHTML = '<i class="fas fa-trash-alt"></i>'
        removeButton.addEventListener('click', function() {
        adresseContainer.removeChild(newRow)
        })
        removeDiv.appendChild(removeButton)
        
        newRow.appendChild(villeDiv)
        newRow.appendChild(postalCodeDiv)
        newRow.appendChild(departementDiv)
        if (choiceSeller.checked){
            newRow.appendChild(statutDiv)
        }
        newRow.appendChild(removeDiv)

        adresseContainer.prepend(newRow)
    })
    addInterest.addEventListener('click', () => {

        nombreClicInterest ++

        const interestContainer = document.getElementById('interest')
        
        const newRowInterest = document.createElement('div')
        newRowInterest.className = 'row form-row mt-3'
        
        const villeDivInterest = document.createElement('div')
        villeDivInterest.className = 'form-group col-md-3'
        const villeLabelInterest = document.createElement('label')
        villeLabelInterest.setAttribute('for', 'villeInterest')
        villeLabelInterest.textContent = 'Ville'
        const villeInputInterest = document.createElement('input')
        villeInputInterest.className = 'form-control'
        villeInputInterest.setAttribute('list', 'villes')
        villeInputInterest.setAttribute('name', 'villeInterest')
        villeInputInterest.setAttribute('id', 'villeInterest' + nombreClicInterest)
        villeDivInterest.appendChild(villeLabelInterest)
        villeDivInterest.appendChild(villeInputInterest)
        
        const departementDivInterest = document.createElement('div')
        departementDivInterest.className = 'form-group col-md-3'
        const departementLabelInterest = document.createElement('label')
        departementLabelInterest.setAttribute('for', 'departementInterest')
        departementLabelInterest.textContent = 'Département'
        const departementInputInterest = document.createElement('input')
        departementInputInterest.className = 'form-control'
        departementInputInterest.setAttribute('list', 'departements')
        departementInputInterest.setAttribute('name', 'departementInterest')
        departementInputInterest.setAttribute('id', 'departementInterest' + nombreClicInterest)
        departementDivInterest.appendChild(departementLabelInterest)
        departementDivInterest.appendChild(departementInputInterest)

        const identifierDiv = document.createElement('div')
        identifierDiv.className = 'form-group col-md-3'
        const identifierLabel = document.createElement('label')
        identifierLabel.setAttribute('for', 'identifiant')
        identifierLabel.textContent = 'Identifiant'
        const identifierInput = document.createElement('input')
        identifierInput.className = 'form-control'
        identifierInput.setAttribute('list', 'identifiants')
        identifierInput.setAttribute('name', 'identifiant')
        identifierInput.setAttribute('id', 'identifiant'+ nombreClicInterest)
        identifierDiv.appendChild(identifierLabel)
        identifierDiv.appendChild(identifierInput)

        const niveauDiv = document.createElement('div')
        niveauDiv.className = 'form-group col-md-2'
        const niveauLabel = document.createElement('label')
        niveauLabel.setAttribute('for', 'niveau')
        niveauLabel.textContent = 'Niveau'
        niveauDiv.appendChild(niveauLabel)
        const niveauSelect = document.createElement('select')
        niveauSelect.className = 'form-control'
        niveauSelect.setAttribute('name', 'niveau')
        niveauSelect.setAttribute('id', 'niveau'+ nombreClicInterest)
        const niveauOptions = [
        { value: null, text: '' },
        { value: 'interesse', text: 'Intéressé' },
        { value: 'NDAenvoye', text: 'NDA envoyé' },
        { value: 'dossierEnvoye', text: 'Dossier envoyé' },
        { value: 'LOI', text: 'LOI' },
        { value: 'achat', text: 'Achat réalisé' }
        ]
        niveauOptions.forEach(function(optionData) {
        const option = document.createElement('option')
        option.value = optionData.value
        option.textContent = optionData.text
        niveauSelect.appendChild(option)
        })
        niveauDiv.appendChild(niveauSelect)

        const removeDivInterest = document.createElement('div')
        removeDivInterest.className = 'form-group col-md-1 d-flex align-items-end'
        const removeButtonInterest = document.createElement('button')
        removeButtonInterest.className = 'btn btn-danger'
        removeButtonInterest.innerHTML = '<i class="fas fa-trash-alt"></i>'
        removeButtonInterest.addEventListener('click', function() {
        interestContainer.removeChild(newRowInterest)
        })
        removeDivInterest.appendChild(removeButtonInterest)
        
        newRowInterest.appendChild(villeDivInterest)
        newRowInterest.appendChild(identifierDiv)
        newRowInterest.appendChild(departementDivInterest)
        newRowInterest.appendChild(niveauDiv)
        newRowInterest.appendChild(removeDivInterest)

        interestContainer.prepend(newRowInterest)
    })
})