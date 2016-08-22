<?php function unread()
{
	global $db;
	
	$forum = intval($_GET['forum']);
	
	$verif = $db->prepare('SELECT * FROM forum_unread WHERE forum_id = ? AND user_id = ?');
	$verif->execute(array($forum, $_SESSION['id']));
	if ($verif->fetch())
	{
		$update = $db->prepare('UPDATE forum_unread SET unread = 1 WHERE forum_id = ? AND user_id= ?');
		$update->execute(array($forum,$_SESSION['id']));
	}
	else
	{
		$add = $db->prepare('INSERT INTO forum_unread VALUES("", ?, ?, 0, 1)');
		$add->execute(array($forum, $_SESSION['id']));
	}
	$curpage = ($_GET['page'] > 1)? intval($_GET['page']) : 1;
	
	$verify = $db->prepare('SELECT page FROM forum_unread WHERE user_id = ? AND forum_id = ?');
	$verify->execute(array($_SESSION['id'],$forum)); $verif = $verify->fetch();
	if ($curpage > $verif['page'])
	{
		$page = $db->prepare('UPDATE forum_unread SET page = ?');
		$page->execute(array($curpage));
	}
}
?>
