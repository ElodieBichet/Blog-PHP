
<p>Liste des posts en front.</p>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php foreach ($posts as $post) : ?>
    <div class="col">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title"><?= $post->title ?></h2>
            </div>
            <div class="card-body">
                <p class="card-subtitle mb-2 text-muted">Dernière mise à jour : <?= $post->last_update_date ?></hp>
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
