
<div>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=post&task=edit&id=<?= $post->id ?>" method="POST">

        <?php require('inc/postFields.html.php'); ?>

        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
        <button type="submit" name="updateAsDraft" class="btn btn-secondary">Mettre à jour comme brouillon</button>
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">Supprimer</button>

        <!-- Modal -->
        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Suppression du post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Cette action est irréversible. Souhaitez-vous supprimer définitivement le post <?= $post->id ?> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" name="delete" class="btn btn-primary">Supprimer le post</button>
                </div>
                </div>
            </div>
        </div>

    </form>


</div>