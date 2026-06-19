<div class="container mt-5">
    <div class="row">
        
        <div class="col-md-7 mb-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Sélectionnez vos places sur le plan</h5>
                    <div class="badge bg-danger" id="countdownTimer">Temps restant : 10:00</div>
                </div>
                <div class="card-body bg-light text-center py-4">
                    
                    <div class="d-flex justify-content-center gap-3 mb-4 small">
                        <div><span class="d-inline-block bg-white border rounded" style="width:20px;height:20px;vertical-align:middle;"></span> Libre</div>
                        <div><span class="d-inline-block bg-success rounded" style="width:20px;height:20px;vertical-align:middle;"></span> Choisi</div>
                        <div><span class="d-inline-block bg-secondary rounded" style="width:20px;height:20px;vertical-align:middle;"></span> Occupé</div>
                    </div>

                    <div class="bus-container mx-auto p-3 bg-white border rounded shadow-sm" style="max-width: 280px; border-radius: 20px !important;">
                        <div class="text-muted small mb-3 border-bottom pb-2">📟 Tableau de bord / Chauffeur</div>
                        
                        <div class="d-flex flex-column gap-3" id="seatGrid">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-secondary seat text-xs" data-seat-id="1" style="width:45px;height:45px;">1</button>
                                <button class="btn btn-sm btn-outline-secondary seat" data-seat-id="2" style="width:45px;height:45px;">2</button>
                                <div style="width:45px;"></div> <button class="btn btn-sm btn-secondary text-white seat locked" disabled style="width:45px;height:45px;">3</button>
                                <button class="btn btn-sm btn-outline-secondary seat" data-seat-id="4" style="width:45px;height:45px;">4</button>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-sm btn-outline-secondary seat" data-seat-id="5" style="width:45px;height:45px;">5</button>
                                <button class="btn btn-sm btn-outline-secondary seat" data-seat-id="6" style="width:45px;height:45px;">6</button>
                                <div style="width:45px;"></div>
                                <button class="btn btn-sm btn-outline-secondary seat" data-seat-id="7" style="width:45px;height:45px;">7</button>
                                <button class="btn btn-sm btn-outline-secondary seat" data-seat-id="8" style="width:45px;height:45px;">8</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">Votre Choix</h5>
                    <hr>
                    <p>Places requises : <strong id="reqPassengers"><?= esc($_GET['passengers'] ?? 1) ?></strong></p>
                    <p>Places sélectionnées : <span id="selectedSeatsList" class="badge bg-primary fs-6">-</span></p>
                    
                    <form action="<?= base_url('booking/passenger-info') ?>" method="POST" id="seatConfirmationForm">
                        <input type="hidden" name="trip_id" value="<?= esc($_GET['trip_id'] ?? '') ?>">
                        <input type="hidden" name="chosen_seats" id="inputChosenSeats" value="">
                        
                        <button type="submit" id="btnSubmitSeats" class="btn btn-success btn-lg w-100 mt-4" disabled>
                            Confirmer les places
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
const maxAllowed = parseInt(document.getElementById('reqPassengers').innerText);
let selectedSeats = [];

document.querySelectorAll('.seat:not(.locked)').forEach(seat => {
    seat.addEventListener('click', function() {
        const seatId = this.getAttribute('data-seat-id');

        if (this.classList.contains('btn-success')) {
            // Désélectionner
            this.classList.remove('btn-success');
            this.classList.add('btn-outline-secondary');
            selectedSeats = selectedSeats.filter(id => id !== seatId);
        } else {
            // Sélectionner (Vérifier la limite)
            if (selectedSeats.length >= maxAllowed) {
                alert(`Vous avez déjà sélectionné vos ${maxAllowed} place(s).`);
                return;
            }
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-success');
            selectedSeats.push(seatId);
        }

        // Mettre à jour l'affichage et le formulaire
        document.getElementById('selectedSeatsList').innerText = selectedSeats.length > 0 ? selectedSeats.join(', ') : '-';
        document.getElementById('inputChosenSeats').value = selectedSeats.join(',');
        document.getElementById('btnSubmitSeats').disabled = (selectedSeats.length !== maxAllowed);
        
        // C'EST ICI : Qu'on pourra ajouter le fetch() AJAX vers Spring Boot pour appeler l'API `lockSeat()` !
    });
});

// Minuteur de 10 minutes pour libérer les places en session/DB
let time = 600;
setInterval(() => {
    if(time > 0) {
        time--;
        let min = Math.floor(time / 60);
        let sec = time % 60;
        document.getElementById('countdownTimer').innerText = `Temps restant : ${min}:${sec < 10 ? '0':''}${sec}`;
    } else {
        alert("Le temps de réservation est écoulé ! Les sièges ont été libérés.");
        window.location.reload();
    }
}, 1000);
</script>