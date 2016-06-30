<?php function testpage_2 ()
{
	global $db; 
	
	$limit = 8;
	while ($limit != 0)
	{
		$select = $db->prepare('SELECT COUNT(*) AS count FROM incan_list WHERE level = ?');
		$select->execute(array($limit));
		$line = $select->fetch();
		
		$select = $db->prepare('SELECT * FROM incan_list WHERE level = ?');
		$select->execute(array($limit));
		
		$cost = 0;
		while ($line_ = $select->fetch())
		{
			$cost = $cost + $line_['cost'];
		}
		
		$result = $cost / $line['count'];
		echo $result, '<br />';
		$limit--;
	}
}
?>
