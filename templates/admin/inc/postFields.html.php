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

        <div class="row col-lg-8 col-xl-6">
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="date" class="form-control" name="date" id="date" placeholder="Date de publication" value="<?= substr($post->publication_date, 0, 10) ?>" pattern="^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$">
                    <label for="date">Date de publication</label>
                </div>
            </div>
            <div class="col">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="time" id="time" placeholder="Heure de publication ('H:i:s')" value="<?= substr($post->publication_date, -8) ?>" pattern="^[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$">
                    <label for="time">Heure de publication ('H:i:s')</label>
                </div>
            </div>
        </div>