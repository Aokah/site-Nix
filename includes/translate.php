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
			if (isset($_POST['translate']))
			{
				$text = htmlspecialchars($_POST['text']);
			?>
				<h4>Texte d'origine</h4>
				<p><?= $text?></p>
				
				<h4>Texte transcrit</h4>
				<p style="font-family: minecraft-enchantment; src: url('minecraft-enchantment.ttf');"><?= $text?></p>
			<?php
			}
			?>
				<form action="index?p=translate" method="POST">
					<div align="center">
						<textarea name="text" placeholder="Text à transcrire."></textarea><br/>
						<input type="submit" name="translate" value="Transcrire" />
					</div>
				</form>
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
