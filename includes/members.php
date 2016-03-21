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
		{
			echo '<p>Tableau du rang '. $linerank .'.</p>';
			$linerank--;
		}
	}
} ?>
