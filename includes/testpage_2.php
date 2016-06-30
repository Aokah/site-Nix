<?php function testpage_2 ()
{
	global $db; 
	
	$id = 79;
	$for =  204;
	
	$norma = $db->prepare('SELECT id, puis_norma FROM members WHERE id = ?'); $norma->execute(array($for));
	$norma = $norma->fetch();
	$incan = $db->prepare('SELECT id, norma WHERE incan_list WHERE id = ?'); $incan->execute(array($id));
	$incan = $incan->fetch();
	$result = $norma['puis_norma'] + $incan['norma']; 
	
	echo $norma['puis_norma'], ' + ', $incan['norma'], ' = ', $result;
	
}
?>
