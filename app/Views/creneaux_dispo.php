<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitSpace — Gestionnaire de réservations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
    <link href="/assets/css/style.css" rel="stylesheet" />

</head>
<body>

<section id="page-creneaux" style="padding-top:1rem;">

  <nav class="nav-public">
    <a href="#" class="brand">Fit<span>Space</span></a>
    <div class="nav-links">
      <a href="/dashboard">Mon espace</a>
      <a href="<?= site_url('logout') ?>"> Déconnexion</a>
    </div>
  </nav>

  <div class="page-section">
    <div class="section-head">
      <h2>Créneaux disponibles</h2>
      <span class="count"><?= $total ?> créneaux trouvés</span>
    </div>

    <!-- Filtres -->
    <div class="filter-bar">
      <button class="filter-pill active">Tous</button>
      <button class="filter-pill"><i class="bi bi-people-fill"></i> Cours collectifs</button>
      <button class="filter-pill"><i class="bi bi-door-open-fill"></i> Salles</button>
      <button class="filter-pill"><i class="bi bi-dribbble"></i> Terrains</button>
    </div>

    <div class="creneaux-grid">
      <?php if (!empty($creneaux)): ?>
        <?php foreach ($creneaux as $creneau): 
            $dateDebut = new \DateTime($creneau['date_debut']);
            $dateFin = new \DateTime($creneau['date_fin']);
            
            // Formater la date 
            $formatter = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, 'E d MMMM');
            $displayDate = ucfirst(str_replace('.', '', $formatter->format($dateDebut)));
            
            $isFull = ((int)$creneau['places_dispo']) <= 0;
            $cardClass = $isFull ? 'creneau-card full' : 'creneau-card';
            
            // Type 
            $type = strtolower($creneau['ressource_type'] ?? 'cours');
            if ($type === 'salle') {
                $typeClass = 'type-salle';
                $typeIcon = 'bi-door-open-fill';
                $typeLabel = 'Salle';
            } elseif ($type === 'terrain') {
                $typeClass = 'type-terrain';
                $typeIcon = 'bi-dribbble';
                $typeLabel = 'Terrain';
            } else {
                $typeClass = 'type-cours';
                $typeIcon = 'bi-people-fill';
                $typeLabel = 'Cours';
            }
            
            $capacity = (int)($creneau['ressource_capacite'] ?? 10);
            $placedispo = (int)($creneau['places_dispo'] ?? 0);
            $capacite = $capacity > 0 ? (($capacity - $placedispo) / $capacity) * 100 : 0;
        ?>
          <div class="<?= $cardClass ?>">
            <div class="creneau-header">
              <span class="creneau-type <?= $typeClass ?>"><i class="bi <?= $typeIcon ?>"></i> <?= esc($typeLabel) ?></span>
              <span style="font-size:0.75rem;color:var(--muted);"><?= esc($displayDate) ?></span>
            </div>
            <p class="creneau-title"><?= esc($creneau['ressource_nom']) ?></p>
            <div class="creneau-meta">
              <div class="meta-row"><i class="bi bi-clock"></i> <?= esc($dateDebut->format('H\hi')) ?> — <?= esc($dateFin->format('H\hi')) ?></div>
              <?php if (!empty($creneau['ressource_description'])): ?>
                <div class="meta-row"><i class="bi bi-geo-alt"></i> <?= esc($creneau['ressource_description']) ?></div>
              <?php endif; ?>
            </div>
            <div>
              <div class="places-bar">
                <div class="places-fill" style="width:<?= $capacite ?>%; <?= $isFull ? 'background:var(--muted)' : '' ?>"></div>
              </div>
              <div class="places-label">
                <?php if ($isFull): ?>
                  Complet — 0 place restante
                <?php elseif ($placedispo === 1): ?>
                  1 place restante sur <?= $capacity ?>
                <?php else: ?>
                  <?= $placedispo ?> places restantes sur <?= $capacity ?>
                <?php endif; ?>
              </div>
            </div>
            <?php if ($isFull): ?>
              <button class="btn-reserver disabled" disabled>Complet</button>
            <?php else: ?>
              <a href="/reserver/<?= $creneau['id'] ?>" class="btn-reserver">Réserver ce créneau</a>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-12 text-center text-muted" style="grid-column: 1 / -1; padding: 3rem 0;">
          <i class="bi bi-calendar-x" style="font-size: 3rem; display: block; margin-bottom: 1rem; color: var(--muted);"></i>
          Aucun créneau disponible pour le moment.
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="footer-public">FitSpace &copy; 2025 — Projet CodeIgniter 4 · Tous droits <span>réservés</span></div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>