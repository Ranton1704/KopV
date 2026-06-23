<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="kopv-search-page">
    <div class="kopv-search-header">
        <div class="kopv-search-eyebrow">Réservation · KOP-V Madagascar</div>
        <h1 class="kopv-search-title">
            Où souhaitez-vous<br>
            <em class="kopv-search-title-em">voyager aujourd'hui ?</em>
        </h1>
        <p class="kopv-search-subtitle">
            Choisissez votre itinéraire et trouvez un voyage fiable, à l'heure et confortable sur le réseau KOP-V.
        </p>
    </div>

    <div class="kopv-search-layout">
        <!-- Search Form -->
        <div class="kopv-search-main">
            <div class="kopv-card kopv-search-card">
                <form action="<?= base_url('Voyage/results') ?>" method="GET" id="searchForm">
                    <div class="kopv-search-fields">
                        <!-- Départ -->
                        <div class="kopv-search-field">
                            <label class="kopv-search-label" for="departure">
                                <i class="bi bi-geo-alt"></i>
                                Ville de départ
                            </label>
                            <div class="kopv-search-select-wrap">
                                <select name="departure" id="departure" class="kopv-search-select" required>
                                    <?php if(isset($gares) && is_array($gares)): ?>
                                        <?php foreach($gares as $gare): ?>
                                            <option value="<?= esc($gare['ville']) ?>" <?= $gare['ville'] === 'Antananarivo' ? 'selected' : '' ?>><?= esc($gare['ville']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="Antananarivo" selected>Antananarivo</option>
                                        <option value="Antsirabe">Antsirabe</option>
                                        <option value="Toamasina">Toamasina</option>
                                        <option value="Fianarantsoa">Fianarantsoa</option>
                                        <option value="Mahajanga">Mahajanga</option>
                                    <?php endif; ?>
                                </select>
                                <i class="bi bi-chevron-down kopv-search-chevron"></i>
                            </div>
                        </div>

                        <!-- Swap Button -->
                        <div class="kopv-search-swap">
                            <button type="button" id="btnSwap" class="kopv-swap-btn" title="Inverser">
                                <i class="bi bi-arrow-left-right"></i>
                            </button>
                        </div>

                        <!-- Arrivée -->
                        <div class="kopv-search-field">
                            <label class="kopv-search-label" for="arrival">
                                <i class="bi bi-geo-alt-fill"></i>
                                Ville d'arrivée
                            </label>
                            <div class="kopv-search-select-wrap">
                                <select name="arrival" id="arrival" class="kopv-search-select" required>
                                    <?php if(isset($gares) && is_array($gares)): ?>
                                        <?php foreach($gares as $gare): ?>
                                            <option value="<?= esc($gare['ville']) ?>" <?= $gare['ville'] === 'Antsirabe' ? 'selected' : '' ?>><?= esc($gare['ville']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="Antananarivo">Antananarivo</option>
                                        <option value="Antsirabe" selected>Antsirabe</option>
                                        <option value="Toamasina">Toamasina</option>
                                        <option value="Fianarantsoa">Fianarantsoa</option>
                                        <option value="Mahajanga">Mahajanga</option>
                                    <?php endif; ?>
                                </select>
                                <i class="bi bi-chevron-down kopv-search-chevron"></i>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="kopv-search-field">
                            <label class="kopv-search-label" for="travel_date">
                                <i class="bi bi-calendar"></i>
                                Date de départ
                            </label>
                            <input type="date" name="travel_date" id="travel_date"
                                   class="kopv-search-input"
                                   min="<?= date('Y-m-d') ?>"
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <!-- Passagers -->
                        <div class="kopv-search-field kopv-search-field-sm">
                            <label class="kopv-search-label" for="passengers">
                                <i class="bi bi-people"></i>
                                Passagers
                            </label>
                            <div class="kopv-search-counter">
                                <button type="button" id="decBtn" class="kopv-counter-btn">−</button>
                                <input type="number" name="passengers" id="passengers"
                                       class="kopv-counter-input" min="1" max="10" value="1" readonly required>
                                <button type="button" id="incBtn" class="kopv-counter-btn">+</button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="kopv-btn kopv-btn-primary kopv-btn-full">
                        <i class="bi bi-search"></i>
                        Rechercher un voyage
                    </button>
                </form>
            </div>

            <!-- Popular Routes -->
            <div class="kopv-popular-section">
                <h3 class="kopv-popular-title">Trajets populaires</h3>
                <div class="kopv-routes-grid">
                    <?php
                    $routes = [
                        ['from'=>'Antananarivo','to'=>'Antsirabe','price'=>'25 000 Ar'],
                        ['from'=>'Antananarivo','to'=>'Toamasina','price'=>'45 000 Ar'],
                        ['from'=>'Antananarivo','to'=>'Fianarantsoa','price'=>'38 000 Ar'],
                    ];
                    foreach($routes as $r):
                    ?>
                    <a href="<?= base_url('Voyage/results?departure='.urlencode($r['from']).'&arrival='.urlencode($r['to']).'&travel_date='.date('Y-m-d').'&passengers=1') ?>"
                       class="kopv-route-card">
                        <span class="kopv-route-cities">
                            <?= esc($r['from']) ?>
                            <i class="bi bi-arrow-right"></i>
                            <?= esc($r['to']) ?>
                        </span>
                        <span class="kopv-route-price">à partir de <?= $r['price'] ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Features -->
            <div class="kopv-features-grid">
                <div class="kopv-feature">
                    <div class="kopv-feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4 class="kopv-feature-title">Place garantie</h4>
                        <p class="kopv-feature-text">Votre siège réservé est sécurisé jusqu'à l'embarquement.</p>
                    </div>
                </div>
                <div class="kopv-feature">
                    <div class="kopv-feature-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div>
                        <h4 class="kopv-feature-title">Départs à l'heure</h4>
                        <p class="kopv-feature-text">Discipline d'exploitation et ponctualité sur toutes nos lignes.</p>
                    </div>
                </div>
                <div class="kopv-feature">
                    <div class="kopv-feature-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div>
                        <h4 class="kopv-feature-title">Service moderne</h4>
                        <p class="kopv-feature-text">Réservation mobile, billets digitaux, suivi en temps réel.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="kopv-search-sidebar">
            <div class="kopv-card kopv-recap-card">
                <div class="kopv-recap-header">
                    <div class="kopv-recap-eyebrow">Récapitulatif</div>
                    <h3 class="kopv-recap-title">Votre voyage</h3>
                </div>
                <div class="kopv-recap-body">
                    <div class="kopv-recap-row">
                        <i class="bi bi-geo-alt kopv-recap-icon"></i>
                        <div>
                            <div class="kopv-recap-label">Trajet</div>
                            <div class="kopv-recap-value" id="recap-route">— → —</div>
                        </div>
                    </div>
                    <div class="kopv-recap-row">
                        <i class="bi bi-calendar kopv-recap-icon"></i>
                        <div>
                            <div class="kopv-recap-label">Date</div>
                            <div class="kopv-recap-value" id="recap-date"><?= strftime('%a. %e %B', time()) ?></div>
                        </div>
                    </div>
                    <div class="kopv-recap-row">
                        <i class="bi bi-people kopv-recap-icon"></i>
                        <div>
                            <div class="kopv-recap-label">Passagers</div>
                            <div class="kopv-recap-value" id="recap-pass">1 personne</div>
                        </div>
                    </div>
                    <div class="kopv-recap-hint">Sélectionnez un voyage pour voir le détail et le prix total.</div>
                </div>
                <div class="kopv-recap-footer">
                    Place garantie · Paiement sécurisé · Annulation possible jusqu'à 24h avant départ.
                </div>
            </div>
        </aside>
    </div>
</div>

<script src="<?= base_url('assets/js/search-form.js') ?>"></script>
<?= $this->endSection() ?>