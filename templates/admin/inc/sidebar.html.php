    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="pt-3">

        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link fs-5" aria-current="page" href="index.php?admin">
              <i class="fas fa-cog"></i> Tableau de bord
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fas fa-eye"></i> Voir le site
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted fs-6">
          Posts
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=post&task=showList">
              <i class="fas fa-edit"></i> Gérer <?= ($isAdmin) ? 'les' : 'mes' ?> posts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=post&task=add">
            <i class="fas fa-file-medical"></i> Ajouter un post
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted fs-6">
          Commentaires
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=comment&task=showList">
              <i class="fas fa-comment-dots"></i> Gérer les commentaires <?= ($isAdmin) ? '' : 'sur mes posts' ?>
            </a>
          </li>
        </ul>

        <?php if($isAdmin) : ?>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted fs-6">
          Utilisateurs
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=user&task=showList">
              <i class="fas fa-users-cog"></i> Gérer les utilisateurs
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=register">
              <i class="fas fa-user-plus"></i> Ajouter un utilisateur
            </a>
          </li>
        </ul>
        <?php endif; ?>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted fs-6">
          Mon compte
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php?controller=user&task=edit&id=<?= filter_var($sessionTab['user_id'], FILTER_VALIDATE_INT) ?>">
            <i class="fas fa-user-alt"></i> Gérer mon profil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?logout">
              <i class="fas fa-unlock"></i> Déconnexion
            </a>
          </li>
        </ul>

      </div>
    </nav>