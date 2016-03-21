<?php function members ()
{
	global $db, $_SESSION, $_GET;
	
	if (isset($_GET['search'])) {
	
	$search = intval($_GET['search']);
	$page = $db->prepare('SELECT * FROM members WHERE name = ? ORDER BY rank DESC, name ASC');
	$page->execute(array($search));
	
	}
	else
		
	{
		$linerank = 10;
		while ($linerank >= 0)
			switch ($linerank)
			{
				case 10 : $linename = "Consciences"; break; case 9 : $linename = "Titans"; break; case 8: $linename = "Dieux"; break;
				case 7: $linename = "Opérateurs"; break; case 6: $linename = "Maitres du Jeu"; break; case 5 : $linename = "Modérateurs"; break;
				case 4: $linename = "Encadrants"; break; case 3 : $linename = "Joueurs Investis"; break; case 2 : $linename = "Joueurs"; break;
				case 1: $linename = "Nouveaux"; break; case 0: $linename = "Comptes non validés"; break;
			}
		{
			echo '<p>Tableau du rang '. $linerank .' ('. $linename .').</p>';
			$linerank--;
		}
	}
} ?>
