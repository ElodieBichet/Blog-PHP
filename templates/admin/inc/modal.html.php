        <!-- Modal -->
        <div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Suppression définitive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Cette action est irréversible. Souhaitez-vous supprimer définitivement <?= filter_var($item, FILTER_SANITIZE_STRING) ?> #<span><?= filter_var($itemId, FILTER_VALIDATE_INT) ?></span> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Annuler</button>
                    <button type="submit" id="delete" name="delete" class="btn btn-danger" formaction="index.php?controller=post&task=edit&id=<?= filter_var($itemId, FILTER_VALIDATE_INT) ?>"><i class="fas fa-trash-alt"></i> Supprimer <?= filter_var($item, FILTER_SANITIZE_STRING) ?></button>
                </div>
                </div>
            </div>
        </div>