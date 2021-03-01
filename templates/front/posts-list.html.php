
<p>Liste des posts en front.</p>

<ul>
    <?php foreach ($posts as $post) : ?>

        <li><?= $post->title ?></li>

    <?php endforeach; ?>
</ul>
