<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FitSpace — Oups, une erreur est survenue</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    :root {
      --primary:    #1a1a2e;
      --accent:     #e94560;
      --accent2:    #0f3460;
      --surface:    #f7f7fa;
      --text:       #1a1a2e;
      --muted:      #7b7b96;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--primary);
      color: #fff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
      overflow: hidden;
      position: relative;
    }

    /* Ambient glow backgrounds */
    body::before {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(233, 69, 96, 0.15) 0%, rgba(233, 69, 96, 0) 70%);
      top: -100px;
      left: -100px;
      z-index: 1;
    }
    body::after {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(15, 52, 96, 0.2) 0%, rgba(15, 52, 96, 0) 70%);
      bottom: -150px;
      right: -150px;
      z-index: 1;
    }

    .error-card {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-radius: 24px;
      padding: 3rem 2.5rem;
      width: 100%;
      max-width: 500px;
      text-align: center;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
      z-index: 2;
      animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .error-icon-wrapper {
      width: 80px;
      height: 80px;
      background: rgba(233, 69, 96, 0.1);
      border: 1px solid rgba(233, 69, 96, 0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 2rem;
      box-shadow: 0 0 20px rgba(233, 69, 96, 0.15);
    }

    .error-icon-wrapper i {
      font-size: 2.2rem;
      color: var(--accent);
    }

    .error-logo {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.5rem;
      margin-bottom: 0.5rem;
    }
    .error-logo span { color: var(--accent); }

    h1 {
      font-family: 'Syne', sans-serif;
      font-size: 1.8rem;
      font-weight: 800;
      margin-bottom: 1rem;
      color: #fff;
    }

    p {
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 2.5rem;
    }

    .action-btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--accent);
      color: #fff;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      padding: 12px 28px;
      border-radius: 8px;
      transition: all 0.15s;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(233, 69, 96, 0.3);
    }
    .action-btn:hover {
      background: #c73250;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(233, 69, 96, 0.45);
    }
    .action-btn:active {
      transform: translateY(0);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

  <div class="error-card">
    <div class="error-icon-wrapper">
      <i class="bi bi-exclamation-triangle-fill"></i>
    </div>
    
    <div class="error-logo">Fit<span>Space</span></div>
    
    <h1>Une erreur est survenue</h1>
    
    <p>
      Oups ! Nous avons rencontré un problème inattendu. 
      Notre équipe technique a été automatiquement informée et résout le problème dans les plus brefs délais.
    </p>
    
    <a href="/" class="action-btn">
      <i class="bi bi-house-door-fill"></i>
      Retourner à l'accueil
    </a>
  </div>

</body>
</html>
