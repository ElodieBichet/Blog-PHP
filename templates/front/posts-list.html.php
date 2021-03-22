
<p>Découvrez les dernières news.</p>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($posts as $post) : ?>
    <div class="col" id="post-<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title"><?= filter_var($post->title, FILTER_SANITIZE_STRING) ?></h2>
            </div>
            <div class="card-body">
                <p class="card-subtitle mb-2 text-muted">Par <?= filter_var($post->getAuthor(), FILTER_SANITIZE_STRING) ?><br>Dernière mise à jour : <?= filter_var(date('\l\e d/m/Y à H:i', strtotime($post->last_update_date)), FILTER_SANITIZE_STRING) ?></p>
                <p class="card-text">
                    <?= filter_var($post->intro) ?>
                </p>
                <p>
                    <a href="index.php?controller=post&task=show&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>" class="card-link stretched-link">Voir plus</a>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
