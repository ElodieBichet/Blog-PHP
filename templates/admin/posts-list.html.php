
<table class="table table-striped">
    <thead class="table-light">
        <tr>
            <td>ID</td>
            <td>Titre</td>
            <td>Statut</td>
            <td>Mise à jour</td>
            <td>Auteur</td>
            <td>Modif.</td>
            <td>Suppr.</td>
        </tr>
    </thead>
    <tbody>

    <form method="post">
    <?php foreach ($posts as $post) : ?>
        
        <tr>
            <td>#<?= $post->id ?></td>
            <td><a href="index.php?controller=post&task=edit&id=<?= $post->id ?>"><?= $post->title ?></a></td>
            <td><?= $post->status ?></td>
            <td><?= $post->last_update_date ?></td>
            <td><?= $post->author ?></td>
            <td><button type="submit" name="change" class="btn btn-primary" formaction="index.php?controller=post&task=edit&id=<?= $post->id ?>">Modif.</button></td>
            <td><button type="button" name="delete" class="btn btn-danger" data-bs-postid="<?= $post->id ?>" data-bs-toggle="modal" data-bs-target="#myModal">Suppr.</button></td>
        </tr>
        
    <?php endforeach; ?>
    <?php require('inc/modal.html.php'); ?>
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