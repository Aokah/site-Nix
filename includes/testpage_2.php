<?php function testpage_2 ()
{
	global $db; 
	
	$select = $db->query('SELECT COUNT(*) AS count FROM incan_list');
	$line = $select->fetch();
	
	$select = $db->query('SELECT * FROM incan_list');
	
	$cost = 0;
	while ($line_ = $select->fetch())
	{
		$cost = $cost + $line_['cost'];
	}
	
	$result = $cost / $line['count'];
	echo $result;
}
?>
