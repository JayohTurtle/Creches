// Initialiser la carte Leaflet
const map = L.map('map').setView([46.853354, 1.888334], 6);

// Ajouter une couche OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Icônes pour les marqueurs
let icons = {
    client: L.icon({ iconUrl: 'assets/images/red-marker.png', iconSize: [24, 24], iconAnchor: [12, 24] }),
    vendeur: L.icon({ iconUrl: 'assets/images/target.png', iconSize: [16, 16], iconAnchor: [8, 16] }),
    acheteur: L.icon({ iconUrl: 'assets/images/blue-marker.png', iconSize: [24, 24], iconAnchor: [12, 24] }),
    neutre: L.icon({ iconUrl: 'assets/images/contact.png', iconSize: [16, 16], iconAnchor: [8, 16] })
};

// Stocker les marqueurs pour pouvoir les filtrer
let markers = [];
let filtres = new Set(["client", "vendeur", "acheteur", "neutre"]); // Par défaut, tout est affiché

// Fonction pour charger et afficher les marqueurs
function chargerMarkers() {
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];

    fetch('http://localhost/creches/API.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(point => {
                let statut = point.statut ? point.statut.trim().toLowerCase() : "inconnu";
                if (icons[statut] && filtres.has(statut)) {
                    let marker = L.marker([point.lat, point.lng], { icon: icons[statut] })
                        .addTo(map)
                        .bindPopup(`<b>Identifiant: ${point.identifiant}</b><br>Statut: ${statut}`);
                    markers.push(marker);
                }
            });
        })
        .catch(error => console.error('Erreur lors du chargement des points:', error));
    }

    function filtrerMarkers() {
        let nouvellesSelections = new Set();
        document.querySelectorAll('input[name="filtre-type"]:checked').forEach(checkbox => {
            nouvellesSelections.add(checkbox.value);
        });

        // Si aucune case n'est cochée, réafficher tous les marqueurs
        if (nouvellesSelections.size === 0) {
            filtres = new Set(["client", "vendeur", "acheteur", "neutre"]);
        } else {
            filtres = nouvellesSelections;
        }

        console.log("Filtres actifs :", Array.from(filtres)); // Debugging
        chargerMarkers();
}

document.addEventListener("DOMContentLoaded", () => {
    chargerMarkers();
});







