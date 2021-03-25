
<div>

    <!-- Post edit form -->
    <form action="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>" method="POST">

        <?php require 'inc/post-fields.html.php'; ?>

        <p>Statut du post : <?= filter_var($post->getStatusLabel(), FILTER_SANITIZE_STRING) ?> 
        <?php if(($isAdmin) AND ($post->status > 0)) : ?>
        <?php if((int) $post->status != 2) : ?>
        <button type="submit" name="valid" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approuver</button>
        <?php endif; ?>
        <?php if((int) $post->status <= 2) : ?>
        <button type="submit" name="reject" class="btn btn-warning btn-sm"><i class="fas fa-ban"></i> Rejeter</button>
        <?php endif; ?>
        <?php endif; ?>
        </p>

        <button type="submit" name="manage_comments" class="btn btn-light btn-sm" formaction="index.php?admin&controller=comment&task=showList&postid=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-comment-dots"></i> Gérer les commentaires de ce post</button><br>
        <br>
        <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-redo-alt"></i> Mettre à jour</button>
        <button type="submit" name="updateAsDraft" class="btn btn-secondary"><i class="fas fa-redo-alt"></i> Mettre à jour comme brouillon</button>
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-trash-alt"></i> Supprimer</button>

        <?php $item = 'le post'; $itemId = $post->id; require 'inc/modal.html.php'; ?>
            
    </form>
    <!-- /Post edit form -->

</div>