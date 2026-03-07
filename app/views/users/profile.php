<?php require APPROOT . '/views/includes/header.php'; ?>

<h2> Update your profile! </h2>

<form class="userForm" action="<?=URLROOT?>/users/profile" method="post">

	<div class="field">
		<label for="first_name">First Name</label>
		<span class="invalid-feedback">
			<?=isset($data['first_name']) ? $data['first_name'][0] : ''?>
		</span> 
		<input type="text" 
			name="first_name"
			id="first_name"
			value="<?= Input::get('first_name') === '' ? $data['user']->first_name : Input::get('first_name') ?>" 
			class="<?=isset($data['first_name']) ? 'is-invalid' : ''?>"> 
	</div>

	<div class="field">
		<label for="last_name">Last Name</label>
		<span class="invalid-feedback">
			<?=isset($data['last_name']) ? $data['last_name'][0] : ''?>
		</span> 
		<input type="text" 
			name="last_name"
			id="last_name"
			value="<?= Input::get('last_name') === '' ? $data['user']->last_name : Input::get('last_name')?>" 
			class="<?=isset($data['last_name']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<input type="submit" value="Update">
	</div>

	<input type="hidden" name="csrf" value="<?=CSRF::generate()?>">

</form>

<?php require APPROOT . '/views/includes/footer.php'; ?>