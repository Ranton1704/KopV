<div class="container-fluid mt-4">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h5>Filtrer les résultats</h5>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Classe de Confort</label>
                        <div class="form-check"><input class="form-check-input filter-class" type="checkbox" value="STANDARD" id="c1"><label class="form-check-label" for="c1">Standard</label></div>
                        <div class="form-check"><input class="form-check-input filter-class" type="checkbox" value="CONFORT" id="c2"><label class="form-check-label" for="c2">Confort</label></div>
                        <div class="form-check"><input class="form-check-input filter-class" type="checkbox" value="VIP" id="c3"><label class="form-check-label" for="c3">VIP</label></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Heure de départ</label>
                        <div class="form-check"><input class="form-check-input" type="checkbox" value="matin" id="h1"><label class="form-check-label" for="h1">Matin (04h - 12h)</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" value="aprem" id="h2"><label class="form-check-label" for="h2">Après-midi / Nuit</label></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h4 class="mb-4">Voyages disponibles pour : <span class="text-primary"><?= esc($_GET['departure'] ?? '') ?> ➔ <?= esc($_GET['arrival'] ?? '') ?></span></h4>
            
            <div class="card card-trip shadow-sm mb-3 border-left border-primary" style="border-left: 5px solid #0d6efd !important;">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <h5 class="mb-1 text-uppercase">Cotisse Transport</h5>
                            <span class="badge bg-warning text-dark">Classe : VIP</span>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="d-flex justify-content-center align-items-center">
                                <div><h4 class="mb-0">06:00</h4><small class="text-muted">Gare Privée</small></div>
                                <div class="mx-3 text-muted">➔</div>
                                <div><h4 class="mb-0">11:30</h4><small class="text-muted">Arrivée estimée</small></div>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <h5 class="text-success mb-0">35 000 Ariary</h5>
                            <small class="text-danger">8 places dispos</small>
                        </div>
                        <div class="col-md-3 text-end">
                            <button type="button" class="btn btn-outline-secondary btn-sm me-2 btn-view-details" 
                                    data-cooperative="Cotisse Transport"
                                    data-escales="Moramanga (Arrêt repas de 20 min)"
                                    data-bagages="Soute fermée sécurisée. Maximum 20kg par personne."
                                    data-vehicule="Mercedes Sprinter Climatisé - Prises USB fonctionnelles"
                                    data-annulation="Annulation gratuite jusqu'à 24h avant le départ.">
                                Détails
                            </button>
                            <a href="<?= base_url('booking/seat-map?trip_id=123&passengers=' . esc($_GET['passengers'] ?? 1)) ?>" class="btn btn-primary">Choisir</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if(false): ?> <div class="alert alert-info text-center py-5 shadow-sm">
                <h3>Aucun départ disponible à cette date 😕</h3>
                <p>Les coopératives n'ont pas encore programmé de véhicules ou le convoi est complet. Essayez de chercher aux dates adjacentes.</p>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="modal fade" id="tripDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalCooperativeName">Détails du Trajet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>ℹ️ Spécifications du Véhicule</h6>
                <p id="modalVehicule" class="text-muted small"></p>
                
                <h6>📍 Itinéraire & Escales</h6>
                <p id="modalEscales" class="text-muted small"></p>
                
                <h6>🧳 Politique des Bagages</h6>
                <p id="modalBagages" class="text-muted small"></p>
                
                <h6>⚠️ Règles d'annulation</h6>
                <p id="modalAnnulation" class="text-muted small"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
// Logique d'affichage dynamique de la Modal via les data attributes
document.querySelectorAll('.btn-view-details').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('modalCooperativeName').innerText = this.getAttribute('data-cooperative');
        document.getElementById('modalVehicule').innerText = this.getAttribute('data-vehicule');
        document.getElementById('modalEscales').innerText = this.getAttribute('data-escales');
        document.getElementById('modalBagages').innerText = this.getAttribute('data-bagages');
        document.getElementById('modalAnnulation').innerText = this.getAttribute('data-annulation');
        
        var myModal = new bootstrap.Modal(document.getElementById('tripDetailsModal'));
        myModal.show();
    });
});
</script>