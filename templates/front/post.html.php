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

    <div>
        <!-- Comments form -->
        <h2 class="my-3">Déposez un commentaire.</h2>
        <form method="POST" action="index.php?controller=comment&task=submit">
            <input type="hidden" name="post_id" value="<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="author" id="author" placeholder="Pseudo" value="" required>
                <label for="author">Pseudo</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Adresse email" value="">
                <label for="email_address">Adresse email</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Commentaire" name="content" id="content" style="height: 8.5em;" required></textarea>
                <label for="content">Commentaire</label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Soumettre</button>
        </form>

        <!-- Comments list -->
        <h2 class="d-inline-block align-middle my-3">Commentaires</h2> <span class="badge bg-secondary rounded-pill align-middle"><?= filter_var($post->nb_comments, FILTER_VALIDATE_INT) ?></span>
        <?php if ($post->nb_comments > 0) : ?>
        <ul class="list-unstyled">
            <?php foreach ($comments as $comment) : ?>
            <li id="comment-<?= filter_var($comment->id, FILTER_VALIDATE_INT) ?>" class="my-4">
            #<?= filter_var($comment->id, FILTER_VALIDATE_INT) ?>
                <p class="d-inline-block border-bottom border-end border-2 py-2 px-3 mx-2 rounded position-relative bg-light" style="min-width: 6em;">
                    <?= htmlentities($comment->content) ?>
                    <span class="d-block position-absolute top-100" style="width: 0; height: 0; left: 2.4em; border-top: 18px solid #dee2e6; border-right: 15px solid transparent;"></span>
                    <span class="d-block position-absolute top-100" style="width: 0; height: 0; left: 2.4em; border-top: 15px solid #f8f9fa; border-right: 12px solid transparent;"></span>
                </p>
                <p class="small">
                    <span class="fw-bold"><?= htmlentities($comment->author) ?></span><span class="text-muted"> | <?= date('\l\e d/m/Y à H:i', strtotime($comment->creation_date)) ?></span>
                </p>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <p>Pas encore de commentaire pour ce post.</p>
        <?php endif; ?>
        
    </div>

</div>
    
