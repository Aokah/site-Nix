<?php function login()
{
  global $_SESSION, $_POST, $db;
  
  
	$ip = $_SERVER['REMOTE_ADDR'];
	$verif = $db->prepare('SELECT * FROM blacklist WHERE ip = ?'); $verif->execute(array($ip));
	?>
	<div class="navtitle">Connexion (Indev)</div>
		<ul class="nav">
			<li class="navbg2" style="clear: both;;list-style-type: none;">
				<?php 
				if ($verif->fetch())
				{
				?>
					Votre adresse IP figure parmis les adresses bannies, vous ne pouvez donc pas vous conneter.
				<?php 
				}
				else
				{
					if (isset($_POST['login']))
					{
						$name = htmlspecialchars($_POST['user']);
						$select = $db->prepare('SELECT * FROM members WHERE name = ?');
						$select->execute(array($name));
						if ($line = $select->fetch())
						{
							if (password_verify($_POST['pwd'], $line['password']))
							{
								if ($line['ban'] == 1)
								{
									echo "Navré, mais ce compte est banni du site.";
								}
								elseif ($line['removed'] == 1)
								{
									echo "Navré, mais ce compte a été supprimé.";
								}
								elseif ($line['end'] == 1)
								{
									echo "Navré, mais votre compte a été vérouillé après avoir eu une excellente fin, vous pouvez toujours demander un compte au même rang pour continuer à avoir accès au site.";
								}
								else
								{
									$_SESSION['connected'] = true;
									$_SESSION['name'] = $line['name'];
									$_SESSION['id'] = $line['id'];
									$_SESSION['rank'] = $line['rank'];
									$_SESSION['title'] = $line['title'];
									
									echo "Connexion effectuée <span class='name", $line['rank'],"'>", $line['name'], " !";
								}
							}
						}
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
					}
				}
				?>
			</li>
		</ul>
	<?php
}
?>
