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

<section id="page-admin-creneaux">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <div class="sidebar-section">Gestion</div>
      <ul class="sidebar-nav">
        <li><a href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li>
          <a href="<?= site_url('admin#page-admin-reservations') ?>">
            <i class="bi bi-bookmark-star-fill"></i> Réservations
            <span class="sidebar-badge urgent">4</span>
          </a>
        </li>
        <li><a href="<?= site_url('admin/ajouter-creneau') ?>" class="active"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="<?= site_url('admin/liste-clients') ?>"><i class="bi bi-people-fill"></i> Clients</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar" style="background:#0f3460;">AD</div>
          <div class="user-info"><div class="name">Admin</div><div class="role">Administrateur</div></div>
          <a href="<?= site_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Gestion des créneaux</span>
      </div>

      <div class="page-content">

        <?php if (session()->getFlashdata('success')): ?>
          <div class="flash-message flash-info">
            <i class="bi bi-info-circle-fill"></i>
            <?= esc(session()->getFlashdata('success')) ?>
          </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
          <div class="flash-message flash-info" style="border-left-color: #ff4a5a;">
            <i class="bi bi-exclamation-circle-fill" style="color: #ff4a5a;"></i>
            <?= esc(session()->getFlashdata('error')) ?>
          </div>
        <?php endif; ?>

        <div class="form-section">
          <h3><i class="bi bi-plus-circle" style="color:var(--accent);margin-right:6px;"></i>Ajouter un créneau</h3>
          <form action="<?= site_url('admin/ajouter-creneau') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid-2" style="margin-bottom:1rem;">
              <div class="form-group">
                <label class="form-label">Ressource</label>
                <select name="ressources_id" class="select-custom">
                  <?php foreach ($ressources as $ressource){ ?>
                  <option value="<?= $ressource['id'] ?>"><?= esc($ressource['nom']) ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Nombre de places</label>
                <input type="number" name="places_dispo" class="form-control" value="10" min="1" required />
              </div>
              <div class="form-group">
                <label class="form-label">Date et heure de début</label>
                <input type="datetime-local" name="date_debut" class="form-control" value="2025-06-16T08:00" required />
              </div>
              <div class="form-group">
                <label class="form-label">Date et heure de fin</label>
                <input type="datetime-local" name="date_fin" class="form-control" value="2025-06-16T09:30" required />
              </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
              <button type="submit" class="btn-submit"><i class="bi bi-plus"></i> Ajouter le créneau</button>
              <button type="reset" class="btn-secondary-custom">Réinitialiser</button>
            </div>
          </form>
        </div>

        <!-- Liste des créneaux -->
        <div class="data-card">
          <div class="data-card-header">
            <h3>Tous les créneaux</h3>
            <span style="font-size:0.8rem;color:var(--muted);"><?= count($creneaux) ?> créneau(x)</span>
          </div>
          <table class="table-custom">
            <thead>
              <tr><th>Ressource</th><th>Date début</th><th>Date fin</th><th>Places dispo</th><th>Actif</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php if (!empty($creneaux)): ?>
                <?php foreach ($creneaux as $c): 
                  $dDeb = new \DateTime($c['date_debut']);
                  $dFin = new \DateTime($c['date_fin']);
                  
                  $fmt = new \IntlDateFormatter('fr_FR', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, 'd MMMM');
                  $dateFormat = $fmt->format($dDeb);
                  
                  $typeLower = strtolower($c['ressource_type'] ?? '');
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
                ?>
                  <tr>
                    <td class="td-name">
                      <?= esc($c['ressource_nom']) ?>
                      <span class="creneau-type <?= $typeClass ?>" style="font-size:0.65rem;margin-left:5px;"><?= esc($typeLabel) ?></span>
                    </td>
                    <td class="td-muted"><?= esc($dateFormat) ?> · <?= esc($dDeb->format('H\hi')) ?></td>
                    <td class="td-muted"><?= esc($dateFormat) ?> · <?= esc($dFin->format('H\hi')) ?></td>
                    <td><?= esc($c['places_dispo']) ?> / <?= esc($c['ressource_capacite'] ?? 10) ?></td>
                    <td>
                      <?php if ((int)$c['actif'] === 1): ?>
                        <span class="badge-statut s-confirmee" style="font-size:0.68rem;">Oui</span>
                      <?php else: ?>
                        <span class="badge-statut s-attente" style="font-size:0.68rem;">Non</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="action-btns">
                        <button class="btn-sm-custom btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                        <button class="btn-sm-custom btn-del"><i class="bi bi-trash"></i></button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" style="text-align: center; color: var(--muted); padding: 20px;">Aucun créneau enregistré.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

    <script src="/assets/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
