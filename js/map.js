/// 1. Initialiser la carte Leaflet
const map = L.map('map').setView([46.853354, 1.888334], 6);

// 2. Ajouter une couche OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// 3. Définir les icônes AVANT toute utilisation
let icons = {
    client: L.icon({ iconUrl: 'assets/images/red-marker.png', iconSize: [24, 24], iconAnchor: [12, 24] }),
    vendeur: L.icon({ iconUrl: 'assets/images/target.png', iconSize: [16, 16], iconAnchor: [8, 16] }),
    acheteur: L.icon({ iconUrl: 'assets/images/blue-marker.png', iconSize: [24, 24], iconAnchor: [12, 24] }),
    neutre: L.icon({ iconUrl: 'assets/images/contact.png', iconSize: [16, 16], iconAnchor: [8, 16] })
};

// 4. Ensuite tu peux appeler chargerMarkers et les autres fonctions
let markers = [];
let filtres = new Set(["client", "vendeur", "acheteur", "neutre"]);

// Fonction pour charger et afficher les marqueurs
function chargerMarkers() {
    markers.forEach(marker => map.removeLayer(marker)); // Supprimer les anciens marqueurs
    markers = []; // Réinitialiser la liste des marqueurs

    fetch('http://localhost/creches/API.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(point => {
                console.log(`Point: ${point.identifiant}, Statut: ${point.statut}`); // Ajout pour débug
                let statutBrut = point.statut || "inconnu";
                let statut = statutBrut.trim().toLowerCase();
                let vente = point.vente ? point.vente.trim().toLowerCase() : ""; // Récupère la colonne 'vente'
                let statutLocalisation = point.statut_localisation ? point.statut_localisation.trim().toLowerCase() : ""; // Récupère le statut de localisation
                let statutClient = point.statut_client ? point.statut_client.trim().toLowerCase() : ""; // Statut du client

                console.log("Point:", point.identifiant, ", Statut brut:", statutBrut, ", Statut normalisé:", statut);
                // Condition pour exclure les points où le niveau est 'solo' et le statut est 'Vendu'
                if (vente === "solo" && statutLocalisation === "vendu") {
                    return; // Ne pas afficher ce point
                }

                let statutFinal;

                if (vente === "groupe") {
                    statutFinal = "client";
                } else if (vente === "solo" && statut === "a vendre") {
                    statutFinal = "client";
                } else if (vente=== "solo" && statut === "vendu") {
                    return; // Exclure ce point
                } else {
                    statutFinal = statutBrut || "neutre";
                }

                // Nettoyage
                console.log(`Point: ${point.identifiant}, Niveau: ${vente}, Vente: ${statut}, Statut final: ${statutFinal}`);

                let iconToUse = icons[statutFinal] || null;
                console.log(`iconToUse pour ${statutFinal} :`, iconToUse);
                

                console.log("iconToUse pour", statut, ":", iconToUse);

                console.log("Statut à tester dans filtres :", statut, "| Filtres actifs :", Array.from(filtres));
                console.log("filtres.has(", statut, "):", filtres.has(statut));

                // Vérifier si l'icône est définie et si le statut est dans les filtres
                if (iconToUse && filtres.has(statutFinal)){
                    let marker = L.marker([point.lat, point.lng], { icon: iconToUse })
                        .addTo(map)
                        .bindPopup(`<b>Identifiant: ${point.identifiant}</b><br>Statut: ${statutFinal}`);
                    markers.push(marker);
                }
            });
        })
        .catch(error => console.error('Erreur lors du chargement des points:', error));
}

// Fonction pour filtrer les marqueurs en fonction des filtres sélectionnés
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
    chargerMarkers(); // Recharger les marqueurs avec les nouveaux filtres
}

document.addEventListener("DOMContentLoaded", () => {
    chargerMarkers(); // Charger les marqueurs au démarrage
});
