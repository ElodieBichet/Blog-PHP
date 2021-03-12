
<div>

    <form action="index.php?controller=user&task=edit&id=<?= filter_var($user->id, FILTER_VALIDATE_INT) ?>" method="POST">

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Prénom" value="<?= filter_var($user->first_name, FILTER_SANITIZE_STRING) ?>" required>
                    <label for="author">Prénom</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Nom" value="<?= filter_var($user->last_name, FILTER_SANITIZE_STRING) ?>" required>
                    <label for="author">Nom</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="public_name" id="public_name" placeholder="Pseudo public" value="<?= filter_var($user->public_name, FILTER_SANITIZE_STRING) ?>">
                    <label for="public_name">Pseudo public</label>
                    <small class="text-form">Si vide, le prénom et le nom seront utilisés.</small>
                </div>
            </div>
        </div>
        <div class="form-floating mb-3 col-lg-6 col-md-8">
            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Adresse email" value="<?= filter_var($user->email_address, FILTER_SANITIZE_EMAIL) ?>" required>
            <label for="email_address">Adresse email</label>
        </div>
        <div class="form-floating mb-3 col-lg-6 col-md-8">
            <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
            <label for="password">Mot de passe</label>
            <small class="text-form">Laissez vide pour ne pas modifier le mot de passe.</small>
        </div>

        <p>Statut de l'utilisateur : <?= filter_var($user->getStatusLabel(), FILTER_SANITIZE_STRING) ?> 
        <?php if((int) $user->status != 2) : ?>
        <button type="submit" name="valid" class="btn btn-success btn-sm">Approuver</button>
        <?php endif; ?>
        <?php if((int) $user->status <= 2) : ?>
        <button type="submit" name="reject" class="btn btn-warning btn-sm">Rejeter</button>
        <?php endif; ?>
        </p>

        <button type="submit" name="update" class="btn btn-primary">Mettre à jour</button>
        <button type="button" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal">Supprimer</button>

        <?php
         $item = 'l\'utilisateur'; $itemId = $user->id;
         require('inc/modal.html.php');
        ?>

        <script>
            var myModal = document.getElementById('myModal')
            myModal.addEventListener('show.bs.modal', function (event) {
                var confirm = myModal.querySelector('#delete')
                confirm.setAttribute('formaction', 'index.php?controller=user&task=edit&id='+<?= filter_var($itemId, FILTER_VALIDATE_INT) ?>)
            })
        </script>
            
    </form>


</div>