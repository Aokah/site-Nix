<?php function testpage_2()
{	
global $db;
	$sort = 1;
	$user = 1;
	
	$select = $db->prepare('SELECT m.E_magique, m.E_vitale, m.id, ig.incan_id, ig.user_id, il.id AS sort, il.cost
	FROM incan_get ig
	RIGHT JOIN members m ON m.id = ig.user_id
	LEFT JOIN incan_list il ON ig.incan_id = il.id
	WHERE ig.user_id = ? AND ig.incan_id = ?');
	$select->execute(array($user, $sort));
	
}
?>
