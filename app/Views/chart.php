<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitSpace — Statistiques</title>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="/assets/css/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
  <link href="/assets/css/style.css" rel="stylesheet" />
  <script src="/assets/js/chart.js" defer></script>
</head>
<body>

<section id="page-dashboard-admin">
  <div class="app-wrapper">

    <aside class="sidebar">
      <div class="sidebar-logo">Fit<span>Space</span> <span style="font-size:0.6rem;background:var(--accent);color:#fff;padding:2px 6px;border-radius:4px;vertical-align:middle;">Admin</span></div>
      <div class="sidebar-section">Gestion</div>
      <ul class="sidebar-nav">
        <li><a href="<?= site_url('admin') ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
        <li><a href="<?= site_url('admin/ajouter-creneau') ?>"><i class="bi bi-calendar-week-fill"></i> Créneaux</a></li>
        <li><a href="<?= site_url('admin/liste-clients') ?>"><i class="bi bi-people-fill"></i> Clients</a></li>
        <li><a href="<?= site_url('admin/chart') ?>" class="active"><i class="bi bi-bar-chart-line-fill"></i> Statistiques</a></li>
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
        <span class="topbar-title">Statistiques & Analyses</span>
      </div>

      <div class="page-content">
        <div class="row g-4">
          
          <div class="col-lg-6 col-12">
            <div class="data-card" style="height: 100%; min-height: 400px; display: flex; flex-direction: column;">
              <div class="data-card-header">
                <h3><i class="bi bi-pie-chart-fill" style="color: var(--accent); margin-right: 8px;"></i>Réservations par Ressource</h3>
              </div>
              <div class="data-card-body" style="flex: 1; display: flex; align-items: center; justify-content: center; position: relative;">
                <?php if (empty($reservationsParRessource)): ?>
                  <div class="text-center text-muted py-5">
                    <i class="bi bi-chat-left-x" style="font-size: 2.5rem; display: block; margin-bottom: 10px; color: var(--muted);"></i>
                    Aucune donnée disponible pour le moment.
                  </div>
                <?php else: ?>
                  <div style="width: 100%; height: 280px; position: relative; margin: auto;">
                    <canvas id="resourceChart"></canvas>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-12">
            <div class="data-card" style="height: 100%; min-height: 400px; display: flex; flex-direction: column;">
              <div class="data-card-header">
                <h3><i class="bi bi-graph-up-arrow" style="color: var(--success); margin-right: 8px;"></i>Activité des 7 derniers jours</h3>
              </div>
              <div class="data-card-body" style="flex: 1; display: flex; align-items: center; justify-content: center; position: relative;">
                <?php if (empty($reservationsParJour)): ?>
                  <div class="text-center text-muted py-5">
                    <i class="bi bi-calendar-x" style="font-size: 2.5rem; display: block; margin-bottom: 10px; color: var(--muted);"></i>
                    Aucune réservation enregistrée sur les 7 derniers jours.
                  </div>
                <?php else: ?>
                  <div style="width: 100%; height: 280px; position: relative; margin: auto;">
                    <canvas id="dailyChart"></canvas>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkChartLoaded = setInterval(() => {
        if (typeof Chart !== 'undefined') {
            clearInterval(checkChartLoaded);
            initializeCharts();
        }
    }, 50);

    function initializeCharts() {
        const resourceCtx = document.getElementById('resourceChart');
        if (resourceCtx) {
            const rawResourceData = <?= json_encode($reservationsParRessource) ?>;
            const labels = rawResourceData.map(item => item.ressource);
            const totals = rawResourceData.map(item => parseInt(item.total));

            new Chart(resourceCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: totals,
                        backgroundColor: [
                            'rgba(233, 69, 96, 0.85)',   // Accent Red-pink
                            'rgba(15, 52, 96, 0.85)',    // Navy Blue
                            'rgba(34, 160, 90, 0.85)',   // Success green
                            'rgba(241, 196, 15, 0.85)',  // Warning yellow
                            'rgba(10, 77, 122, 0.85)'    // Soft Info Blue
                        ],
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#7b7b96',
                                font: {
                                    family: 'DM Sans',
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1a1a2e',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 6,
                            padding: 10
                        }
                    }
                }
            });
        }

        const dailyCtx = document.getElementById('dailyChart');
        if (dailyCtx) {
            const rawDailyData = <?= json_encode($reservationsParJour) ?>;
            const dailyLabels = rawDailyData.map(item => {
                const dateParts = item.date.split('-');
                if (dateParts.length === 3) {
                    return `${dateParts[2]}/${dateParts[1]}`;
                }
                return item.date;
            });
            const dailyTotals = rawDailyData.map(item => parseInt(item.total));

            const ctx2d = dailyCtx.getContext('2d');
            const gradient = ctx2d.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(233, 69, 96, 0.25)');
            gradient.addColorStop(1, 'rgba(233, 69, 96, 0.0)');

            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: dailyLabels,
                    datasets: [{
                        label: 'Réservations',
                        data: dailyTotals,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#e94560',
                        borderWidth: 3,
                        pointBackgroundColor: '#e94560',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1a1a2e',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 6,
                            padding: 10
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#e2e2ea',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#7b7b96',
                                font: {
                                    family: 'DM Sans',
                                    weight: '500'
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: '#e2e2ea',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                color: '#7b7b96',
                                font: {
                                    family: 'DM Sans',
                                    weight: '500'
                                }
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }
});
</script>

</body>
</html>