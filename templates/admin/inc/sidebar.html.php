    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php?admin">
              Tableau de bord
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?admin&controller=post&task=showList">
              Posts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              Commentaires
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              Utilisateurs
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            Autres section
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              Voir le site
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              Mon compte
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?=$_SERVER['PHP_SELF'] ?>?logout">
              Déconnexion
            </a>
          </li>
        </ul>
      </div>
    </nav>