
const links = document.querySelectorAll('.nav-link')

// Ajouter un gestionnaire d'événements pour chaque lien
links.forEach(link => {
  // Vérifier si le lien correspond à l'URL actuelle
  if (link.href === window.location.href) {
    link.style.color = '#90CAF9' // Appliquer la couleur #90CAF9 au lien actif
    link.style.backgroundColor = '#000000'
  }
})
