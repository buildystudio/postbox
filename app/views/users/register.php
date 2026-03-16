<?php require APPROOT . '/views/includes/header.php'; ?>

<h2> Join the community! </h2>

<form class="userForm" action="<?=URLROOT?>/users/register" method="post">

	<div class="field">
        <label for="first_name">First Name</label>
        <span class="invalid-feedback">
            <?=isset($data['first_name']) ? e($data['first_name'][0]) : ''?>
        </span> 
        <input type="text" 
            name="first_name"
            id="first_name"
            value="<?= e(Input::get('first_name')) ?>" 
            class="<?=isset($data['first_name']) ? 'is-invalid' : ''?>"> 
    </div>

	<div class="field">
		<label for="last_name">Last Name</label>
		<span class="invalid-feedback">
			<?=isset($data['last_name']) ? e($data['last_name'][0]) : ''?>
		</span> <!-- Einträge für Validierungsfehler -->
		<input type="text" 
			name="last_name"
			id="last_name"
			value="<?=e(Input::get('last_name'))?>" 
			class="<?=isset($data['last_name']) ? 'is-invalid' : ''?>">
	</div>

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
		<label for="confirm_password">Confirm Password</label>
		<span class="invalid-feedback">
			<?=isset($data['confirm_password']) ? e($data['confirm_password'][0]) : ''?>
		</span> <!-- Einträge für Validierungsfehler -->
		<input type="password" 
			name="confirm_password"
			id="confirm_password"
			value="<?=e(Input::get('confirm_password'))?>" 
			class="<?=isset($data['confirm_password']) ? 'is-invalid' : ''?>">
	</div>

	<div class="field">
		<input type="submit" value="Register">
	</div>

	<input type="hidden" name="csrf" value="<?=CSRF::generate()?>">

	<a href="<?=URLROOT?>/users/login"> You already have an account? </a>


</form>

<?php require APPROOT . '/views/includes/footer.php'; ?>