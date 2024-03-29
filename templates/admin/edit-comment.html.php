
<div>

    <!-- Comment edit form -->
    <form action="index.php?controller=comment&task=edit&id=<?= filter_var($comment->id, FILTER_VALIDATE_INT) ?>" method="POST">

        <input type="hidden" name="post_id" value="<?= filter_var($comment->post_id, FILTER_VALIDATE_INT) ?>">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="author" id="author" placeholder="Pseudo" value="<?= filter_var($comment->author, FILTER_SANITIZE_STRING) ?>" required>
            <label for="author">Pseudo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Adresse email" value="<?= filter_var($comment->email_address, FILTER_SANITIZE_EMAIL) ?>">
            <label for="email_address">Adresse email</label>
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Commentaire" name="content" id="content" style="height: 8.5em;" required><?= filter_var($comment->content, FILTER_SANITIZE_STRING) ?></textarea>
            <label for="content">Commentaire</label>
        </div>

        <p>Statut du commentaire : <?= filter_var($comment->getStatusLabel(), FILTER_SANITIZE_STRING) ?> 
        <?php if((int) $comment->status != 2) : ?>
        <button type="submit" name="valid" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approuver</button>
        <?php endif; ?>
        <?php if((int) $comment->status <= 2) : ?>
        <button type="submit" name="reject" class="btn btn-warning btn-sm"><i class="fas fa-ban"></i> Rejeter</button>
        <?php endif; ?>
        </p>

        <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-redo-alt"></i> Mettre à jour</button>
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-trash-alt"></i> Supprimer</button><br>
        <br>
        <button type="submit" name="manage_post" class="btn btn-light btn-sm" formaction="index.php?controller=post&task=show&id=<?= filter_var($comment->post_id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-eye"></i> Voir le post concerné par ce commentaire</button>

        <?php $item = 'le commentaire'; $itemId = $comment->id; require 'inc/modal.html.php'; ?>

        <!-- Customize modal content for comment -->            
        <script>
            var myModal = document.getElementById('myModal')
            myModal.addEventListener('show.bs.modal', function (event) {
                var confirm = myModal.querySelector('#delete')
                confirm.setAttribute('formaction', 'index.php?controller=comment&task=edit&id='+<?= filter_var($itemId, FILTER_VALIDATE_INT) ?>)
            })
        </script>
            
    </form>
    <!-- /Comment edit form -->

</div>