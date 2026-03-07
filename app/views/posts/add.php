<?php require APPROOT . '/views/includes/header.php'; ?>

<h2>Add Post</h2>

<form class="postForm" action="<?= URLROOT ?>/posts/add" method="post">


	<div class="field">
		<label for="title">Title</label>
		<span class="invalid-feedback">
			<?=isset($data['title']) ? $data['title'][0] : ''?>
		</span> 
		<input type="text" 
			name="title"
			id="title"
			value="<?=Input::get('title')?>" 
			class="<?=isset($data['title']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<label for="body">Content</label>
		<span class="invalid-feedback">
			<?=isset($data['body']) ? $data['body'][0] : ''?>
		</span>
		<textarea name="body"
		class="<?=isset($data['body']) ? 'is-invalid' : ''?>"
		id="body"> <?=Input::get('body')?> </textarea>
	</div>

	<div class="field">
		<a href="<?= URLROOT ?>/posts" class="btn"> Back </a>
		<input type="submit" value="Save Post" class="btn">
	</div>

	<input type="hidden" name="csrf" value="<?=CSRF::generate()?>">

</form>

<?php require APPROOT . '/views/includes/footer.php'; ?>