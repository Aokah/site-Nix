<?php function testpage_3 ()
{
	global $db;
		
	echo "<h3>Forums</h3>";
	
	$view = (isset($_SESSION['rank'])) ? $_SESSION['rank'] : 0;
	
	echo $view;
}
?>
