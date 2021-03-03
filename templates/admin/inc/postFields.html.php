        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="title" id="title" placeholder="Titre du post" value="<?= $post->title ?>" required>
            <label for="title">Titre du post</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Chapô" name="intro" id="intro" required><?= $post->intro ?></textarea>
            <label for="intro">Chapô</label>
        </div>

        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Contenu du post" name="content" id="content" style="height: 200px;" required><?= $post->content ?></textarea>
            <label for="content">Contenu du post</label>
        </div>

        <div class="col col-md-10 col-lg-8">
            <div class="input-group input-group-sm mb-3">
                <span class="input-group-text">Date et heure de publication</span>
                <input type="date" class="form-control w-25" name="date" id="date" value="<?= substr($post->publication_date, 0, 10) ?>" pattern="^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$">
                <input type="text" class="form-control w-25" name="time" id="time" placeholder="00:00:00" value="<?= substr($post->publication_date, -8) ?>" pattern="^[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$">
            </div>
        </div>