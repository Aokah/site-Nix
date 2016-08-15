<?php function search_ip()
{
global $db, $_GET;
	
	if ($_SESSION['connected'])
	{
		if ($_SESSION['rank'] > 4)
		{
			?>
				<h3>Recherche de compte par IP</h3>
				<p>Ici vous pourrez lister les comptes partageant la même adresse IP.</p>
				<p>
					<form action="index?p=ipsearch" method="POST">
						<label for="ip">Adresse à rechercher : </label>
						<input type="text" name="ip" id="ip" /> 
						<input type="submit" name="search" value="Rechercher" />
					</form>
				</p>
				<?php if (isset($_POST['search']))
				{
					$ip = htmlspecialchars($_POST['ip']);
					echo $ip;
					$search = $db->prepare('SELECT * FROM members WHERE ip = ? ORDER BY name ASC'); $search->execute(array($ip));
				?>
					<p>
					<?php
					while ($line = $search->fetch)
					{echo "lol";
						echo '<span class="name', $line['rank'],'">', $line['name'], ' </span>';
					}
					echo '</p>';
				}
		}
		else
		{
			echo "Vous ne possédez pas le grade suffisant pour accéder à cette page.";
		}
	}
	else
	{
		echo "Vous devez vous connecter pour avoir accès à cette page.";
	}
}
?>
