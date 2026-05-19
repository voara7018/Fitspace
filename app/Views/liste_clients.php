<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitSpace — Liste des Clients</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
  <link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<section id="page-admin-clients">
  <div class="app-wrapper">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <div class="sidebar-section">Gestion</div>
      <ul class="sidebar-nav">
        <li><a href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li><a href="<?= site_url('admin/ajouter-creneau') ?>"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="<?= site_url('admin/liste-clients') ?>" class="active"><i class="bi bi-people-fill"></i> Clients</a></li>
        <li><a href="<?= site_url('admin/chart') ?>"><i class="bi bi-bar-chart-line-fill"></i> Statistiques</a></li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar" style="background:#0f3460;">AD</div>
          <div class="user-info"><div class="name">Admin</div><div class="role">Administrateur</div></div>
          <a href="<?= site_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <!-- CONTENT -->
    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Gestion des clients</span>
      </div>

      <div class="page-content">
        <!-- Liste des clients -->
        <div class="data-card">
          <div class="data-card-header">
            <h3>Tous les clients</h3>
            <span style="font-size:0.8rem;color:var(--muted);"><?= count($clients) ?> client(s)</span>
          </div>
          <table class="table-custom">
            <thead>
              <tr>
                <th>Nom</th>
                <th>Adresse Email</th>
                <th>Rôle</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($clients)): ?>
                <?php foreach ($clients as $client): ?>
                  <tr>
                    <td class="td-name">
                      <div style="display:flex;align-items:center;gap:8px;">
                        <div class="avatar" style="width:28px;height:28px;font-size:0.65rem;background:var(--accent);">
                          <?= esc(strtoupper(substr($client['nom'], 0, 2))) ?>
                        </div>
                        <span><?= esc($client['nom']) ?></span>
                      </div>
                    </td>
                    <td class="td-muted"><?= esc($client['email']) ?></td>
                    <td>
                      <span class="badge-statut s-confirmee" style="font-size:0.68rem;background:rgba(0,245,212,0.1);color:var(--accent);">Client</span>
                    </td>
                    <td>
                      <div class="action-btns">
                        <button class="btn-sm-custom btn-confirm" title="Contacter"><i class="bi bi-envelope"></i></button>
                        <button class="btn-sm-custom btn-del" title="Supprimer"><i class="bi bi-trash"></i></button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" style="text-align: center; color: var(--muted); padding: 20px;">Aucun client enregistré.</td>
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
