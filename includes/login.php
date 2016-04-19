<?php function login ()
{
	global $db, $_POST, $_SESSION, $_GET;
	$wrong = false;
	$dispForm = true;

	if ($_SESSION['connected'])
	{
		if (isset($_GET['action']) && $_GET['action'] == 'disconnection')
		{ if ($_SESSION['pionier'] == 1) { $pionier = "-P";} else { $pionier = '';} if ($_SESSION['technician'] == 1) { $tech = "-T";} else { $tech = '';}
			?><div class="login">Au revoir <em class="name<?= $_SESSION['rank']?><? echo $tech?><? echo $pionier?>" ><?= $_SESSION['title']?> <?= $_SESSION['name'] ?>.</em> </div>
				<img src="/pics/logout.png" alt="" class="guild" style="text-align: center;" />
			<?php

			$_SESSION['connected'] = false;
		}
		else
		{ if ($_SESSION['pionier'] == 1) { $pionier = "-P";} else { $pionier = '';} if ($_SESSION['technician'] == 1) { $tech = "-T";} else { $tech = '';}
			?><div class="login">Vous êtes déjà connecté <em class="name<?= $_SESSION['rank']?><? echo $tech?><? echo $pionier?>"><?= $_SESSION['title']?> <?= $_SESSION['name'] ?>.</em></div></p> <?php
		}
		$dispForm = false;
	}
	else if (isset($_POST['name']) && isset($_POST['pwd']))
	{	if ($_SESSION['pionier'] == 1) { $pionier = "-P";} else { $pionier = '';}
		$answer = $db->prepare('SELECT * FROM members WHERE name = ?');
		$answer->execute(array(htmlspecialchars($_POST['name'])));

		if ($line = $answer->fetch())
		{
			if (password_verify($_POST['pwd'], $line['password']))
			{
				if ($line['ban'] == 1)
				{
					include('includes/ban_page.php'); ban_page();
				}
				elseif ($line['removed'] == 1)
				{
					include('includes/del_page.php'); del_page();
				}
				elseif ($line['end'] == 1)
				{
					include('includes/end_page.php'); end_page();
				}
				else
				{
				if ($_SESSION['pionier'] == 1) { $pionier = "-P";} else { $pionier = '';} if ($_SESSION['technician'] == 1) { $tech = "-T";} else { $tech = '';}
				$dispForm = false;

				$_SESSION['connected'] = true;
				$_SESSION['name'] = $line['name'];
				$_SESSION['id'] = $line['id'];
				$_SESSION['rank'] = $line['rank'];
				$_SESSION['title'] = $line['title'];
				$_SESSION['ban'] = $line['ban'];
				$_SESSION['removed'] = $line['removed'];
				$_SESSION['end'] = $line['end'];

				$_SESSION['alertEmail'] = ($line['activate'] != 'true') ? true : false;
				if ($_SESSION['rank'] <= 7) { $imgrank = $_SESSION['rank'];}
				elseif ($_SESSION['rank'] <=1) { $imgrank = 'low' ;}
				else { $imgrank = 'over';}
				?> 
					<p><div class="login">Bien le bonjour <em class="name<?= $_SESSION['rank']?><? echo $tech?><? echo $pionier?>"><?= $_SESSION['title']?> <?= $_SESSION['name'] ?>.</em></div></p>
					<img src="/pics/login_<? echo $imgrank ?>.png" alt="" class="guild" style="text-align: center;" />
				<?php
				}
			}
			else
			{
				$wrong= true;
				$name = $_POST['name'];
			}
		}
		else
		{
			$wrong = true;
			$name = $_POST['name'];
		}
	}
	
	if ($dispForm)
	{

	?>
	<h3>Connexion</h3>
	
	<p>
		Veuillez entre votre nom d'utilisateur ainsi que votre mot de passe afin d'accéder à votre compte.
	</p>
			
	<form method="POST" action="index.php?p=login">
		<table>
			<tr>
				<td>
					<label for="name">Nom d'utilisateur :</label>
				</td>
				<td>
					<input type="text" name="name" id="name" maxlength="30"<?php if($wrong){echo ' style="border:1px solid red;"';}
					echo (isset($name)) ? 'value="'.$name.'" ' : '';?> />
				</td>
			</tr>
			<tr>
				<td>
					<label for="pwd">Mot de passe :</label>
				</td>
				<td>
					<input type="password" name="pwd" id="pwd"<?php if($wrong){echo ' style="border:1px solid red;"';}?> />
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="submit" value="Connexion" />
					<input type="reset" value="Annuler" />
				</td>
			</tr>
			<?php if($wrong){?>
			<tr>
				<td colspan="2">
					<p class="error">Mot de passe ou identifiant incorrect.</p>
				</td>
			</tr> 
			<?php } ?>
		</table>
	</form>

	<?php
	}
}
?>
