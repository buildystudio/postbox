<?php require APPROOT . '/views/includes/header.php'; ?>

<h2>Change your password!</h2>

<form class="userForm" action="<?=URLROOT?>/users/password" method="post">

	<div class="field">
		<label for="password_current">Current password</label>
		<span class="invalid-feedback">
			<?=isset($data['password_current']) ? $data['password_current'][0] : ''?>
		</span> 
		<input type="password" 
			name="password_current"
			id="password_current"
			class="<?=isset($data['password_current']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<label for="password_new">New password</label>
		<span class="invalid-feedback">
			<?=isset($data['password_new']) ? $data['password_new'][0] : ''?>
		</span> 
		<input type="password" 
			name="password_new"
			id="password_new"
			class="<?=isset($data['password_new']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<label for="password_repeat">Repeat new password</label>
		<span class="invalid-feedback">
			<?=isset($data['password_repeat']) ? $data['password_repeat'][0] : ''?>
		</span> 
		<input type="password" 
			name="password_repeat"
			id="password_repeat"
			class="<?=isset($data['password_repeat']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<input type="submit" value="Save">
	</div>

	<input type="hidden" name="csrf" value="<?=CSRF::generate()?>">

</form>

<?php require APPROOT . '/views/includes/footer.php'; ?>