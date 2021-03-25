<!-- Public home page content (dashboard) -->
<!-- Home top banner -->
<div id="home-banner" class="position-absolute top-0 start-0 w-100">
    <p id="home-tagline" class="display-6 text-white text-center py-1 py-md-4 py-lg-5 px-1"><?= filter_var($GLOBALS['my_tagline'], FILTER_SANITIZE_STRING) ?></p>
    <p class="photo-copyright position-absolute end-0 bottom-0 text-light bg-dark bg-gradient m-0 px-1 py-1 text-end">&copy Photo de <a class="link-light" href="https://www.pexels.com/fr-fr/@jplenio" target="_blank">Johannes Plenio</a></p>
    <p id="home-avatar" class="position-absolute top-100 start-50 translate-middle text-center">
        <img src="files/<?= filter_var($GLOBALS['my_avatar_filename'], FILTER_SANITIZE_STRING) ?>" alt="<?= filter_var($GLOBALS['my_name'], FILTER_SANITIZE_STRING) ?>" class="img-fluid rounded-circle img-thumbnail">
        <span class="position-absolute top-100 start-50 translate-middle text-secondary rounded mt-1 w-100"><?= filter_var($GLOBALS['my_name'], FILTER_SANITIZE_STRING) ?></span>
    </p>
</div>
<!-- /Home top banner -->
<div id="home-content">
    <div id="my-links" class="row d-flex align-items-stretch">
        <p class="col-12 col-md-4 text-center">
            <a href="files/<?= filter_var($GLOBALS['my_cv_filename'], FILTER_SANITIZE_STRING) ?>" style="color:#7952b3;border-color:#7952b3;" title="CV <?= filter_var($GLOBALS['my_name'], FILTER_SANITIZE_STRING) ?>" class="btn fs-6 text-nowrap"><i class="fas fa-download display-4 align-middle"></i> Mon CV en PDF</a>
        </p>
        <p class="col-12 col-md-4 text-center">
            <a href="<?= filter_var($GLOBALS['my_linkedin_link'], FILTER_SANITIZE_URL); ?>" style="color:#0a66c2;border-color:#0a66c2;" title="Retrouvez-moi sur LinkedIn" class="btn fs-6 text-nowrap"><i class="fab fa-linkedin-in display-4 align-middle"></i> Mon profil LinkedIn</a>
        </p>
        <p class="col-12 col-md-4 text-center">
            <a href="<?= filter_var($GLOBALS['my_github_link'], FILTER_SANITIZE_URL); ?>" title="Retrouvez-moi sur GitHub" style="color:#24292e;border-color:#24292e;" class="btn fs-6 text-nowrap"><i class="fab fa-github-alt display-4 align-middle"></i> Mon compte GitHub</a>
        </p>
    </div>
</div>
