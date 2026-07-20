<!-- Barre de navigation KazziPay (corrigée) -->
<nav class="navbar navbar-expand-lg navbar-dark mb-4" style="background: #27ae60; box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3); font-family: 'Nunito', sans-serif; border-radius: 0 0 16px 16px;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/operateur/accueil">
            <img src="https://cdn-icons-png.flaticon.com/512/2331/2331970.png" alt="Logo" width="32" height="32" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
            KazziPay Opérateur
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarOperateur" aria-controls="navbarOperateur" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarOperateur">
            <ul class="navbar-nav me-auto">
                <!-- Barèmes (dropdown) -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="baremesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-sliders"></i> Barèmes
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="baremesDropdown" style="border-radius: 12px; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.1);">
                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="/baremes"><i class="bi bi-list-ul"></i> Liste des barèmes</a></li>
                        <li><a class="dropdown-item d-flex align-items-center gap-2" href="/baremes/ajouter?type=depot"><i class="bi bi-plus-circle"></i> Ajouter un barème</a></li>
                    </ul>
                </li>
                <!-- Préfixes -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="/prefixes">
                        <i class="bi bi-phone"></i> Préfixes
                    </a>
                </li>
                <!-- Situation des gains -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="/baremes/situation">
                        <i class="bi bi-graph-up"></i> Situation des gains
                    </a>
                </li>
                <!-- Situation des clients -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="/clients/situation">
                        <i class="bi bi-people-fill"></i> Situation des clients
                    </a>
                </li>
                <!-- Commission -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="/operateurs/profil">
                        <i class="bi bi-percent"></i> Commission
                    </a>
                </li>
                <!-- Reversements -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-1" href="/baremes/reversements">
                        <i class="bi bi-arrow-repeat"></i> Reversements
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <span class="navbar-text text-white">
                    <i class="bi bi-person-circle me-1"></i>
                    Connecté : <strong><?= esc(session()->get('operateur')['nom'] ?? 'Opérateur') ?></strong>
                </span>
                <a href="/operateur/logout" class="btn btn-outline-light btn-sm rounded-pill px-3" style="border-color: rgba(255,255,255,0.5); transition: all 0.3s;">
                    <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Dépendances (à placer dans le <head> ou en fin de page) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">