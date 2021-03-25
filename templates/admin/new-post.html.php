<div>
    <!-- New post form -->
    <form action="index.php?controller=post&task=add" method="POST">

        <?php require 'inc/post-fields.html.php'; ?>

        <button type="submit" name="save" class="btn btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
        <button type="submit" name="saveAsDraft" class="btn btn-secondary"><i class="fas fa-save"></i> Enregistrer comme brouillon</button>

    </form>
    <!-- /New post form -->
</div>