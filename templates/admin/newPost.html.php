
<div>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=post&task=add" method="POST">

        <?php require('inc/postFields.html.php'); ?>

        <button type="submit" name="save" class="btn btn-primary">Enregistrer</button>
        <button type="submit" name="saveAsDraft" class="btn btn-secondary">Enregistrer comme brouillon</button>

    </form>
</div>