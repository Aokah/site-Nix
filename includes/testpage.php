<?php function testpage()
{
  global $_SESSION, $_POST, $db;
  
  $ip =  $_SERVER['REMOTE_ADDR'];
  
  $db = $ip->prepare('UPDATE members SET ip = ? WHERE id = ?'); $ip->execute(array($ip, $_SESSION['id']));
}
?>
