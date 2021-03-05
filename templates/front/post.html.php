<div id="post-<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>">
    <div>
        <p class="mb-2 text-muted">Dernière mise à jour : <?= date('\l\e d/m/Y à H:i', strtotime($post->last_update_date)) ?></p>
        <p>
            <?= $post->intro ?>
        </p>
        <p>
            <?= $post->content ?>
        </p>
    </div>
</div>
    
