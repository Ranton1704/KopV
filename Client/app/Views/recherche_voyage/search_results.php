<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="kopv-results-page">
    <!-- Header -->
    <div class="kopv-results-header">
        <div class="kopv-results-breadcrumb">
            <a href="<?= base_url('Voyage/search') ?>" class="kopv-breadcrumb-link">
                <i class="bi bi-arrow-left"></i>
                Nouvelle recherche
            </a>
        </div>
        <h1 class="kopv-results-title">
            <?= esc($departure ?? '') ?> <i class="bi bi-arrow-right kopv-results-arrow"></i> <?= esc($arrival ?? '') ?>
        </h1>
        <div class="kopv-results-meta">
            <span class="kopv-meta-item">
                <i class="bi bi-calendar"></i>
                <?= esc($travel_date ?? '') ?>
            </span>
            <span class="kopv-meta-item">
                <i class="bi bi-person"></i>
                <?= esc($passengers ?? 1) ?> passager(s)
            </span>
        </div>
    </div>

    <div class="kopv-results-layout">
        <!-- Filters Sidebar -->
        <aside class="kopv-filters-sidebar">
            <div class="kopv-card kopv-filters-card">
                <div class="kopv-filters-header">
                    <i class="bi bi-funnel kopv-filters-icon"></i>
                    <h3 class="kopv-filters-title">Filtres</h3>
                </div>
                
                <div class="kopv-filter-group">
                    <label class="kopv-filter-label">Classe de confort</label>
                    <div class="kopv-filter-options">
                        <label class="kopv-filter-option">
                            <input type="checkbox" class="filter-class" value="STANDARD" id="filter-standard">
                            <span class="kopv-filter-checkbox"></span>
                            <span>Standard</span>
                        </label>
                        <label class="kopv-filter-option">
                            <input type="checkbox" class="filter-class" value="CONFORT" id="filter-confort">
                            <span class="kopv-filter-checkbox"></span>
                            <span>Confort</span>
                        </label>
                        <label class="kopv-filter-option">
                            <input type="checkbox" class="filter-class" value="VIP" id="filter-vip">
                            <span class="kopv-filter-checkbox"></span>
                            <span>VIP</span>
                        </label>
                    </div>
                </div>

                <div class="kopv-filter-group">
                    <label class="kopv-filter-label">Heure de départ</label>
                    <div class="kopv-filter-options">
                        <label class="kopv-filter-option">
                            <input type="checkbox" value="matin" id="filter-morning">
                            <span class="kopv-filter-checkbox"></span>
                            <span>Matin (04h - 12h)</span>
                        </label>
                        <label class="kopv-filter-option">
                            <input type="checkbox" value="aprem" id="filter-afternoon">
                            <span class="kopv-filter-checkbox"></span>
                            <span>Après-midi / Nuit</span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Results -->
        <div class="kopv-results-list">
            <?php if(isset($voyages) && is_array($voyages) && count($voyages) > 0): ?>
                <div class="kopv-results-count">
                    <?= count($voyages) ?> trajet(s) trouvé(s)
                </div>
                <?php foreach($voyages as $voyage): ?>
                    <div class="kopv-trip-card">
                        <div class="kopv-trip-main">
                            <div class="kopv-trip-left">
                                <div class="kopv-trip-company">
                                    <i class="bi bi-bus kopv-company-icon"></i>
                                    <?= esc($voyage['cooperative'] ?? 'Coopérative') ?>
                                </div>
                                <span class="kopv-trip-class-badge kopv-badge-<?= strtolower(esc($voyage['categorie'] ?? 'standard')) ?>">
                                    <?= esc($voyage['categorie'] ?? 'Standard') ?>
                                </span>
                            </div>
                            <div class="kopv-trip-center">
                                <div class="kopv-trip-times">
                                    <div class="kopv-trip-time">
                                        <div class="kopv-trip-time-value"><?= esc($voyage['heure_depart'] ?? '--:--') ?></div>
                                        <div class="kopv-trip-time-label">Départ</div>
                                    </div>
                                    <div class="kopv-trip-duration">
                                        <div class="kopv-duration-line"></div>
                                        <i class="bi bi-arrow-right kopv-trip-arrow"></i>
                                    </div>
                                    <div class="kopv-trip-time">
                                        <div class="kopv-trip-time-value"><?= esc($voyage['heure_arrivee'] ?? '--:--') ?></div>
                                        <div class="kopv-trip-time-label">Arrivée</div>
                                    </div>
                                </div>
                            </div>
                            <div class="kopv-trip-right">
                                <div class="kopv-trip-price">
                                    <?= number_format($voyage['prix'] ?? 0, 0, ',', ' ') ?> Ar
                                </div>
                                <div class="kopv-trip-seats-info">
                                    <i class="bi bi-people kopv-seats-icon"></i>
                                    <?= esc($voyage['places_restantes'] ?? 0) ?> places
                                </div>
                            </div>
                        </div>
                        <div class="kopv-trip-footer">
                            <button type="button" class="kopv-btn kopv-btn-secondary btn-view-details"
                                    data-cooperative="<?= esc($voyage['cooperative'] ?? '') ?>"
                                    data-escales="<?= esc($voyage['escales'] ?? '') ?>"
                                    data-bagages="<?= esc($voyage['bagages'] ?? '') ?>"
                                    data-vehicule="<?= esc($voyage['vehicule'] ?? '') ?>"
                                    data-annulation="<?= esc($voyage['annulation'] ?? '') ?>">
                                <i class="bi bi-info-circle"></i>
                                Détails
                            </button>
                            <a href="<?= base_url('Voyage/seat-map?trip_id=' . esc($voyage['id']) . '&passengers=' . esc($passengers ?? 1)) ?>" class="kopv-btn kopv-btn-primary">
                                <i class="bi bi-check-circle"></i>
                                Sélectionner
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="kopv-empty-state">
                    <div class="kopv-empty-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3 class="kopv-empty-title">Aucun trajet disponible</h3>
                    <p class="kopv-empty-text">
                        Aucun départ n'est programmé pour cette date ou tous les trajets sont complets.
                    </p>
                    <a href="<?= base_url('Voyage/search') ?>" class="kopv-btn kopv-btn-primary">
                        <i class="bi bi-arrow-left"></i>
                        Nouvelle recherche
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal for trip details -->
<div id="tripDetailsModal" class="kopv-modal">
    <div class="kopv-modal-backdrop" onclick="closeModal()"></div>
    <div class="kopv-modal-content">
        <div class="kopv-modal-header">
            <h3 class="kopv-modal-title" id="modalCooperativeName">Détails du trajet</h3>
            <button class="kopv-modal-close" onclick="closeModal()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        
        <div class="kopv-modal-body">
            <div class="kopv-modal-item">
                <div class="kopv-modal-label">
                    <i class="bi bi-car-front"></i>
                    Véhicule
                </div>
                <p class="kopv-modal-text" id="modalVehicule"></p>
            </div>
            <div class="kopv-modal-item">
                <div class="kopv-modal-label">
                    <i class="bi bi-signpost"></i>
                    Itinéraire & escales
                </div>
                <p class="kopv-modal-text" id="modalEscales"></p>
            </div>
            <div class="kopv-modal-item">
                <div class="kopv-modal-label">
                    <i class="bi bi-suitcase"></i>
                    Politique des bagages
                </div>
                <p class="kopv-modal-text" id="modalBagages"></p>
            </div>
            <div class="kopv-modal-item">
                <div class="kopv-modal-label">
                    <i class="bi bi-x-circle"></i>
                    Règles d'annulation
                </div>
                <p class="kopv-modal-text" id="modalAnnulation"></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>