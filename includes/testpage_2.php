<?php function testpage_2()
{	
global $db;
	$sort = 4;
	$user = 204;
	
	$select = $db->prepare('SELECT * FROM members WHERE id = ?');
	$select->execute(array($user));
	$select = $select->fetch();
	$incan = $db->prepare('SELECT * FROM incan_list WHERE id = ?');
	$incan->execute(array($sort));
	$incan = $incan->fetch();
	
	$pm = $select['E_magique'];
	$pv = $select['E_vitale'];
	$cost = $incan['cost'];
	$points = $pm + $pv;
	
	echo $pm, ' ', $pv, ' ', $cost, ' ', $points;
	
	
	if ($points > $cost)
	{
		echo 'Ce sort peut-être lancé';
	}
	else
	{
		echo 'Le personnage n\'a pas assez de points magique et / ou vitaux pour lancer ce sort !';
	}
	
}
?>
