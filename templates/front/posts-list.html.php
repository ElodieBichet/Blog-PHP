
<p>Liste des posts en front.</p>

<?php foreach ($posts as $post) : ?>

    <?= $post->title ?>

<?php endforeach; ?>
<?php var_dump($posts); ?>