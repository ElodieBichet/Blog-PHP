        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="title" id="title" placeholder="Titre du post" value="<?= $post->title ?>">
            <label for="title">Titre du post</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Chapô" name="intro" id="intro"><?= $post->intro ?></textarea>
            <label for="intro">Chapô</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Contenu du post" name="content" id="content" style="height: 200px;"><?= $post->content ?></textarea>
            <label for="content">Contenu du post</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="date" id="date" placeholder="Date et heure de publication" value="<?= $post->publication_date ?>">
            <label for="date">Date et heure de publication</label>
        </div>