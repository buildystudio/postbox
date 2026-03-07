<div>
	<?php

		if(Session::has('success')) echo '<p class="success">' . Session::flash('success') . '</p>';
		if(Session::has('error')) echo '<p class="error">' . Session::flash('error') . '</p>';
	?>

</div>