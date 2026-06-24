<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop-V - Catalogue des Voyages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #022C22;       /* Vert Très Sombre */
            --primary-emerald: #065F46;  /* Vert Émeraude (En-têtes, th) */
            --accent-green: #059669;     /* Vert Actif/Boutons */
            --light-green-bg: #E6F4EA;   /* Ligne survolée / Alertes */
        }

        body {
            background-color: #F9FAFB;
            min-height: 100vh;
        }

        /* --- SIDEBAR CUSTOM --- */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }
        .sidebar .brand {
            font-size: 1.25rem;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar .nav-link {
            color: #D1FAE5;
            padding: 12px 20px;
            margin: 4px 0;
            border-left: 4px solid transparent;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: var(--accent-green);
            color: white;
            border-left-color: white;
        }
        .sidebar .nav-link.logout {
            color: #FCA5A5;
        }
        .sidebar .nav-link.logout:hover {
            background-color: #991B1B;
            color: white;
        }

        /* --- ESPACE PRINCIPAL --- */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        .bg-emerald { background-color: var(--primary-emerald) !important; color: white; }
        .text-emerald { color: var(--primary-emerald); }
        .btn-emerald { background-color: var(--accent-green); color: white; }
        .btn-emerald:hover { background-color: var(--primary-emerald); color: white; }
        
        .table-hover tbody tr:hover {
            background-color: var(--light-green-bg) !important;
        }

        /* Style Pagination */
        .page-link { color: var(--primary-emerald); }
        .page-link:hover { color: var(--accent-green); background-color: var(--light-green-bg); }
        .page-item.active .page-link { background-color: var(--primary-emerald); border-color: var(--primary-emerald); }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column p-0">
        <div class="brand p-4 text-white fw-bold d-flex align-items-center">
            <i class="fa-solid fa-van-shuttle me-2 text-white-50" style="font-size: 1.4rem;"></i>
            <span>KOP-V</span>
        </div>
        <div class="px-4 py-2 text-white-50 small bg-black bg-opacity-25">
            <i class="fa-solid fa-user-tie me-2"></i>Guichet Principal
        </div>
        <ul class="nav flex-column mt-3 flex-grow-1">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-list-check me-2"></i> Liste Réservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><i class="fa-solid fa-ticket me-2"></i> Nouvelle Réservation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-bus me-2"></i> Suivi des Voyages</a>
            </li>
            <li class="nav-item mt-auto mb-4">
                <a class="nav-link logout" href="#"><i class="fa-solid fa-door-open me-2"></i> Déconnexion</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-emerald fw-bold m-0"><i class="fa-solid fa-calendar-days me-2"></i>Catalogue des Voyages</h2>
            <span class="badge bg-secondary p-2"><i class="fa-solid fa-clock me-1"></i> Mode Desktop</span>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form id="filterForm" method="post" action="/reservations/catalogue" class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label for="date_debut" class="form-label small fw-bold text-secondary">Date Début</label>
                        <input type="date" name="date_debut" class="form-control form-control-sm" id="date_debut" value="<?= esc($filtres['date_debut'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <label for="date_fin" class="form-label small fw-bold text-secondary">Date Fin</label>
                        <input type="date" name="date_fin" class="form-control form-control-sm" id="date_fin" value="<?= esc($filtres['date_fin'] ?? '') ?>">
                    </div>
                    <!-- Removed filters: nombre_lignes and numero_page per request -->
                    <div class="col-md-2">
                        <label for="tri" class="form-label small fw-bold text-secondary">Chronologie</label>
                        <select name="tri" class="form-select form-select-sm" id="tri">
                            <option value="DESC" <?= empty($filtres['tri']) || $filtres['tri']==='DESC' ? 'selected' : '' ?>>Desc</option>
                            <option value="ASC" <?= isset($filtres['tri']) && $filtres['tri']==='ASC' ? 'selected' : '' ?>>Asc</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-emerald btn-sm">Filtrer</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Afficher</span>
                <select name="nombre_lignes" form="filterForm" class="form-select form-select-sm" id="limit" style="width: 80px;">
                    <option value="5" <?= (int)($meta['size'] ?? $filtres['nombre_lignes'] ?? 10) === 5 ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= (int)($meta['size'] ?? $filtres['nombre_lignes'] ?? 10) === 10 ? 'selected' : '' ?>>10</option>
                    <option value="25" <?= (int)($meta['size'] ?? $filtres['nombre_lignes'] ?? 10) === 25 ? 'selected' : '' ?>>25</option>
                </select>
                <span class="text-secondary small">voyages par page</span>
            </div>
            <div class="text-muted small" id="summary">
                <?php
                    $total = $meta['total'] ?? count($voyages ?? []);
                    $page = $meta['page'] ?? ($filtres['numero_page'] ?? 1);
                    $size = $meta['size'] ?? ($filtres['nombre_lignes'] ?? 10);
                    $start = ($page - 1) * $size + 1;
                    $end = min($start + count($voyages ?? []) - 1, $total);
                    if ($total === 0) {
                        echo 'Aucun départ trouvé';
                    } else {
                        echo "Affichage de {$start} à {$end} sur {$total} départs trouvés";
                    }
                ?>
            </div>
        </div>

        <div class="card shadow-sm border-0 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-emerald text-white">
                        <tr>
                            <th class="ps-4 py-3">Date & Heure départ</th>
                            <th class="py-3">Nom gare départ</th>
                            <th class="py-3">Nom gare arrivée</th>
                            <th class="py-3">Durée estimée</th>
                            <th class="py-3">Distance</th>
                            <th class="py-3">Immatriculation véhicule</th>
                            <th class="py-3">Modèle véhicule</th>
                            <th class="py-3">Catégorie véhicule</th>
                            <th class="py-3">Nb places total</th>
                            <th class="py-3">Nb places réservées</th>
                            <th class="py-3">Nb places disponibles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($voyages)): ?>
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">Aucun voyage prévu trouvé pour ces filtres.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($voyages as $v): ?>
                                <?php
                                    $date = $v['date_depart'] ?? ($v['date'] ?? '');
                                    $heure = $v['heure_depart'] ?? '';
                                    $gareDepart = $v['gare_depart'] ?? ($v['gare_depart_nom'] ?? '');
                                    $gareArrivee = $v['gare_arrivee'] ?? ($v['gare_arrivee_nom'] ?? '');
                                    $duree = $v['duree_estimee'] ?? '';
                                    $distance = $v['distance'] ?? '';
                                    $immatriculation = $v['immatriculation'] ?? ($v['vehicule']['immatriculation'] ?? '');
                                    $modele = $v['modele'] ?? ($v['vehicule']['modele'] ?? '');
                                    $categorie = $v['categorie'] ?? ($v['vehicule']['categorie'] ?? '');
                                    $total = (int) ($v['nb_places_total'] ?? ($v['vehicule']['nb_places'] ?? 0));
                                    $reservees = (int) ($v['nb_places_reservees'] ?? ($v['nb_reserves'] ?? 0));
                                    $disponibles = max(0, $total - $reservees);
                                ?>
                                <tr>
                                    <td><?= esc($date) ?> <?= $heure ? 'à '.esc($heure) : '' ?></td>
                                    <td><?= esc($gareDepart) ?></td>
                                    <td><?= esc($gareArrivee) ?></td>
                                    <td><?= esc($duree) ?></td>
                                    <td><?= esc($distance) ?></td>
                                    <td><?= esc($immatriculation) ?></td>
                                    <td><?= esc($modele) ?></td>
                                    <td><?= esc($categorie) ?></td>
                                    <td><?= esc($total) ?></td>
                                    <td><?= esc($reservees) ?></td>
                                    <td><?= esc($disponibles) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Hidden inputs removed; AJAX will handle requests -->

        <nav aria-label="Navigation catalogue" class="d-flex justify-content-end">
            <ul class="pagination shadow-sm mb-0" id="pagination">
                <?php $total = $meta['total'] ?? count($voyages ?? []); ?>
                <!-- Pagination links will be built by JavaScript -->
                <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-chevron-left small"></i> Précédent</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Suivant <i class="fa-solid fa-chevron-right small"></i></a></li>

        <script>
            (function(){
                    const apiBase = '<?= rtrim(env('API_URL', 'http://localhost:3000/api/'), '/') ?>/voyages/prevus';
                    const form = document.getElementById('filterForm');
                    const dateDebutEl = document.getElementById('date_debut');
                    const dateFinEl = document.getElementById('date_fin');
                    const triEl = document.getElementById('tri');
                    const limitSelect = document.getElementById('limit');
                    const tbody = document.querySelector('table tbody');
                    const summaryEl = document.getElementById('summary');
                    const paginationEl = document.getElementById('pagination');

                    let currentPage = 1;
                    let currentSize = parseInt(limitSelect.value) || 10;

                    function buildQuery(page, size){
                        const params = new URLSearchParams();
                        if(dateDebutEl && dateDebutEl.value) params.set('date_debut', dateDebutEl.value + 'T00:00');
                        if(dateFinEl && dateFinEl.value) params.set('date_fin', dateFinEl.value + 'T23:59');
                        if(triEl && triEl.value) params.set('tri', triEl.value);
                        params.set('numero_page', page);
                        params.set('nombre_lignes', size);
                        return params.toString();
                    }

                    function renderRows(items){
                        if(!items || items.length === 0){
                            tbody.innerHTML = '<tr><td colspan="11" class="text-center text-muted py-4">Aucun voyage prévu trouvé pour ces filtres.</td></tr>';
                            return;
                        }
                        tbody.innerHTML = items.map(v => {
                            const date = v.date_depart || v.date || '';
                            const heure = v.heure_depart || '';
                            const gareDepart = v.gare_depart || v.gare_depart_nom || '';
                            const gareArrivee = v.gare_arrivee || v.gare_arrivee_nom || '';
                            const duree = v.duree_estimee || '';
                            const distance = v.distance || '';
                            const immat = v.immatriculation || (v.vehicule && v.vehicule.immatriculation) || '';
                            const modele = v.modele || (v.vehicule && v.vehicule.modele) || '';
                            const categorie = v.categorie || (v.vehicule && v.vehicule.categorie) || '';
                            const total = v.nb_places_total || (v.vehicule && v.vehicule.nb_places) || 0;
                            const reservees = v.nb_places_reservees || v.nb_reserves || 0;
                            const disponibles = Math.max(0, total - reservees);

                            return `<tr>
                                        <td>${escapeHtml(date)} ${heure ? 'à '+escapeHtml(heure) : ''}</td>
                                        <td>${escapeHtml(gareDepart)}</td>
                                        <td>${escapeHtml(gareArrivee)}</td>
                                        <td>${escapeHtml(duree)}</td>
                                        <td>${escapeHtml(distance)}</td>
                                        <td>${escapeHtml(immat)}</td>
                                        <td>${escapeHtml(modele)}</td>
                                        <td>${escapeHtml(categorie)}</td>
                                        <td>${escapeHtml(total)}</td>
                                        <td>${escapeHtml(reservees)}</td>
                                        <td>${escapeHtml(disponibles)}</td>
                                    </tr>`;
                        }).join('');
                    }

                    function escapeHtml(str){
                        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                    }

                    function renderPagination(meta){
                        const total = meta.total || 0;
                        const page = meta.page || 1;
                        const size = meta.size || currentSize;
                        const totalPages = Math.max(1, Math.ceil(total / size));
                        currentPage = page;
                        currentSize = size;

                        summaryEl.textContent = total === 0 ? 'Aucun départ trouvé' : `Affichage de ${ (page-1)*size + 1 } à ${ Math.min(page*size, total) } sur ${ total } départs trouvés`;

                        let html = '';
                        const prevClass = page <= 1 ? 'disabled' : '';
                        html += `<li class="page-item ${prevClass}"><a class="page-link" href="#" data-page="${Math.max(1, page-1)}"><i class="fa-solid fa-chevron-left small"></i> Précédent</a></li>`;

                        const startPage = Math.max(1, page - 2);
                        const endPage = Math.min(totalPages, page + 2);
                        for(let p = startPage; p <= endPage; p++){
                            const active = p === page ? 'active' : '';
                            html += `<li class="page-item ${active}"><a class="page-link" href="#" data-page="${p}">${p}</a></li>`;
                        }

                        const nextClass = page >= totalPages ? 'disabled' : '';
                        html += `<li class="page-item ${nextClass}"><a class="page-link" href="#" data-page="${Math.min(totalPages, page+1)}">Suivant <i class="fa-solid fa-chevron-right small"></i></a></li>`;

                        paginationEl.innerHTML = html;
                    }

                    async function fetchVoyages(page = 1, size = currentSize){
                        const qs = buildQuery(page, size);
                        try{
                            const res = await fetch(apiBase + '?' + qs, { headers: { 'Accept': 'application/json' } });
                            if(!res.ok) throw new Error('Erreur '+res.status);
                            const body = await res.json();
                            const items = body.data || [];
                            const meta = body.meta || { total: items.length, page: page, size: size };
                            renderRows(items);
                            renderPagination(meta);
                        } catch(err){
                            console.error(err);
                            tbody.innerHTML = '<tr><td colspan="11" class="text-center text-danger py-4">Erreur lors de la récupération des voyages.</td></tr>';
                            summaryEl.textContent = '';
                            paginationEl.innerHTML = '';
                        }
                    }

                    // Interactions
                    form.addEventListener('submit', function(e){
                        e.preventDefault();
                        fetchVoyages(1, parseInt(limitSelect.value) || currentSize);
                    });

                    limitSelect.addEventListener('change', function(){
                        fetchVoyages(1, parseInt(this.value));
                    });

                    paginationEl.addEventListener('click', function(e){
                        const a = e.target.closest('a[data-page]');
                        if(!a) return;
                        e.preventDefault();
                        const p = parseInt(a.getAttribute('data-page')) || 1;
                        fetchVoyages(p, currentSize);
                    });

                    // Initial load: use meta if available, else page 1
                    const initialPage = <?= $meta['page'] ?? ($filtres['numero_page'] ?? 1) ?>;
                    const initialSize = <?= $meta['size'] ?? ($filtres['nombre_lignes'] ?? 10) ?>;
                    // populate limit select to reflect initial size
                    if(limitSelect) limitSelect.value = initialSize;
                    fetchVoyages(initialPage, initialSize);
                })();
            </script>
