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
    <section id="page-login" style="background:var(--surface);">
  <nav class="nav-public">
    <a href="<?= site_url('/') ?>" class="brand">Fit<span>Space</span></a>
  </nav>
  <div class="auth-wrapper">
    <div class="auth-card">
      <div class="auth-logo">Fit<span>Space</span></div>
      <div class="auth-subtitle">Bienvenue ! Connectez-vous à votre espace.</div>

      <?php if (session()->getFlashdata('error')): ?>
      <div class="flash-message flash-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
      <div class="flash-message flash-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
      <?php endif; ?>

      <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-group mb-3">
          <label class="form-label">Adresse email</label>
          <input type="email" name="email" class="form-control" placeholder="votre@email.com" value="<?= old('email') ?>" required />
          <div class="text-danger small mt-1"><?= isset($validation['email']) ? esc($validation['email']) : '' ?></div>
        </div>
        <div class="form-group mb-4">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" placeholder="••••••••" required />
          <div class="text-danger small mt-1"><?= isset($validation['password']) ? esc($validation['password']) : '' ?></div>
        </div>
        <button type="submit" class="btn-primary-custom">Se connecter</button>
      </form>

      <hr class="auth-divider" />
      <div class="auth-footer">Pas encore de compte ? <a href="<?= site_url('inscription') ?>">Créer un compte</a></div>
    </div>
  </div>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>