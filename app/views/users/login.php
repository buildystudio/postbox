<?php require APPROOT . '/views/includes/header.php'; ?>

<h2> Login </h2>

<form class="userForm" action="<?=URLROOT?>/users/login" method="post">

	<div class="field">
		<label for="email">Email</label>
		<span class="invalid-feedback">
			<?=isset($data['email']) ? e($data['email'][0]) : ''?>
		</span> <!-- Einträge für Validierungsfehler -->
		<input type="email" 
			name="email"
			id="email"
			value="<?=e(Input::get('email'))?>" 
			class="<?=isset($data['email']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<label for="password">Password</label>
		<span class="invalid-feedback">
			<?=isset($data['password']) ? e($data['password'][0]) : ''?>
		</span> <!-- Einträge für Validierungsfehler -->
		<input type="password" 
			name="password"
			id="password"
			value="<?=e(Input::get('password'))?>" 
			class="<?=isset($data['password']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<input type="submit" value="Login">
	</div>

	<input type="hidden" name="csrf" value="<?=CSRF::generate()?>">

	<a href="<?=URLROOT?>/users/register"> You need an account? </a>


</form>

<?php require APPROOT . '/views/includes/footer.php'; ?>