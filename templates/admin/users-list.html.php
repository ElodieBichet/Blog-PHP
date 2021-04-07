<!-- Admin users list -->
<table class="table table-striped table-responsive">
    <thead class="table-light">
        <tr>
            <td>ID</td>
            <td>Rôle</td>
            <td>Pseudo</td>
            <td>Soumis le</td>
            <td>Statut</td>
            <td class="validation">Validation</td>
            <td>Modif.</td>
            <td>Suppr.</td>
        </tr>
    </thead>
    <tbody>

    <form method="post">
    <?php foreach ($users as $user) : ?>
        <tr class="status-<?= filter_var($user->status, FILTER_SANITIZE_STRING) ?>">
            <td>#<?= filter_var($user->id, FILTER_VALIDATE_INT) ?></td>
            <td>
                <?= filter_var($user->getRoleLabel(), FILTER_SANITIZE_STRING) ?>
            </td>
            <td><a href="index.php?controller=user&task=edit&id=<?= filter_var($user->id, FILTER_VALIDATE_INT) ?>"><?= filter_var($user->public_name, FILTER_SANITIZE_STRING) ?></a></td>
            <td><?= filter_var($user->creation_date, FILTER_SANITIZE_STRING) ?></td>
            <td>
                <?= filter_var($user->getStatusLabel(), FILTER_SANITIZE_STRING) ?>
            </td>
            <td>
                <button <?php if((int) $user->status == 2) : ?>disabled<?php endif; ?> type="submit" name="valid" class="btn btn-success btn-sm" formaction="index.php?controller=user&task=edit&id=<?= filter_var($user->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-check"></i></button>
                <button <?php if((int) $user->status == 3) : ?>disabled<?php endif; ?> type="submit" name="reject" class="btn btn-warning btn-sm" formaction="index.php?controller=user&task=edit&id=<?= filter_var($user->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-ban"></i></button>
            </td>
            <td>
                <button type="submit" name="change" class="btn btn-primary" formaction="index.php?controller=user&task=edit&id=<?= filter_var($user->id, FILTER_VALIDATE_INT) ?>"><i class="fas fa-pen"></i></button>
            </td>
            <td>
                <button type="button" name="delete" class="btn btn-danger" data-bs-userid="<?= filter_var($user->id, FILTER_VALIDATE_INT) ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        
    <?php endforeach; ?>
    <?php $item = 'l\'utilisateur';  $itemId = 0; require 'inc/modal.html.php'; ?>
    </form>
    
        <!-- Customize modal content according to the clicked line -->
        <script>
            var myModal = document.getElementById('myModal')
            myModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = event.relatedTarget
                // Extract info from data-bs-* attributes
                var userId = button.getAttribute('data-bs-userid')
                // Update the modal's content.
                var userIdSpan = myModal.querySelector('.modal-body > span')
                var confirm = myModal.querySelector('#delete')
                userIdSpan.textContent = userId
                confirm.setAttribute('formaction', 'index.php?controller=user&task=edit&id='+userId)
            })
        </script>

    </tbody>

</table>
<!-- /Admin users list -->