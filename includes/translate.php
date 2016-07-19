<?php function translate()
{
global $db, $_POST;
	
	if ($_SESSION['connected'])
	{
		if ($_SESSION['rank'] >= 5)
		{
			?>
				<h3>Transcription Galactique</h3>
				<p>Ici vous pourrez transcrires vos textes de l'alphabet commun à l'alphabet Galactique.</p>
			<?php
		}
		else
		{
			echo '<p>Vous n\'avez pas le grade suffisant pour accéder à cette page.</p>';
		}
	}
	else
	{
		echo '<p>Vous devez être connecté pour accéder à cette page.</p>';
	}
}
?>
