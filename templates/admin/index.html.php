
<!-- Admin home page content (dashboard) -->
<div class="text-center">

    <p class="display-4">Bienvenue <?= filter_var($sessionTab['user_name'], FILTER_SANITIZE_STRING) ?> !</p>

    <p class="h4 my-5">Que souhaitez-vous faire ?</p>

    <p class="row justify-content-evenly">
        <a class="col-12 col-md-3 btn btn-light border m-2" href="index.php?controller=post&task=add"><i class="fa fa-file-medical"></i> Créer un post</a>
        <a class="col-12 col-md-3 btn btn-light border m-2" href="index.php?controller=comment&task=showList"><i class="fa fa-comment-dots"></i> Gérer les commentaires</a>
        <a class="col-12 col-md-3 btn btn-light border m-2" href="index.php?controller=user&task=edit&id=<?= filter_var($sessionTab['user_id'], FILTER_VALIDATE_INT) ?>"><i class="fa fa-user-alt"></i> Modifier mon profil</a>
    </p>

</div>
