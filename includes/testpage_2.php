<?php function testpage_2()
{	
global $db;
	$sort = 5;
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
	
	echo $pm, ' ', $pv, ' ', $cost;
	
	if ($pm + $pv > $cost)
	{
		echo 'Ce sort peut-être lancé';
	}
	else
	{
		echo 'Le personnage n\'a aps assez de points magique et / ou vitaux pour lancer ce sort !';
	}
	
}
?>
