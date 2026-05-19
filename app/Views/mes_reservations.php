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

<section id="page-mes-reservations">
  <div class="app-wrapper">
    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span></div>
      <ul class="sidebar-nav" style="margin-top:1rem;">
        <li><a href="<?= site_url('dashboard') ?>"><i class="bi bi-grid-1x2-fill"></i> Tableau de bord</a></li>
        <li><a href="<?= site_url('creneaux-disponibles') ?>"><i class="bi bi-calendar3"></i> Voir les créneaux</a></li>
        <li>
          <a href="<?= site_url('mes-reservations') ?>" class="active">
            <i class="bi bi-bookmark-check-fill"></i> Mes réservations
            <?php if (isset($pendingCount) && $pendingCount > 0): ?>
              <span class="sidebar-badge urgent"><?= $pendingCount ?></span>
            <?php endif; ?>
          </a>
        </li>
      </ul>
      <div class="sidebar-footer">
        <div class="sidebar-user">
          <div class="avatar"><?= esc(substr(session()->get('nom') ?? 'JD', 0, 2)) ?></div>
          <div class="user-info">
            <div class="name"><?= esc(session()->get('nom')) ?></div>
            <div class="role">Client</div>
          </div>
          <a href="<?= site_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,0.3);font-size:1.1rem;" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
        </div>
      </div>
    </aside>

    <div class="main-content">
        <div class="topbar">
            <span class="topbar-title">Calendrier de mes réservations</span>
        </div>

        <div class="page-content">
            <div class="data-card">
                <div class="data-card-header">
                    <h3>Calendrier</h3>
                </div>

                <div id="calendar"></div>
            </div>
        </div>
    </div>
  </div>
</section>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
   <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js" defer></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'fr',

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        events: [
            <?php foreach ($reservations as $reservation): ?>
            {
                title: "<?= esc($reservation['ressource_nom']) ?> - <?= esc($reservation['statut']) ?>",
                start: "<?= esc($reservation['date_debut']) ?>",
                end: "<?= esc($reservation['date_fin']) ?>"
            },
            <?php endforeach; ?>
        ]
    });

    calendar.render();
});
</script>
</body>
</html>