<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitSpace — Gestionnaire de réservations</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet" />

</head>
<body>

<section id="page-accueil">

  <!-- NAV -->
  <nav class="nav-public">
    <a href="<?= site_url('/') ?>" class="brand">Fit<span>Space</span></a>
    <div class="nav-links">
      <a href="<?= site_url('creneaux-disponibles') ?>">Nos créneaux</a>
      <a href="#">Tarifs</a>
      <?php if (session()->get('isLoggedIn')): ?>
        <?php if (session()->get('role') === 'admin'): ?>
          <a href="<?= site_url('admin') ?>">Tableau de bord (Admin)</a>
        <?php else: ?>
          <a href="<?= site_url('dashboard') ?>">Tableau de bord</a>
        <?php endif; ?>
        <span style="color: rgba(255,255,255,0.7); font-size: 0.9rem; font-weight: 500;">Bonjour, <?= esc(session()->get('nom')) ?></span>
        <a href="<?= site_url('logout') ?>" class="btn-nav-primary"><i class="bi bi-box-arrow-right"></i> Déconnexion</a>
      <?php else: ?>
        <a href="<?= site_url('/') ?>">Connexion</a>
        <a href="<?= site_url('inscription') ?>" class="btn-nav-primary">S'inscrire</a>
      <?php endif; ?>
    </div>
  </nav>

  <!-- HERO -->
  <div class="hero">
    <div class="hero-eyebrow"><i class="bi bi-lightning-charge-fill"></i> Réservation en ligne</div>
    <h1>Votre espace bien-être,<br><em>réservé en 30 secondes.</em></h1>
    <p>Cours collectifs, salles et terrains disponibles 7j/7. Créez un compte gratuit et réservez votre prochain créneau.</p>
    <div class="hero-ctas">
      <a href="<?= site_url('creneaux-disponibles') ?>" class="btn-hero btn-hero-primary">Voir les créneaux disponibles</a>
    </div>
  </div>

  <!-- STATS -->
  <div class="stats-band">
    <div class="stat-item"><div class="num">12</div><div class="lbl">Créneaux / semaine</div></div>
    <div class="stat-item"><div class="num">3</div><div class="lbl">Types de ressources</div></div>
    <div class="stat-item"><div class="num">48h</div><div class="lbl">Délai d'annulation</div></div>
    <div class="stat-item"><div class="num">100%</div><div class="lbl">Gratuit à l'inscription</div></div>
  </div>

</section>

    <script src="/assets/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
