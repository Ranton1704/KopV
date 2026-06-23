<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="kopv-seat-page">
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
        <div class="kopv-progress-step active">
            <div class="kopv-progress-number">3</div>
            <div class="kopv-progress-label">Sièges</div>
        </div>
        <div class="kopv-progress-step">
            <div class="kopv-progress-number">4</div>
            <div class="kopv-progress-label">Passagers</div>
        </div>
        <div class="kopv-progress-step">
            <div class="kopv-progress-number">5</div>
            <div class="kopv-progress-label">Paiement</div>
        </div>
    </div>

    <div class="kopv-seat-header">
        <div class="kopv-seat-eyebrow">Sélection des places</div>
        <h1 class="kopv-seat-title">
            Choisissez vos <em class="kopv-seat-title-em">sièges</em>
        </h1>
        <p class="kopv-seat-subtitle">
            Sélectionnez <?= esc($passengers ?? 1) ?> place(s) pour continuer votre réservation
        </p>
    </div>

    <div class="kopv-seat-layout">
        <!-- 3D Vehicle View -->
        <div class="kopv-vehicle-3d" data-max-seats="<?= esc($passengers ?? 1) ?>" data-trip-id="<?= esc($trip_id ?? '') ?>">
            <div class="kopv-vehicle-container">
                <!-- Vehicle Body -->
                <div class="kopv-vehicle-body-3d">
                    <!-- Driver Area with 2 seats -->
                    <div class="kopv-driver-area-3d">
                        <div class="kopv-driver-seats-row">
                            <div class="kopv-driver-seat">
                                <i class="bi bi-person-fill kopv-driver-icon"></i>
                            </div>
                            <div class="kopv-driver-label">Chauffeur</div>
                        </div>
                        <div class="kopv-driver-seats-row">
                            <button class="kopv-seat-3d kopv-driver-passenger available" data-seat-id="0" data-seat-number="0">
                                <div class="kopv-seat-back"></div>
                                <div class="kopv-seat-cushion">
                                    <span class="kopv-seat-number">0</span>
                                </div>
                                <div class="kopv-seat-base"></div>
                            </button>
                            <div class="kopv-driver-label">Passager</div>
                        </div>
                        <div class="kopv-driver-seats-row">
                            <button class="kopv-seat-3d kopv-driver-assistant occupied" data-seat-id="-1" data-seat-number="-1" disabled>
                                <div class="kopv-seat-back"></div>
                                <div class="kopv-seat-cushion">
                                    <span class="kopv-seat-number">2°</span>
                                </div>
                                <div class="kopv-seat-base"></div>
                            </button>
                            <div class="kopv-driver-label">2° Chauffeur</div>
                        </div>
                    </div>

                    <!-- Passenger Seats -->
                    <div class="kopv-passenger-section">
                        <?php if(isset($places) && is_array($places)): ?>
                            <?php 
                            $placesPerRow = 4;
                            $totalPlaces = count($places);
                            for($i = 0; $i < $totalPlaces; $i += $placesPerRow): 
                                $rowPlaces = array_slice($places, $i, $placesPerRow);
                            ?>
                                <div class="kopv-seat-row-3d">
                                    <?php foreach($rowPlaces as $index => $place): 
                                        $isLocked = ($place['statut'] ?? 'libre') === 'occupe';
                                        $seatClass = $isLocked ? 'occupied' : 'available';
                                        $isAisle = $index === 1;
                                    ?>
                                        <button class="kopv-seat-3d <?= $seatClass ?>" 
                                                data-seat-id="<?= esc($place['id']) ?>" 
                                                data-seat-number="<?= esc($place['numero']) ?>"
                                                <?= $isLocked ? 'disabled' : '' ?>>
                                            <div class="kopv-seat-back"></div>
                                            <div class="kopv-seat-cushion">
                                                <span class="kopv-seat-number"><?= esc($place['numero']) ?></span>
                                            </div>
                                            <div class="kopv-seat-base"></div>
                                        </button>
                                        <?php if($isAisle): ?>
                                            <div class="kopv-aisle"></div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            <!-- Fallback avec des places statiques -->
                            <?php for($row = 1; $row <= 5; $row++): ?>
                                <div class="kopv-seat-row-3d">
                                    <?php for($col = 1; $col <= 4; $col++): 
                                        $seatNum = ($row - 1) * 4 + $col;
                                        $isOccupied = in_array($seatNum, [3, 19]);
                                        $seatClass = $isOccupied ? 'occupied' : 'available';
                                    ?>
                                        <button class="kopv-seat-3d <?= $seatClass ?>" 
                                                data-seat-id="<?= $seatNum ?>" 
                                                data-seat-number="<?= $seatNum ?>"
                                                <?= $isOccupied ? 'disabled' : '' ?>>
                                            <div class="kopv-seat-back"></div>
                                            <div class="kopv-seat-cushion">
                                                <span class="kopv-seat-number"><?= $seatNum ?></span>
                                            </div>
                                            <div class="kopv-seat-base"></div>
                                        </button>
                                        <?php if($col === 2): ?>
                                            <div class="kopv-aisle"></div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Vehicle Info -->
                <div class="kopv-vehicle-info">
                    <div class="kopv-vehicle-name">
                        <i class="bi bi-bus"></i>
                        SPRINTER #02
                    </div>
                    <div class="kopv-vehicle-timer">
                        <i class="bi bi-clock"></i>
                        <span id="countdownTimer">10:00</span>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="kopv-seat-legend">
                <div class="kopv-legend-item">
                    <div class="kopv-legend-seat available"></div>
                    <span>Disponible</span>
                </div>
                <div class="kopv-legend-item">
                    <div class="kopv-legend-seat selected"></div>
                    <span>Sélectionné</span>
                </div>
                <div class="kopv-legend-item">
                    <div class="kopv-legend-seat occupied"></div>
                    <span>Occupé</span>
                </div>
            </div>
        </div>

        <!-- Selection Summary -->
        <div class="kopv-card kopv-seat-summary">
            <div class="kopv-card-accent"></div>
            <h3 class="kopv-seat-summary-title">Votre sélection</h3>
            
            <div class="kopv-seat-summary-info">
                <div class="kopv-seat-summary-row">
                    <span>Places requises</span>
                    <span class="kopv-seat-summary-value" id="reqPassengers">
                        <?= esc($passengers ?? 1) ?>
                    </span>
                </div>
                <div class="kopv-seat-summary-row">
                    <span>Places sélectionnées</span>
                    <span class="kopv-badge" id="selectedSeatsList">-</span>
                </div>
            </div>

            <form action="<?= base_url('Voyage/passenger-info') ?>" method="POST" id="seatConfirmationForm">
                <input type="hidden" name="trip_id" value="<?= esc($trip_id ?? '') ?>">
                <input type="hidden" name="chosen_seats" id="inputChosenSeats" value="">
                
                <button type="submit" id="btnSubmitSeats" class="kopv-btn kopv-btn-primary kopv-btn-full" disabled>
                    <i class="bi bi-check-circle"></i>
                    Confirmer les places
                </button>
            </form>

            <div class="kopv-seat-warning">
                <i class="bi bi-exclamation-triangle"></i>
                <span>Vous avez 10 minutes pour compléter votre réservation. Les sièges sélectionnés seront automatiquement libérés après ce délai.</span>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/seat-map.js') ?>"></script>
<?= $this->endSection() ?>