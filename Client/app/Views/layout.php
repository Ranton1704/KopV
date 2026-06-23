<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) : 'KOP-V - Système de Réservation' ?></title>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- KOP-V Theme CSS -->
    <link href="<?= base_url('assets/css/kopv-theme.css') ?>" rel="stylesheet">
    
</head>
<body>
    <div class="kopv-layout-wrapper">
        <!-- Sidebar Navigation -->
        <aside class="kopv-sidebar">
            <div class="kopv-sidebar-header">
                <a href="<?= base_url() ?>" class="kopv-brand">
                    <!-- KOP-V SVG Logo -->
                    <svg class="kopv-logo" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="36" height="36" rx="8" fill="rgba(34,139,76,0.12)"/>
                        <path d="M8 10 L8 26 M8 18 L16 10 M8 18 L16 26" stroke="#228b4c" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 10 L24 26 L28 10" stroke="#5ec47e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 18 L29 18" stroke="rgba(94,196,126,0.3)" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <div class="kopv-brand-text">
                        <span>KOP</span><span style="color:rgba(94,196,126,0.4); margin:0 2px;">—</span><span class="kopv-v">V</span>
                    </div>
                </a>
            </div>
            
            <nav class="kopv-sidebar-nav">
                <a href="<?= base_url() ?>" class="kopv-sidebar-link">
                    <i class="bi bi-house kopv-sidebar-icon"></i>
                    <span class="kopv-sidebar-text">Accueil</span>
                </a>
                <a href="<?= base_url('Voyage/search') ?>" class="kopv-sidebar-link kopv-sidebar-link-active">
                    <i class="bi bi-search kopv-sidebar-icon"></i>
                    <span class="kopv-sidebar-text">Rechercher un trajet</span>
                </a>
                <a href="#" class="kopv-sidebar-link">
                    <i class="bi bi-clipboard-data kopv-sidebar-icon"></i>
                    <span class="kopv-sidebar-text">Mes réservations</span>
                </a>
                <a href="#" class="kopv-sidebar-link">
                    <i class="bi bi-person kopv-sidebar-icon"></i>
                    <span class="kopv-sidebar-text">Connexion</span>
                </a>
            </nav>
            
            <div class="kopv-sidebar-footer">
                <div class="kopv-sidebar-user">
                    <div class="kopv-sidebar-avatar">?</div>
                    <div class="kopv-sidebar-user-info">
                        <div class="kopv-sidebar-user-name">Visiteur</div>
                        <div class="kopv-sidebar-user-status">Non connecté</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="kopv-main-wrapper">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="kopv-flash-messages">
                    <div class="kopv-alert kopv-alert-error">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="kopv-flash-messages">
                    <div class="kopv-alert kopv-alert-success">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Main Content -->
            <main class="kopv-main">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Footer -->
            <footer class="kopv-footer">
                <div class="kopv-footer-content">
                    <div class="kopv-footer-grid">
                        <div>
                            <div class="kopv-footer-title">KOP-V</div>
                            <p style="color: var(--text-light); font-size: 13px; line-height: 1.6;">
                                Système de réservation de transport en commun à Madagascar
                            </p>
                        </div>
                        <div>
                            <div class="kopv-footer-title">Liens utiles</div>
                            <ul class="kopv-footer-links">
                                <li><a href="#">À propos</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">CGU</a></li>
                            </ul>
                        </div>
                        <div>
                            <div class="kopv-footer-title">Destinations</div>
                            <ul class="kopv-footer-links">
                                <li><a href="#">Antananarivo</a></li>
                                <li><a href="#">Antsirabe</a></li>
                                <li><a href="#">Toamasina</a></li>
                            </ul>
                        </div>
                        <div>
                            <div class="kopv-footer-title">Contact</div>
                            <p style="color: var(--text-light); font-size: 13px; line-height: 1.6;">
                                <i class="bi bi-envelope"></i> contact@kop-v.mg<br>
                                <i class="bi bi-telephone"></i> +261 34 00 000 00
                            </p>
                        </div>
                    </div>
                    <div class="kopv-footer-bottom">
                        &copy; <?= date('Y') ?> KOP-V. Tous droits réservés.
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Search Form JS -->
    <script src="<?= base_url('assets/js/search-form.js') ?>"></script>
    
    <!-- Search Results JS -->
    <script src="<?= base_url('assets/js/search-results.js') ?>"></script>
    
    <!-- Passenger Info JS -->
    <script src="<?= base_url('assets/js/passenger-info.js') ?>"></script>
</body>
</html>
