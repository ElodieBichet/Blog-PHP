
<div>

    <form action="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>" method="POST">

        <?php require('inc/postFields.html.php'); ?>

        <p>Statut du post : <?= filter_var($post->getStatusLabel(), FILTER_SANITIZE_STRING) ?> 
        <?php if( ($_SESSION['user_role'] == 1) AND ($post->status > 0)) : ?>
        <?php if((int) $post->status != 2) : ?>
        <button type="submit" name="valid" class="btn btn-success btn-sm">Approuver</button>
        <?php endif; ?>
        <?php if((int) $post->status <= 2) : ?>
        <button type="submit" name="reject" class="btn btn-warning btn-sm">Rejeter</button>
        <?php endif; ?>
        <?php endif; ?>
        </p>

        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
        <button type="submit" name="updateAsDraft" class="btn btn-secondary">Mettre à jour comme brouillon</button>
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">Supprimer</button>

        <?php
         $item = 'le post'; $itemId = $post->id;
         require('inc/modal.html.php');
        ?>

        <p>
            <button type="submit" name="manage_comments" class="btn btn-link btn-sm" formaction="index.php?admin&controller=comment&task=showList&postid=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>">Gérer les commentaires de ce post</button>
        </p>
            
    </form>


</div>