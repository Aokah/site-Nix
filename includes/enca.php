<?php function enca ()
{
	global $_SESSION, $db, $_GET, $_POST;
	
	if ($_SESSION['connected'])
	{
		if ($_SESSION['rank'] >= 4)
		{
			echo '<h3>Registre d\'Encadrement</h3>';
			
			if (isset($_GET['search']))
			{
				$search = htmlspecialchars($_GET['search']);
				$presel = $db->prepare('SELECT id, name FROM members WHERE name = ?'); $presel->execute(array($search));
				$presel = $presel->fetch();
				$enca = $db->prepare('SELECT * FROM enca WHERE sender_id = ? ORDER BY date ASC'); $enca->execute(array($presel['id']));
			}
			else
			{
				$enca = $db->query('SELECT * FROM enca ORDER BY date ASC');
			}
			
			
			while ($line = $enca->fetch())
			{
				
			}
		}
		else
		{
			echo '<p>Navré mais vous ne possédez pas les accès suffisants pour accéder à cette page.</p>';
		}
	}
	else
	{
		echo '<p>Vous devez être connecté pour accéder à cette page.</p>';
	}
}
?>
