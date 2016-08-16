<?php function login()
{
  global $_SESSION, $_POST, $db;
  
  
	$ip = $_SERVER['REMOTE_ADDR'];
	$verif = $db-prepare('SELECT * FROM blacklist WHERE ip = ?'); $verif->execute(array($ip));
	?>
	<div class="navtitle">Connexion (Indev)</div>
		<ul class="nav">
			<li class="navbg2" style="clear: both;;list-style-type: none;">
				<?php /*if ($verif->fetch())
				{*/
				?>
					<p>Votre adresse IP figure parmis les adresses bannies, vous ne pouvez donc pas vous conneter.</p>
				<?php /*
				}
				else
				{
				?>
					<form action="index?p=<?= $_GET['p']?>" method="POST">
						<label for="user">Identifiant : </label><input type="text" name="user" id="user"/><br/>
						<label for="pass">Mot de Passe : </label><input type="password"  id="pass" name="pass" /><br />
						<input type="submit" name="login" />
					</form>
				<?php
			*/#	}
				?>
			</li>
		</ul>
	<?php
}
?>
