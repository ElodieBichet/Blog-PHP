
<div class="text-center">

    <p class="display-4">Bienvenue <?= filter_var($sessionTab['user_name'], FILTER_SANITIZE_STRING) ?> !</p>

    <p class="lead">Par quoi souhaitez-vous commencer ?</p>

    <p class="d-flex justify-content-evenly">
        <a class="btn btn-primary mx-2" href="index.php?controller=post&task=add">Ajouter un post</a>
        <a class="btn btn-primary mx-2" href="index.php?controller=comment&task=showList">Gérer les commentaires</a>
        <a class="btn btn-primary mx-2" href="index.php?controller=user&task=edit&id=<?= filter_var($sessionTab['user_id'], FILTER_VALIDATE_INT) ?>">Modifier mon profil</a>
    </p>

</div>
