<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Rechercher un trajet (KOP-V)</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('search/results') ?>" method="GET" id="searchForm">
                <div class="row g-3 align-items-end">
                    
                    <div class="col-md-3 position-relative">
                        <label for="departure" class="form-label font-weight-bold">Départ</label>
                        <select name="departure" id="departure" class="form-select" required>
                            <option value="">Sélectionnez une ville...</option>
                            <option value="Antananarivo">Antananarivo</option>
                            <option value="Antsirabe">Antsirabe</option>
                            <option value="Toamasina">Toamasina</option>
                        </select>
                    </div>

                    <div class="col-md-1 text-center mb-1">
                        <button type="button" id="btnSwap" class="btn btn-outline-secondary rounded-circle" title="Inverser les villes">
                            🔄
                        </button>
                    </div>

                    <div class="col-md-3">
                        <label for="arrival" class="form-label font-weight-bold">Arrivée</label>
                        <select name="arrival" id="arrival" class="form-select" required>
                            <option value="">Sélectionnez une ville...</option>
                            <option value="Antsirabe">Antsirabe</option>
                            <option value="Antananarivo">Antananarivo</option>
                            <option value="Toamasina">Toamasina</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="travel_date" class="form-label font-weight-bold">Date de départ</label>
                        <input type="date" name="travel_date" id="travel_date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="col-md-2">
                        <label for="passengers" class="form-label font-weight-bold">Passagers</label>
                        <input type="number" name="passengers" id="passengers" class="form-control" min="1" max="10" value="1" required>
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Trouver un Taxi-Brousse</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('btnSwap').addEventListener('click', function() {
    const departure = document.getElementById('departure');
    const arrival = document.getElementById('arrival');
    const temp = departure.value;
    departure.value = arrival.value;
    arrival.value = temp;
});
</script>