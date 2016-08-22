<?php function post()
{
	global $db;
	
	$forum = intval($_GET['forum']);
	
	$update = $db->prepare('UPDATE forum_unread SET unread = 0 WHERE forum_id = ?');
	$update->execute(array($forum));
}
?>
