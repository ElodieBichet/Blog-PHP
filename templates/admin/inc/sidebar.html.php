    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="pt-3">

        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php?admin">
              Tableau de bord
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              Voir le site
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          Posts
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=post&task=showList">
              Gérer <?= ($isAdmin) ? 'les' : 'mes' ?> posts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=post&task=add">Ajouter un post</a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          Commentaires
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=comment&task=showList">
              Gérer les commentaires <?= ($isAdmin) ? '' : 'sur mes posts' ?>
            </a>
          </li>
        </ul>

        <?php if($isAdmin) : ?>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          Utilisateurs
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=user&task=showList">
              Gérer les utilisateurs
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?register">
              Ajouter un utilisateur
            </a>
          </li>
        </ul>
        <?php endif; ?>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            Mon compte
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=user&task=edit&id=<?= filter_var($sessionTab['user_id'], FILTER_VALIDATE_INT) ?>">
              Gérer mon profil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?logout">
              Déconnexion
            </a>
          </li>
        </ul>

      </div>
    </nav>