<?php function login()
{
  global $_SESSION, $_POST, $db;
  
  
	$ip = $_SERVER['REMOTE_ADDR'];
	
	?>
	<div class="navtitle">Connexion</div>
		<ul class="nav">
			<li class="navbg2" style="clear: both;;list-style-type: none;">
				<form action="index?p=<?= $_GET['p']?>" method="POST" style="text-align:justify;">
					<label for="user">Identifiant : </label><input type="text" name="user" id="user"/><br/>
					<label for="pass">Mot de Passe : </label><input type="password"  id="pass" name="pass" /><br />
					<input type="submit" name="login" />
				</form>
			</li>
		</ul>
	<?php
}
?>
