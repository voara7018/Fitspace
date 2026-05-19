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

    <!-- SIDEBAR -->
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

    <!-- MAIN CONTENT -->
    <div class="main-content">
      <div class="topbar">
        <span class="topbar-title">Statistiques & Analyses</span>
      </div>

      <div class="page-content">
        <div class="row g-4">
          
          <!-- CHART 1: RESERVATIONS BY RESOURCE TYPE -->
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

          <!-- CHART 2: RESERVATIONS EVOLUTION (DAILY) -->
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
    // We wait for Chart.js to load in the browser
    const checkChartLoaded = setInterval(() => {
        if (typeof Chart !== 'undefined') {
            clearInterval(checkChartLoaded);
            initializeCharts();
        }
    }, 50);

    function initializeCharts() {
        // Resource Distribution Chart (Doughnut)
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
                            'rgba(255, 74, 90, 0.85)',   // Accent Red-orange
                            'rgba(0, 242, 254, 0.85)',   // Neon cyan
                            'rgba(57, 255, 20, 0.85)',   // Lime green
                            'rgba(155, 89, 182, 0.85)',  // Purple
                            'rgba(241, 196, 15, 0.85)'   // Gold yellow
                        ],
                        borderColor: '#16192b',
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
                                color: '#a2a5b9',
                                font: {
                                    family: 'DM Sans',
                                    size: 12
                                },
                                padding: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: '#16192b',
                            titleColor: '#fff',
                            bodyColor: '#a2a5b9',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1
                        }
                    }
                }
            });
        }

        // Daily Bookings Trend Chart (Line Chart)
        const dailyCtx = document.getElementById('dailyChart');
        if (dailyCtx) {
            const rawDailyData = <?= json_encode($reservationsParJour) ?>;
            const dailyLabels = rawDailyData.map(item => {
                const dateParts = item.date.split('-');
                if (dateParts.length === 3) {
                    // Return "DD/MM" format for clean display
                    return `${dateParts[2]}/${dateParts[1]}`;
                }
                return item.date;
            });
            const dailyTotals = rawDailyData.map(item => parseInt(item.total));

            // Create gradient background
            const ctx2d = dailyCtx.getContext('2d');
            const gradient = ctx2d.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(0, 242, 254, 0.4)');
            gradient.addColorStop(1, 'rgba(0, 242, 254, 0.0)');

            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: dailyLabels,
                    datasets: [{
                        label: 'Réservations',
                        data: dailyTotals,
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: '#00f2fe',
                        borderWidth: 3,
                        pointBackgroundColor: '#00f2fe',
                        pointBorderColor: '#16192b',
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
                            backgroundColor: '#16192b',
                            titleColor: '#fff',
                            bodyColor: '#a2a5b9',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'transparent'
                            },
                            ticks: {
                                color: '#a2a5b9',
                                font: {
                                    family: 'DM Sans'
                                }
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)',
                                borderColor: 'transparent'
                            },
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                color: '#a2a5b9',
                                font: {
                                    family: 'DM Sans'
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