let villeInput = document.getElementById("ville")
let codePostalInput = document.getElementById("codePostal")
let villesList = document.getElementById("villes")
let codesList = document.getElementById("codePostaux")

villeInput.addEventListener("input", function() {
    let ville = this.value.trim()
    villesList.innerHTML = "" // Vide la liste des villes
    codesList.innerHTML = ""  // Vide la liste des codes postaux
    codePostalInput.value = "" // Réinitialise le code postal

    if (ville.length > 2) {
        fetch(`https://geo.api.gouv.fr/communes?nom=${ville}&fields=nom,codesPostaux&limit=10`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                let codesSet = new Set()
                let singleCode = null

                data.forEach(commune => {
                    let option = document.createElement("option")
                    option.value = commune.nom
                    option.dataset.codes = commune.codesPostaux.join(",")
                    villesList.appendChild(option)

                    commune.codesPostaux.forEach(code => {
                        codesSet.add(code)
                    })

                    // Stocke le code postal s'il n'y a qu'une seule ville et un seul code
                    if (data.length === 1 && commune.codesPostaux.length === 1) {
                        singleCode = commune.codesPostaux[0]
                    }
                })

                // Auto-remplit si un seul code postal, sinon, affiche la liste
                if (singleCode) {
                    codePostalInput.value = singleCode
                } else {
                    codesList.innerHTML = ""
                    codesSet.forEach(code => {
                        let codeOption = document.createElement("option")
                        codeOption.value = code
                        codesList.appendChild(codeOption)
                    })
                }
            }
        })
        .catch(error => console.error("Erreur :", error))
    }
})

villeInput.addEventListener("change", function() {
    let options = document.querySelectorAll("#villes option")
    let selectedValue = this.value
    codesList.innerHTML = "" // Vide la liste des codes postaux

    options.forEach(option => {
        if (option.value === selectedValue) {
            let codes = option.dataset.codes.split(",")

            // Auto-remplit si un seul code, sinon, affiche les choix
            if (codes.length === 1) {
                codePostalInput.value = codes[0]
            } else {
                codePostalInput.value = ""
                codes.forEach(code => {
                    let codeOption = document.createElement("option")
                    codeOption.value = code
                    codesList.appendChild(codeOption)
                })
            }
        }
    })
})




