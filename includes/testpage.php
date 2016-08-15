<?php function testpage()
{
  global $_SESSION, $_POST, $db;
  
  
	$ip = $_SERVER['REMOTE_ADDR'];
	$add = $db->prepare('UPDATE members SET ip = ? WHERE id = ?'); $add->execute(array($ip, $_SESSION['id']));
}
?>
