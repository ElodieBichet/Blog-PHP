
<p>Découvrez les dernières news.</p>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($posts as $post) : ?>
    <div class="col" id="post-<?= $post->id ?>">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title"><?= $post->title ?></h2>
            </div>
            <div class="card-body">
                <p class="card-subtitle mb-2 text-muted">Dernière mise à jour : <?= date('\l\e d/m/Y à H:i', strtotime($post->last_update_date)) ?></p>
                <p class="card-text">
                    <?= $post->intro ?>
                </p>
                <p>
                    <a href="#" class="card-link">Voir plus</a>
                </p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
