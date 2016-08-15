<?php function search_ip()
{
global $db, $_POST;
	
	if ($_SESSION['connected'])
	{
		if ($_SESSION['rank'] > 4)
		{
			$ipcount = $db->query('SELECT COUNT(*) AS ipok FROM members WHERE ip != "Inconnue" '); $ip = $ipcount->fetch();
			$globalcount = $db->query('SELECT COUNT(*) AS global FROM members WHERE pnj = 0 AND rank < 8');
			$global = $globalcount->fetch();
			?>
				<h3>Recherche de compte par IP</h3>
				<p>Actuellement, <?= $ip['ipok'] ?> Comptes sur <?= $global['global']?> sont répertoriés sur le site.</p>
				<p>Ici vous pourrez lister les comptes partageant la même adresse IP.</p>
					<form action="index?p=ipsearch" method="POST">
						<label for="ip">Adresse à rechercher : </label>
						<input type="text" name="ip" id="ip" /> 
						<input type="submit" name="search" value="Rechercher" />
					</form>
				<?php if (isset($_POST['search']))
				{
					$ip = htmlspecialchars($_POST['ip']);
					echo $ip;
					$search = $db->prepare('SELECT * FROM members WHERE ip = ? AND id != 36 ORDER BY name ASC'); $search->execute(array($ip));
				?>
					<p>
					<?php
					while ($line = $search->fetch())
					{
						echo '<span class="name', $line['rank'],'">', $line['name'],' </span>, ';
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
