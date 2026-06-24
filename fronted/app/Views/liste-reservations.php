<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop-V - Gestion des Réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --sidebar-bg: #022C22;       /* Vert Très Sombre */
            --primary-emerald: #065F46;  /* Vert Émeraude (En-têtes, th) */
            --accent-green: #059669;     /* Vert Actif/Boutons */
            --light-green-bg: #E6F4EA;   /* Ligne survolée / Alertes */
            --action-blue: #2563EB;      /* Bleu pour actions financières */
        }

        body {
            background-color: #F9FAFB;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
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
        
        .btn-action-pay { background-color: var(--action-blue); color: white; }
        .btn-action-pay:hover { background-color: #1D4ED8; color: white; }
        
        .table-hover tbody tr:hover {
            background-color: var(--light-green-bg) !important;
        }
        
        .badge-tranche { background-color: #FEF3C7; color: #92400E; font-weight: 600; }
        .badge-paye { background-color: #D1FAE5; color: #065F46; font-weight: 600; }

        /* Style Pagination */
        .page-link { color: var(--primary-emerald); }
        .page-link:hover { color: var(--accent-green); background-color: var(--light-green-bg); }
        .page-item.active .page-link { background-color: var(--primary-emerald); border-color: var(--primary-emerald); }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
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
                <a class="nav-link active" href="#"><i class="fa-solid fa-list-check me-2"></i> Liste Réservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-ticket me-2"></i> Nouvelle Réservation</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa-solid fa-bus me-2"></i> Suivi des Voyages</a>
            </li>
            <li class="nav-item mt-auto mb-4">
                <a class="nav-link logout" href="#"><i class="fa-solid fa-door-open me-2"></i> Déconnexion</a>
            </li>
        </ul>
    </div>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-emerald fw-bold m-0"><i class="fa-solid fa-clipboard-list me-2"></i>Suivi des Réservations</h2>
            <a href="/reservations/catalogue" class="btn btn-emerald px-3 py-2 fw-semibold shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>Nouvelle réservation
            </a>
        </div>

        <!-- ZONE DE FILTRAGE ULTRA-CANALISÉE -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <form class="row g-2 align-items-end" onsubmit="event.preventDefault();">
                    <div class="col-md-2">
                        <label for="numero_billet" class="form-label small fw-bold text-secondary">N° Billet</label>
                        <input type="text" class="form-control form-control-sm" id="numero_billet" placeholder="Ex: 2058">
                    </div>
                    <div class="col-md-2">
                        <label for="date_voyage" class="form-label small fw-bold text-secondary">Date départ</label>
                        <input type="date" class="form-control form-control-sm" id="date_voyage">
                    </div>
                    <div class="col-md-3">
                        <label for="id_trajet" class="form-label small fw-bold text-secondary">Axe / Trajet</label>
                        <select class="form-select form-select-sm" id="id_trajet">
                            <option value="">Tous les trajets</option>
                            <option value="1">Tana - Antsirabe</option>
                            <option value="2">Tana - Toamasina</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="tri_date" class="form-label small fw-bold text-secondary">Chronologie</label>
                        <select class="form-select form-select-sm" id="tri_date">
                            <option value="DESC">Plus récents</option>
                            <option value="ASC">Plus anciens</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-emerald btn-sm w-100" onclick="alert('Simulation : Filtrage AJAX...');">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Filtrer la liste
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- CONTRÔLE DE FLUX (NOMBRE DE LIGNES) -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-2">
                <span class="text-secondary small">Afficher</span>
                <select class="form-select form-select-sm" id="limit" style="width: 80px;">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                </select>
                <span class="text-secondary small">réservations par page</span>
            </div>
            <div class="text-muted small">
                Affichage de 1 à 2 sur 148 lignes trouvées
            </div>
        </div>

        <!-- TABLEAU CANALISÉ -->
        <div class="card shadow-sm border-0 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-emerald text-white">
                        <tr>
                            <th class="ps-4 py-3">N° Billet</th>
                            <th class="py-3">Nom du Client</th>
                            <th class="py-3">Voyage (Date & Heure)</th>
                            <th class="py-3">Statut Paiement</th>
                            <th class="py-3">Reste à Payer</th>
                            <th class="text-center py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ligne 1 -->
                        <tr>
                            <td class="ps-4 fw-bold text-dark">#2058</td>
                            <td>
                                <span class="fw-semibold">Rova Rakoto</span>
                                <br><small class="text-muted"><i class="fa-solid fa-phone me-1 small"></i>034 00 000 00</small>
                            </td>
                            <td>
                                <strong class="text-dark">20/06/2026 à 08:30</strong>
                                <br><small class="text-muted"><i class="fa-solid fa-route me-1 small"></i>Tana - Antsirabe</small>
                            </td>
                            <td>
                                <span class="badge badge-tranche px-3 py-2"><i class="fa-solid fa-clock-half-track me-1"></i> Tranche 1 en cours</span>
                            </td>
                            <td class="fw-bold text-danger">10 000 Ar</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="#" class="btn btn-action-pay btn-sm px-3 fw-semibold shadow-sm">
                                        <i class="fa-solid fa-file-invoice-dollar me-1"></i>Payer
                                    </a>
                                    <button class="btn btn-outline-danger btn-sm px-3 fw-semibold" onclick="confirm('Annuler la réservation #2058 ?');">
                                        <i class="fa-solid fa-xmark me-1"></i>Annuler
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Ligne 2 -->
                        <tr>
                            <td class="ps-4 fw-bold text-dark">#2057</td>
                            <td>
                                <span class="fw-semibold">Faly Andriana</span>
                                <br><small class="text-muted"><i class="fa-solid fa-phone me-1 small"></i>032 11 555 99</small>
                            </td>
                            <td>
                                <strong class="text-dark">19/06/2026 à 14:00</strong>
                                <br><small class="text-muted"><i class="fa-solid fa-route me-1 small"></i>Tana - Toamasina</small>
                            </td>
                            <td>
                                <span class="badge badge-paye px-3 py-2"><i class="fa-solid fa-circle-check me-1"></i> Payé en totalité</span>
                            </td>
                            <td class="fw-bold text-success">0 Ar</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-secondary btn-sm px-3 fw-semibold opacity-50" disabled>
                                        <i class="fa-solid fa-check me-1"></i>Réglé
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm px-3 fw-semibold" onclick="confirm('Annuler la réservation #2057 ?');">
                                        <i class="fa-solid fa-xmark me-1"></i>Annuler
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PAGINATION (CHOIX DE LA PAGE À AFFICHER) -->
        <nav aria-label="Navigation des lignes" class="d-flex justify-content-end">
            <ul class="pagination shadow-sm mb-0">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-chevron-left small"></i> Précédent</a>
                </li>
                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Suivant <i class="fa-solid fa-chevron-right small"></i></a>
                </li>
            </ul>
        </nav>

    </div>
</body>
</html>
