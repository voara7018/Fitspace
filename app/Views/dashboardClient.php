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

<section id="page-dashboard-client">
  <div class="app-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span></div>

      <div class="sidebar-section">Menu</div>
      <ul class="sidebar-nav">
        <li><a href="<?= site_url('dashboard') ?>" class="active"><i class="bi bi-grid-1x2-fill"></i> Tableau de bord</a></li>
        <li><a href="<?= site_url('creneaux-disponibles') ?>"><i class="bi bi-calendar3"></i> Voir les créneaux</a></li>
        <li>
          <a href="<?= site_url('mes-reservations') ?>">
            <i class="bi bi-bookmark-check-fill"></i> Mes réservations
            <?php if (isset($enAttenteCount) && $enAttenteCount > 0): ?>
              <span class="sidebar-badge urgent"><?= $enAttenteCount ?></span>
            <?php endif; ?>
          </a>
        </li>
      </ul>

      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar"><?= substr(session()->get('nom'), 0, 2) ?></div>
          <div class="user-info">
            <div class="name"><?= session()->get('nom') ?></div>
            <div class="role">Client</div>
          </div>
          <a href="<?= site_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <!-- CONTENU -->
    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Tableau de bord</span>
      </div>

      <div class="page-content">

        <!-- Flash messages -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="flash-message flash-success">
            <i class="bi bi-check-circle-fill"></i>
            <?= esc(session()->getFlashdata('success')) ?>
          </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="flash-message" style="border-left-color: #ff4a5a; background: rgba(255, 74, 90, 0.05); padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="bi bi-exclamation-circle-fill" style="color: #ff4a5a;"></i>
            <span style="color: #ff4a5a; font-weight: 500;"><?= esc(session()->getFlashdata('error')) ?></span>
          </div>
        <?php endif; ?>

        <!-- Métriques -->
        <div class="metrics-row">
          <div class="metric-card">
            <div class="metric-icon yellow"><i class="bi bi-hourglass-split"></i></div>
            <div class="metric-value"><?= (int)($enAttenteCount ?? 0) ?></div>
            <div class="metric-label">En attente</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div class="metric-value"><?= (int)($confirmeeCount ?? 0) ?></div>
            <div class="metric-label">Confirmées</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon red"><i class="bi bi-x-circle-fill"></i></div>
            <div class="metric-value"><?= (int)($annuleeCount ?? 0) ?></div>
            <div class="metric-label">Annulées</div>
          </div>
          <div class="metric-card">
            <div class="metric-icon blue"><i class="bi bi-calendar-check"></i></div>
            <div class="metric-value"><?= (int)($aVenirCount ?? 0) ?></div>
            <div class="metric-label">À venir</div>
          </div>
        </div>

        <!-- Prochains créneaux réservés -->
        <div class="data-card">
          <div class="data-card-header">
            <h3>Mes prochaines réservations</h3>
            <a href="<?= site_url('mes-reservations') ?>" style="font-size:0.8rem;color:var(--accent);text-decoration:none;">Voir tout →</a>
          </div>
          <table class="table-custom">
            <thead>
              <tr>
                <th>Créneau</th>
                <th>Date</th>
                <th>Horaire</th>
                <th>Statut</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($prochaines)): ?>
                <?php foreach ($prochaines as $p): 
                  $dDeb = new \DateTime($p['date_debut']);
                  $dFin = new \DateTime($p['date_fin']);
                  
                  $fmt = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, 'E d MMMM');
                  $dateFormatted = $fmt->format($dDeb);
                  
                  $typeLower = strtolower($p['ressource_type'] ?? '');
                  if ($typeLower === 'salle') {
                      $typeClass = 'type-salle';
                      $typeLabel = 'Salle';
                  } elseif ($typeLower === 'terrain') {
                      $typeClass = 'type-terrain';
                      $typeLabel = 'Terrain';
                  } else {
                      $typeClass = 'type-cours';
                      $typeLabel = 'Cours';
                  }
                  
                  $statusLower = strtolower($p['statut']);
                  if ($statusLower === 'en_attente') {
                      $statusClass = 's-attente';
                      $statusLabel = 'en attente';
                  } elseif ($statusLower === 'confirmé' || $statusLower === 'confirmee') {
                      $statusClass = 's-confirmee';
                      $statusLabel = 'confirmée';
                  } else {
                      $statusClass = 's-annulee';
                      $statusLabel = 'annulée';
                  }
                ?>
                  <tr>
                    <td class="td-name">
                      <?= esc($p['ressource_nom']) ?>
                      <span class="creneau-type <?= $typeClass ?>" style="font-size:0.65rem;margin-left:5px;"><?= esc($typeLabel) ?></span>
                    </td>
                    <td class="td-muted"><?= esc(ucfirst(str_replace('.', '', $dateFormatted))) ?></td>
                    <td class="td-muted"><?= esc($dDeb->format('H\hi')) ?> – <?= esc($dFin->format('H\hi')) ?></td>
                    <td><span class="badge-statut <?= $statusClass ?>"><?= esc($statusLabel) ?></span></td>
                    <td>
                      <?php if ($statusLower === 'en_attente'): ?>
                        <a href="<?= site_url('annuler-reservation/' . $p['id']) ?>" class="btn-sm-custom btn-cancel" style="text-decoration:none;" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')"><i class="bi bi-x"></i> Annuler</a>
                      <?php else: ?>
                        <span style="font-size:0.75rem;color:var(--muted);">—</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" style="text-align: center; color: var(--muted); padding: 25px;">Aucune réservation enregistrée.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>