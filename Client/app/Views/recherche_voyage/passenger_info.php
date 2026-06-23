<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="kopv-container">
    <!-- Progress Steps -->
    <div class="kopv-progress">
        <div class="kopv-progress-step completed">
            <div class="kopv-progress-number">1</div>
            <div class="kopv-progress-label">Recherche</div>
        </div>
        <div class="kopv-progress-step completed">
            <div class="kopv-progress-number">2</div>
            <div class="kopv-progress-label">Résultats</div>
        </div>
        <div class="kopv-progress-step completed">
            <div class="kopv-progress-number">3</div>
            <div class="kopv-progress-label">Sièges</div>
        </div>
        <div class="kopv-progress-step active">
            <div class="kopv-progress-number">4</div>
            <div class="kopv-progress-label">Passagers</div>
        </div>
        <div class="kopv-progress-step">
            <div class="kopv-progress-number">5</div>
            <div class="kopv-progress-label">Paiement</div>
        </div>
    </div>

    <div class="kopv-passenger-header">
        <div class="kopv-passenger-eyebrow">Informations des voyageurs</div>
        <h1 class="kopv-passenger-title">
            Détails des <em class="kopv-passenger-title-em">passagers</em>
        </h1>
        <p class="kopv-passenger-subtitle">
            Remplissez les informations pour chaque passager sélectionné
        </p>
    </div>

    <div class="kopv-card kopv-passenger-form">
        <form action="<?= base_url('Voyage/submit-passengers') ?>" method="POST" id="passengersForm">
            <input type="hidden" name="trip_id" value="<?= esc($trip_id ?? $_POST['trip_id'] ?? '') ?>">
            <input type="hidden" name="chosen_seats" value="<?= esc($chosen_seats ?? $_POST['chosen_seats'] ?? '') ?>">

            <?php 
            // Récupération des sièges transmis (ex: "1,2,4")
            $seatsString = $chosen_seats ?? $_POST['chosen_seats'] ?? '1'; 
            $seatsArray = explode(',', $seatsString);
            
            // Le premier passager est considéré comme le passager principal (acheteur)
            $isFirst = true; 
            
            foreach ($seatsArray as $index => $seatId): 
            ?>
                <div class="kopv-passenger-card">
                    <div class="kopv-passenger-card-header">
                        <div class="kopv-passenger-info">
                            <div class="kopv-passenger-icon">👤</div>
                            <div>
                                <div class="kopv-passenger-name">
                                    Passager #<?= $index + 1 ?>
                                </div>
                                <div class="kopv-passenger-seat">
                                    Siège <?= esc($seatId) ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($isFirst): ?>
                            <span class="kopv-badge kopv-badge-success">
                                Responsable de la réservation
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="kopv-passenger-card-body">
                        <?php if ($isFirst): ?>
                            <div class="kopv-autofill-option">
                                <label class="kopv-autofill-label">
                                    <input type="checkbox" id="autoFillProfile">
                                    <span>⚡ Remplir automatiquement avec mes informations de profil</span>
                                </label>
                            </div>
                        <?php endif; ?>

                        <div class="kopv-passenger-fields">
                            <div class="kopv-form-group">
                                <label for="name_<?= esc($seatId) ?>" class="kopv-label">Nom complet</label>
                                <input type="text" 
                                       id="name_<?= esc($seatId) ?>"
                                       name="passengers[<?= esc($seatId) ?>][name]" 
                                       class="kopv-input passenger-name" 
                                       placeholder="Ex: RAZAFIMAHATRATRA Jean" 
                                       required>
                                <small class="kopv-form-hint">Exactement comme sur la CIN</small>
                            </div>

                            <div class="kopv-form-group">
                                <label for="phone_<?= esc($seatId) ?>" class="kopv-label">Numéro de téléphone</label>
                                <div class="kopv-phone-input">
                                    <span class="kopv-phone-prefix">+261</span>
                                    <input type="tel" 
                                           id="phone_<?= esc($seatId) ?>"
                                           name="passengers[<?= esc($seatId) ?>][phone]" 
                                           class="kopv-input passenger-phone" 
                                           placeholder="Ex: 341234567" 
                                           pattern="[0-9]{9}"
                                           title="Veuillez entrer les 9 chiffres après l'indicatif"
                                           <?= $isFirst ? 'required' : '' ?>>
                                </div>
                                <small class="kopv-form-hint">
                                    <?= $isFirst ? 'Obligatoire pour le passager principal' : 'Optionnel' ?>
                                </small>
                            </div>

                            <div class="kopv-form-group">
                                <label for="cin_<?= esc($seatId) ?>" class="kopv-label">Numéro de CIN</label>
                                <input type="text" 
                                       id="cin_<?= esc($seatId) ?>"
                                       name="passengers[<?= esc($seatId) ?>][cin]" 
                                       class="kopv-input passenger-cin" 
                                       placeholder="Ex: 101211023456" 
                                       pattern="[0-9]{12}" 
                                       title="Le numéro de CIN à Madagascar comporte exactement 12 chiffres"
                                       required>
                                <small class="kopv-form-hint">12 chiffres requis</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
            $isFirst = false;
            endforeach; 
            ?>

            <div class="kopv-passenger-warning">
                ⚠️ <strong>Attention :</strong> Assurez-vous de l'exactitude des informations. Ces données seront transmises à la police de la route lors de l'établissement du manifeste de voyage de la coopérative.
            </div>

            <div class="kopv-passenger-actions">
                <a href="javascript:history.back()" class="kopv-btn kopv-btn-outline">
                    ← Retour
                </a>
                <button type="submit" class="kopv-btn kopv-btn-primary kopv-btn-large">
                    Passer au paiement sécurisé
                </button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url('assets/js/passenger-info.js') ?>"></script>
<?= $this->endSection() ?>