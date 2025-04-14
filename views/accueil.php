
<div class="container">
    <div class="row d-flex align-items-start">
        <article class="col-md-3">

            <p class="ms-2 mt-3 fs-5">Agenda</p>
            <div class="mt-2 ms-2 calendar"> </div>
    
            <p class="ms-2 mt-3 fs-5">Mails</p>
            <div class="mt-2 ms-2 mailbox"></div>
            <div class="mt-2 ms-2">
                <p>PNY réalisé : <?= number_format($commissions, 2, ',', ' ') ?> €</p>
            </div>
        </article>
        <article class="col-md-8 d-flex flex-column justify-content-center">
            <div id="map" style="height: 590px; width: 100%;"></div>
        </article>
        <article class="col-md-1 d-flex flex-column justify-content-center">
            <label>Filtres :</label>
            <div>
                <input type="checkbox" id="filtre-client" name="filtre-type" value="client" onchange="filtrerMarkers()">
                <label for="filtre-client">Clients</label>
            </div>
            <div>
                <input type="checkbox" id="filtre-vendeur" name="filtre-type" value="vendeur" onchange="filtrerMarkers()">
                <label for="filtre-vendeur">Vendeurs</label>
            </div>
            <div>
                <input type="checkbox" id="filtre-acheteur" name="filtre-type" value="acheteur" onchange="filtrerMarkers()">
                <label for="filtre-acheteur">Acheteurs</label>
            </div>
            <div>
                <input type="checkbox" id="filtre-neutre" name="filtre-type" value="neutre" onchange="filtrerMarkers()">
                <label for="filtre-neutre">Neutres</label>
            </div>
        </article>
    </div>
    <!-- Modale personnalisée -->
    <div id="popupAjoutEvenement" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutEvenement')">&times;</span>
            <h5>Ajouter un événement</h5>

            <form class="justify-content-center infoContactForm" id="eventForm" method="POST">
                <div class="row mt-2 justify-content-center w-100 px-3">

                    <input type="hidden" name="user_id" value="1"> <!-- À adapter -->

                    <div class="form-group w-100 mb-2">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>

                    <div class="form-group w-100 mb-2">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>

                    <div class="form-group w-100 mb-2">
                        <label for="location">Lieu</label>
                        <input type="text" class="form-control" name="location" id="location">
                    </div>

                    <div class="form-group w-100 mb-2">
                        <label for="start">Début</label>
                        <input type="datetime-local" class="form-control" name="start" id="start" required>
                    </div>

                    <div class="form-group w-100 mb-2">
                        <label for="end">Fin</label>
                        <input type="datetime-local" class="form-control" name="end" id="end">
                    </div>

                    <div class="form-group w-100 mb-3">
                        <input class="form-check-input me-2" type="checkbox" name="allDay" id="allDay">
                        <label class="form-check-label" for="allDay">Toute la journée</label>
                    </div>

                    <div class="form-group col-md-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/map.js" defer></script>
