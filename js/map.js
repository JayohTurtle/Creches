// Initialiser la carte Leaflet
var map = L.map('map').setView([48.8566, 2.3522], 6); // Centre par défaut sur Paris

// Ajouter une couche OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Icône bleue pour les crèches normales
let blueIcon = L.divIcon({
    className: 'custom-icon',
    html: '<i class="fas fa-map-marker-alt" style="color:blue; font-size:24px;"></i>',
    iconSize: [25, 41],
    iconAnchor: [12, 41]
});

// Icône rouge pour les crèches à vendre
let redIcon = L.divIcon({
    className: 'custom-icon',
    html: '<i class="fas fa-map-marker-alt" style="color:red; font-size:24px;"></i>',
    iconSize: [25, 41],
    iconAnchor: [12, 41]
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





