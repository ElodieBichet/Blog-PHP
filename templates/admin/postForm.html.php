
<div>
    <?= $alert ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>?controller=post&task=add" method="POST">

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="title" id="title" placeholder="Titre du post">
            <label for="title">Titre du post</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Chapô" name="intro" id="intro"></textarea>
            <label for="intro">Chapô</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Contenu du post" name="content" id="content" style="height: 200px;"></textarea>
            <label for="content">Contenu du post</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="date" id="date" placeholder="Date et heure de publication">
            <label for="date">Date et heure de publication</label>
        </div>

        <button type="submit" name="save" class="btn btn-primary">Enregistrer</button>
        <button type="submit" name="saveAsDraft" class="btn btn-secondary">Enregistrer comme brouillon</button>

    </form>
</div>