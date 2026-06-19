<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between mb-4 text-muted small">
                <span>1. Recherche ➔</span>
                <span>2. Places ➔</span>
                <span class="text-primary font-weight-bold">3. Infos Passagers ➔</span>
                <span>4. Paiement</span>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Informations des Voyageurs</h4>
                </div>
                <div class="card-body">
                    
                    <form action="<?= base_url('booking/submit-passengers') ?>" method="POST" id="passengersForm">
                        
                        <input type="hidden" name="trip_id" value="<?= esc($trip_id ?? $_POST['trip_id'] ?? '') ?>">
                        <input type="hidden" name="chosen_seats" value="<?= esc($chosen_seats ?? $_POST['chosen_seats'] ?? '') ?>">

                        <?php 
                        // Simulation de la récupération des sièges transmis (ex: "1,2,4")
                        $seatsString = $_POST['chosen_seats'] ?? '1'; 
                        $seatsArray = explode(',', $seatsString);
                        
                        // Le premier passager est considéré comme le passager principal (acheteur)
                        $isFirst = true; 
                        
                        foreach ($seatsArray as $index => $seatId): 
                        ?>
                            <div class="card mb-4 border border-light shadow-sm">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0 text-secondary">
                                        👤 Passager #<?= $index + 1 ?> 
                                        <span class="badge bg-dark ms-2">Siège <?= esc($seatId) ?></span>
                                    </h5>
                                    <?php if ($isFirst): ?>
                                        <span class="badge bg-info text-dark">Responsable de la réservation</span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    
                                    <?php if ($isFirst): ?>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="autoFillProfile">
                                            <label class="form-check-label text-primary small" for="autoFillProfile" style="cursor:pointer;">
                                                ⚡ Remplir automatiquement avec mes informations de profil
                                            </label>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label class="form-label font-weight-bold small">Nom complet (exactement comme sur la CIN)</label>
                                            <input type="text" 
                                                   name="passengers[<?= esc($seatId) ?>][name]" 
                                                   class="form-control passenger-name" 
                                                   placeholder="Ex: RAZAFIMAHATRATRA Jean" 
                                                   required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold small">Numéro de téléphone</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">+261</span>
                                                <input type="tel" 
                                                       name="passengers[<?= esc($seatId) ?>][phone]" 
                                                       class="form-control passenger-phone" 
                                                       placeholder="Ex: 341234567" 
                                                       pattern="[0-9]{9}"
                                                       title="Veuillez entrer les 9 chiffres après l'indicatif (ex: 32..., 34..., 33...)"
                                                       <?= $isFirst ? 'required' : '' ?>>
                                            </div>
                                            <small class="text-muted text-xs">Obligatoire pour le passager principal.</small>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label font-weight-bold small">Numéro de CIN (Carte d'Identité)</label>
                                            <input type="text" 
                                                   name="passengers[<?= esc($seatId) ?>][cin]" 
                                                   class="form-control passenger-cin" 
                                                   placeholder="Ex: 101211023456" 
                                                   pattern="[0-9]{12}" 
                                                   title="Le numéro de CIN à Madagascar comporte exactement 12 chiffres"
                                                   required>
                                            </div>
                                    </div>

                                </div>
                            </div>
                        <?php 
                        $isFirst = false;
                        endforeach; 
                        ?>

                        <div class="alert alert-warning small py-2">
                            ⚠️ <strong>Attention :</strong> Assurez-vous de l'exactitude des informations. Ces données seront transmises à la police de la route lors de l'établissement du manifeste de voyage de la coopérative.
                        </div>

                        <div class="text-end mt-4">
                            <a href="javascript:history.back()" class="btn btn-outline-secondary px-4 me-2">Retour au plan</a>
                            <button type="submit" class="btn btn-success btn-lg px-5">Passer au paiement sécurisé</button>
                        </div>

                    </form>
                    
                </div>
            </div>

        </div>
    </div>
</div>

<script>
// Simulation JavaScript pour l'option "Remplir automatiquement avec mon profil"
// Idéal à connecter plus tard avec l'API Spring Boot d'authentification ou la session CI4
document.getElementById('autoFillProfile')?.addEventListener('change', function() {
    const firstCard = document.querySelector('.card-body');
    const nameInput = firstCard.querySelector('.passenger-name');
    const phoneInput = firstCard.querySelector('.passenger-phone');
    const cinInput = firstCard.querySelector('.passenger-cin');

    if (this.checked) {
        // Données d'exemple (Normalement lues depuis les variables de session utilisateur)
        nameInput.value = "Rakoto ANDRIANANTENAINA";
        phoneInput.value = "345678901";
        cinInput.value = "105201098765";
    } else {
        // Réinitialiser les champs si décoché
        nameInput.value = "";
        phoneInput.value = "";
        cinInput.value = "";
    }
});

// Validation JavaScript stricte côté client avant envoi
document.getElementById('passengersForm').addEventListener('submit', function(e) {
    const cinInputs = document.querySelectorAll('.passenger-cin');
    let valid = true;

    cinInputs.forEach(input => {
        // Vérification simple de la longueur réglementaire à Madagascar (12 chiffres)
        if (input.value.trim().length !== 12 || isNaN(input.value.trim())) {
            alert(`Erreur : Le numéro de CIN "${input.value}" doit comporter exactement 12 chiffres.`);
            input.classList.add('is-invalid');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
        }
    });

    if (!valid) {
        e.preventDefault(); // Empêche la soumission du formulaire
    }
});
</script>