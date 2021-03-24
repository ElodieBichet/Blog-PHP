<p>
    <form method="post">
        <button type="submit" class="btn btn-primary" formaction="index.php?controller=post&task=add"><i class="fas fa-file-medical"></i> Créer un nouveau post</button>
    </form>
</p>

<table class="table table-striped table-responsive">
    <thead class="table-light">
        <tr>
            <td>ID</td>
            <td>Titre</td>
            <td>Mise à jour</td>
            <td>Auteur</td>
            <td>Comm.</td>
            <td>Statut</td>
            <?php if($isAdmin) : ?>
            <td>Validation</td>
            <?php endif; ?>
            <td>Modif.</td>
            <td>Suppr.</td>
        </tr>
    </thead>
    <tbody>

    <form method="post">
    <?php foreach ($posts as $post) : ?>
        
        <tr class="status-<?= filter_var($post->status, FILTER_SANITIZE_STRING) ?>">
            <td>#<?= filter_var($post->id, FILTER_VALIDATE_INT) ?></td>
            <td><a href="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>"><?= filter_var($post->title, FILTER_SANITIZE_STRING) ?></a></td>
            <td><?= filter_var($post->last_update_date, FILTER_SANITIZE_STRING) ?></td>
            <td><?= filter_var($post->author, FILTER_VALIDATE_INT) ?> - <?= filter_var($post->getAuthor(), FILTER_SANITIZE_STRING) ?></td>
            <td><a class="btn" href="index.php?admin&controller=comment&task=showList&postid=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-comment-dots"></i></a></td>
            <td><?= filter_var($post->getStatusLabel(), FILTER_SANITIZE_STRING) ?></td>
            <?php if($isAdmin) : ?>
            <td>
                <?php if((int) $post->status != 0) : ?>
                <button <?= ((int) $post->status == 2) ? 'disabled' : '' ?> type="submit" name="valid" class="btn btn-success btn-sm" formaction="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-check"></i></button>
                <button <?= ((int) $post->status == 3) ? 'disabled' : '' ?> type="submit" name="reject" class="btn btn-warning btn-sm" formaction="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-ban"></i></button>
                <?php endif; ?>
            </td>
            <?php endif; ?>
            <td><button type="submit" name="change" class="btn btn-primary" formaction="index.php?controller=post&task=edit&id=<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-pen"></i></button></td>
            <td><button type="button" name="delete" class="btn btn-danger" data-bs-postid="<?= filter_var($post->id, FILTER_VALIDATE_INT) ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
        
    <?php endforeach; ?>
    <?php $item = 'le post'; $itemId = 0; require 'inc/modal.html.php'; ?>
    </form>
    
        <script>
            var myModal = document.getElementById('myModal')
            myModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var postId = button.getAttribute('data-bs-postid')
                // Update the modal's content.
                var postIdSpan = myModal.querySelector('.modal-body > span')
                var confirm = myModal.querySelector('#delete')
                postIdSpan.textContent = postId
                confirm.setAttribute('formaction', 'index.php?controller=post&task=edit&id='+postId)
            })
        </script>

    </tbody>

</table>