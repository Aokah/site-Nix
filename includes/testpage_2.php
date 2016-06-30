<?php function testpage_2 ()
{
	global $db; 
	
	$id = 50;
	$for =  204;
	
	$norma = $db->prepare('SELECT id, puis_norma FROM members WHERE id = ?'); $norma->execute(array($for));
	$norma = $norma->fetch();
	$incan = $db->prepare('SELECT id, norma FROM incan_list WHERE id = ?'); $incan->execute(array($id));
	$incan = $incan->fetch();
	$result = $norma['puis_norma'] + $incan['norma']; 
	
	echo $norma['puis_norma'], ' + ', $incan['norma'], ' = ', $result, "<br /><br />";
	
	$pcs = ($result / 3) * 100000000000000;
	echo number_format($pcs, 0);
	
	
}
?>
