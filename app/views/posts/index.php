<?php require APPROOT . '/views/includes/header.php'; ?>

<h2>Posts</h2>

<a href="<?= URLROOT ?>/posts/add" class="btn"><strong>+</strong> Add</a>

<?php foreach($data as $post) : ?>

<a href="<?=URLROOT?>/posts/show/<?= $post->id ?>" class="post">
    <p class="postTitle"> <?= e($post->title) ?></p>
    <p class="postSubTitle"> 
        posted by <strong><?= e($post->first_name) ?> <?= e($post->last_name) ?></strong> on <?= $post->created_at ?>
    </p>
</a>

<?php endforeach; ?>

<?php require APPROOT . '/views/includes/footer.php'; ?>