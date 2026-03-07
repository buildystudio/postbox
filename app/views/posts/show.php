<?php require APPROOT . '/views/includes/header.php'; ?>

<h2><?= $data['post']->title ?></h2>

<p class="author"> by <?= $data['user']->first_name ?> <?= $data['user']->last_name ?></p>

<p class="postBody"><?= $data['post']->body ?></p>

<a href="<?= URLROOT ?>/posts" class="btn light"> Back </a>

<?php if(Session::get('user') === $data['user']->id) : ?>

	<a href="<?= URLROOT ?>/posts/edit/<?= $data['post']->id ?>" class="btn light edit">Edit</a>

	<form class="deleteForm" action="<?= URLROOT ?>/posts/delete/<?= $data['post']->id ?>" method="post">

		<input type="submit" name="delete" value="Delete" class="btn">

		<input type="hidden" name="csrf" value="<?=CSRF::generate()?>">

	</form>

<?php endif; ?>

<?php require APPROOT . '/views/includes/footer.php'; ?>