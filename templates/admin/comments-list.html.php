<table class="table table-striped table-responsive">
    <thead class="table-light">
        <tr>
            <td>ID</td>
            <td>Post</td>
            <td>Pseudo</td>
            <td>Commentaire</td>
            <td>Statut</td>
            <td>Soumis le</td>
            <td>Modif.</td>
            <td>Suppr.</td>
        </tr>
    </thead>
    <tbody>

    <form method="post">
    <?php foreach ($comments as $comment) : ?>
        
        <tr>
            <td>#<?= filter_var($comment->id, FILTER_VALIDATE_INT) ?></td>
            <td>#<?= filter_var($comment->post_id, FILTER_VALIDATE_INT) ?></td>
            <td><?= filter_var($comment->author, FILTER_SANITIZE_STRING) ?></td>
            <td><?= filter_var($comment->content, FILTER_SANITIZE_STRING) ?></td>
            <td><?= filter_var($comment->status, FILTER_VALIDATE_INT) ?></td>
            <td><?= $comment->creation_date ?></td>
            <td>
                <button disabled type="submit" name="change" class="btn btn-primary" formaction="index.php?controller=post&task=edit&id=<?= filter_var($comment->id, FILTER_VALIDATE_INT) ?>">Modif.</button>
            </td>
            <td>
                <button disabled type="button" name="delete" class="btn btn-danger" data-bs-commentid="<?= filter_var($comment->id, FILTER_VALIDATE_INT) ?>" data-bs-toggle="modal" data-bs-target="#myModal">Suppr.</button>
            </td>
        </tr>
        
    <?php endforeach; ?>
    <?php // require('inc/modal.html.php'); ?>
    </form>
    
        <script>
            var myModal = document.getElementById('myModal')
            myModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var commentId = button.getAttribute('data-bs-commentid')
                // Update the modal's content.
                var commentIdSpan = myModal.querySelector('.modal-body > span')
                var confirm = myModal.querySelector('#delete')
                commentIdSpan.textContent = commentId
                confirm.setAttribute('formaction', 'index.php?controller=post&task=edit&id='+commentId)
            })
        </script>

    </tbody>

</table>