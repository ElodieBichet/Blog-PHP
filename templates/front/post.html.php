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
    <!-- Comments list -->
        
    <!-- Comments form -->
        <p>
            Déposez un commentaire.
        </p>
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
    </div>

</div>
    
