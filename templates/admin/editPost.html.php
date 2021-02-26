
<div>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=post&task=edit&id=<?= $post->id ?>" method="POST">

        <?php require('inc/postFields.html.php'); ?>

        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
        <button type="submit" name="updateAsDraft" class="btn btn-secondary">Mettre à jour comme brouillon</button>

    </form>
</div>