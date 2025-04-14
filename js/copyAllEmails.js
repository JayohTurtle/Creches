function copierTousLesEmails() {
    let emails = []

    // Sélectionner toutes les checkboxes cochées
    document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
        let parentDiv = checkbox.closest('.article')
        let emailSpan = parentDiv.querySelector('[id^="emailACopier_"]')

        if (emailSpan) {
            let email = emailSpan.textContent.trim()
            if (email) {
                emails.push(email)
            }
        }
    })

    if (emails.length > 0) {
        let texte = emails.join(', ')

        // Copier dans le presse-papier
        navigator.clipboard.writeText(texte).then(() => {
            alert("Les emails sélectionnés ont été copiés !")
            
            // Mettre les emails dans le champ hidden du formulaire
            document.getElementById("emailsInput").value = texte

            // Soumettre le formulaire
            document.getElementById("emailForm").submit()

        }).catch(err => {
            console.error("Erreur lors de la copie des emails : ", err)
        })
    } else {
        alert("Aucun email sélectionné !")
    }
}


