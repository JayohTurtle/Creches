
function copierTextePopup(id, icon) {
    let texte = document.getElementById(id).innerText;

    navigator.clipboard.writeText(texte).then(() => {
        // Changer la couleur et la taille de l'icône pour indiquer la copie
        icon.style.transform = "scale(1.1)";
        icon.style.filter = "brightness(2)";
        
        // Réinitialiser après 1 seconde
        setTimeout(() => {
            icon.style.transform = "scale(1)";
            icon.style.filter = "none";
        }, 1000);
    }).catch(err => {
        console.error("Erreur lors de la copie :", err);
    });
}

