
<div>

    <form action="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>" method="POST">

        <?php require('inc/postFields.html.php'); ?>

        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
        <button type="submit" name="updateAsDraft" class="btn btn-secondary">Mettre à jour comme brouillon</button>
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">Supprimer</button>

        <?php require('inc/modal.html.php'); ?>

    </form>

</div>