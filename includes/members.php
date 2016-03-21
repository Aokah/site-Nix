<?php function members ()
{
	global $db, $_SESSION;
	
	if ($_SESSION['rank'] > 5) {
		
		
	}
	else { echo '<p>Maintenance en cours.</p>'; }
} ?>
