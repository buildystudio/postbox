<header>
	<ul>
		<li id="logo">
			<a href="<?= URLROOT ?>">&#9993;&nbsp;<?= SITENAME ?></a>
		</li>

		<li>
			<a href="<?= URLROOT ?>">HOME</a>
		</li>

<!-- ein Benutzer ist angemeldet -->

	<?php if(Session::has('user')) : ?>

		<li>
			<a href="<?= URLROOT ?>/posts/">Posts</a>
		</li>

		<li>
			<a href="<?= URLROOT ?>/users/profile">Profile</a>
		</li>

		<li>
			<a href="<?= URLROOT ?>/users/password">Change Password</a>
		</li>

		<li>
			<a href="<?= URLROOT ?>/users/logout">Logout</a>
		</li>

	<?php else : ?>

<!-- es ist kein Benutzer angemeldet -->

		<li>
			<a href="<?= URLROOT ?>/users/register">Register</a>
		</li>

		<li>
			<a href="<?= URLROOT ?>/users/login">Login</a>
		</li>

	<?php endif; ?>

	</ul>
</header>
