<?php function testpage_2 ()
{
	global $db; 
	
	$reset = $db->query('UPDATE `members` SET "specialisation" = "Inconnue", "spe_2" = "Inconnue" WHERE rank < 8 AND pnj = 0');
	$restart = $db->query('UPDATE `members` SET magie_rank = 0 WHERE rank < 8 AND pnj = 0');
	$pcs = $db->query('UPDATE `members` SET exp = 5 WHERE rank < 8 AND pnj = 0');
	$pnj = $db->query('UPDATE `members` SET exp = 999 WHERE rank > 7 OR pnj = 1');
}
?>
