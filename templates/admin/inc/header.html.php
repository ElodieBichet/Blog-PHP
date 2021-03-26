<!-- Admin top navbar -->
<header class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 m-0 px-3" href="#"><?= filter_var(SITE_NAME, FILTER_SANITIZE_STRING) ?> - Admin</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="w-100"></div>
  <ul class="navbar-nav px-3 d-none d-md-block">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="index.php?logout"><i class="fas fa-power-off"></i> Déconnexion</a>
    </li>
  </ul>
</header>
<!-- /Admin top navbar -->