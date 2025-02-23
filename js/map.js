// Initialiser la carte Leaflet
var map = L.map('map').setView([46.853354, 1.888334], 6);

// Ajouter une couche OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Icône bleue pour les crèches normales
let blueIcon = L.icon({
    /*className: 'custom-icon',*/
    iconUrl: 'assets/images/blue-marker.png',
    iconSize: [24, 24],
    iconAnchor: [12, 24]
});

// Icône rouge pour les crèches à vendre
let redIcon = L.icon({
    iconUrl: 'assets/images/red-marker.png',
    iconSize: [24, 24],
    iconAnchor: [12, 24]
});

// Charger les données et afficher les marqueurs
fetch('http://localhost/creches/API.php')
  .then(response => response.json())
  .then(data => {
      data.forEach(point => {
          
          // Nettoyer la donnée (supprimer espaces avant/après et mettre en minuscule)
          let sens = point.sens.trim().toLowerCase();

          // Vérification de la condition
          let icon = (sens === "vendeur") ? redIcon : blueIcon;

          L.marker([point.lat, point.lng], { icon: icon })
            .addTo(map)
            .bindPopup(`<b>Identifiant: ${point.identifiant}</b>`);
      });
  })
  .catch(error => console.error('Erreur lors du chargement des points:', error));





