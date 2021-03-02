<header class="pt-3">
    <nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">My Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav w-100">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=post&task=showList">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if(!$isConnected) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=login">Connexion</a>
                    </li>
                    <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="index.php?admin">Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=$_SERVER['PHP_SELF'] ?>?logout">Déconnexion</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>